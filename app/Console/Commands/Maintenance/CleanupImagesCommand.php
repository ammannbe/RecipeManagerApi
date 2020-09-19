<?php

namespace App\Console\Commands\Maintenance;

use App\Models\Recipes\Recipe;
use Illuminate\Console\Command;

class CleanupImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:images
        {--files : Scan filesystem and get orphaned images ; With --fix, orphaned images will be imported}
        {--directories : Scan filesystem and get orphaned directories ; With --fix, orphaned directories will be deleted}
        {--database : Scan database and get orphaned entries ; With --fix, orphaned entries will be deleted}
        {--fix : Fix all issues}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import orphaned images and/or delete orphaned directories/database entries';

    /**
     * Minimum one command is executed
     *
     * @var bool
     */
    private $executed = false;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('files')) {
            $this->scanAndFixFiles();
            $this->info('Done');
            $this->executed = true;
        }

        if ($this->option('directories')) {
            $this->line('');
            $this->scanAndFixDirectories();
            $this->info('Done');
            $this->executed = true;
        }

        if ($this->option('database')) {
            $this->line('');
            $this->scanAndFixDatabase();
            $this->info('Done');
            $this->executed = true;
        }

        return 0;
    }

    /**
     * Loop through directories and import orphaned files
     *
     * @return void
     */
    private function scanAndFixFiles(): void
    {
        $this->line('Scan files');

        $directories = collect(\Storage::disk('recipe_images')->directories());
        $recipes = Recipe::get();

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

    /**
     * Loop through directories and delete orphaned entries
     *
     * @return void
     */
    private function scanAndFixDirectories(): void
    {
        $this->line('Scan directories');

        $directories = collect(\Storage::disk('recipe_images')->directories());
        $recipeIds = Recipe::pluck('id');

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
     * Loop through recipes and delete orphaned entries
     *
     * @return void
     */
    public function scanAndFixDatabase(): void
    {
        $this->line('Scan database');

        Recipe::whereNotNull('photos')->each(function ($recipe) {
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
}
