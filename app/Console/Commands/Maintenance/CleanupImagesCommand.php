<?php

namespace App\Console\Commands\Maintenance;

use App\Models\Recipes\Recipe;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as IlluminateCollection;

class CleanupImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:images
        {--filesystem : Scan filesystem and get orphaned images ; With --fix, orphaned images will be deleted}
        {--database : Scan database and get orphaned entries ; With --fix, orphaned entries will be deleted}
        {--fix : Fix all issues}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup orphaned images or database entries. This command only deletes stuff!';

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

        $this->line("");

        if ($this->option('filesystem')) {
            $this->scanAndFixFilesystem($query);
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
            $orphaned = collect($recipe->photos)->sort()->values();
            $remaining = collect($recipe->photos)->sort()->values();

            $files = \Storage::disk('recipe_images')->files($recipe->id);
            foreach ($files as $file) {
                $file = \Str::after($file, "{$recipe->id}/");
                $orphaned->forget($orphaned->search($file));
            }

            foreach ($orphaned as $photo) {
                $remaining->forget($remaining->search($photo));
            }

            $count = $orphaned->count();
            if ($count) {
                $this->line("  ID {$recipe->id}: found {$count} orphaned " . \Str::plural('entry', $count));
            }

            $update = null;
            if ($remaining->count()) {
                $update = $remaining->toArray();
            }

            if ($this->option('fix') && $count) {
                $this->info("Delete orphaned photos in recipe {$recipe->id}");
                $recipe->update(['photos' => $update]);
            }
        });
    }

    /**
     * Loop through all folders and remove orphaned files and folders
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scanAndFixFilesystem(Builder $query): void
    {
        $remaining = $this->scanAndFixDirectories($query);

        $this->line('');

        $this->scanAndFixFiles($query, $remaining);
    }

    private function scanAndFixDirectories(Builder $query): array
    {
        $this->line('Scan directories');

        $directories = collect(\Storage::disk('recipe_images')->directories());
        $orphaned = $directories = collect(\Storage::disk('recipe_images')->directories());

        $orphaned->forget($query->pluck('id')->toArray());

        $count = $orphaned->count();
        $this->line("Found {$count} orphaned " . \Str::plural('directory', $count));

        if ($this->option('fix') && $count) {
            $this->info('Delete orphaned directories ' . $orphaned->join(', '));
            $orphaned->each(function ($directory) {
                \Storage::disk('recipe_images')->deleteDirectory($directory);
            });
        }

        foreach ($orphaned as $directory) {
            $directories->forget($directories->search($directory));
        }

        return $directories->toArray();
    }

    private function scanAndFixFiles(Builder $query, array $directories): void
    {
        $this->line('Scan files');

        if (!$directories) {
            $this->line('No files found');
            return;
        }

        $query->each(function ($recipe) {
            $files = collect();
            foreach (\Storage::disk('recipe_images')->files($recipe->id) as $file) {
                $files->push(\Str::after($file, "{$recipe->id}/"));
            }

            foreach ($recipe->photos as $photo) {
                $files->forget($files->search($photo));
            }

            $count = $files->count();
            $this->line("Found {$count} orphaned " . \Str::plural('file', $count));

            if ($this->option('fix') && $count) {
                $files->each(function ($file) use ($recipe) {
                    $this->info("  Delete orphaned files {$file}");
                    \Storage::disk('recipe_images')->delete("{$recipe->id}/{$file}");
                });
            }
        });
    }
}
