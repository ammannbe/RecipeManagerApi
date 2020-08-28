<?php

namespace App\Console\Commands\Maintenance;

use App\Models\Recipes\Recipe;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class CleanupImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:images
        {--database : Scan database and get orphaned entries ; With --fix, orphaned entries will be deleted}
        {--directories : Scan filesystem and get orphaned directories ; With --fix, orphaned directories will be deleted}
        {--files : Scan filesystem and get orphaned images ; With --fix, orphaned images will be imported}
        {--fix : Fix all issues}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup orphaned images or database entries.!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = Recipe::whereNotNull('photos');

        if ($this->option('database')) {
            $this->scanAndFixDatabase($query);
        }

        if ($this->option('directories')) {
            $this->line('');
            $this->scanAndFixDirectories($query);
        }

        if ($this->option('files')) {
            $this->line('');
            $this->scanAndFixFiles($query);
        }

        return 0;
    }

    /**
     * Loop through recipes and delete orphaned entries
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scanAndFixDatabase(Builder $query): void
    {
        $this->line('Scan database');

        $query->each(function ($recipe) {
            $files = \Storage::disk('recipe_images')->files($recipe->id);
            $files = collect($files)->map(function ($file) use ($recipe) {
                return \Str::after($file, "{$recipe->id}/");
            });

            $photos = collect($recipe->photos)->filter(function ($photo) use ($files) {
                return $files->search($photo) !== false;
            });

            $diff = collect($recipe->photos)->diff($photos);

            if ($count = $diff->count()) {
                $this->line("  ID {$recipe->id}: found {$count} orphaned " . \Str::plural('entry', $count));

                if ($count && $this->option('fix')) {
                    $this->info("Delete orphaned photos in recipe {$recipe->id}");
                    $recipe->update(['photos' => $photos->toArray()]);
                }
            }
        });
    }

    /**
     * Loop through directories and delete orphaned entries
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    private function scanAndFixDirectories(Builder $query): void
    {
        $this->line('Scan directories');

        $directories = collect(\Storage::disk('recipe_images')->directories());
        $recipeIds = $query->pluck('id');

        $orphaned = $directories->filter(function ($id) use ($recipeIds) {
            return $recipeIds->search($id) === false;
        });

        if ($count = $orphaned->count()) {
            $this->line("  Found {$count} orphaned " . \Str::plural('entry', $count));

            if ($count && $this->option('fix')) {
                $this->info("Delete orphaned directories");

                $orphaned->each(function ($directory) {
                    \Storage::disk('recipe_images')->deleteDirectory($directory);
                });
            }
        }
    }

    /**
     * Loop through directories and delete orphaned entries
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    private function scanAndFixFiles(Builder $query): void
    {
        $this->line('Scan files');

        $directories = collect(\Storage::disk('recipe_images')->directories());
        $recipes = $query->get();

        $directories->each(function ($id) use ($recipes) {
            /** @var \App\Models\Recipes\Recipe|null $recipe */
            $recipe = $recipes->find($id);
            if (!$recipe) {
                return;
            }

            $photos = collect($recipe->photos);

            $files = \Storage::disk('recipe_images')->files($id);
            $orphaned = collect($files)->map(function ($file) use ($id) {
                return \Str::after($file, "{$id}/");
            })->filter(function ($file) use ($photos) {
                return $photos->search($file) === false;
            });

            $update = $orphaned->merge($photos);

            if ($count = $orphaned->count()) {
                $this->line("  ID {$recipe->id}: found {$count} orphaned " . \Str::plural('entry', $count));

                if ($count && $this->option('fix')) {
                    $this->info("Imported orphaned photos in recipe {$recipe->id}");
                    $recipe->update(['photos' => $update]);
                }
            }
        });
    }
}
