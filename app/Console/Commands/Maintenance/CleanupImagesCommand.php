<?php

namespace App\Console\Commands\Maintenance;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CleanupImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:images
        {--filesystem : Scan the filesystem. Delete orphaned files with --fix}
        {--database : Scan database. Delete orphaned entries with --fix}
        {--fix : Fix all issues. You should create a backup first.}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and/or delete orphaned files and db entries';

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
        if ($this->option('filesystem')) {
            $this->scanAndFixFiles();
            $this->executed = true;
        }

        if ($this->option('database')) {
            $this->newLine();
            $this->scanAndFixDatabase();
            $this->executed = true;
        }

        if (!$this->executed) {
            $this->error('No option specified!');
            return 1;
        }

        return 0;
    }

    /**
     * Storage disk where the photos are saved
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    private static function disk(): Filesystem
    {
        return \Storage::disk('recipe_photos');
    }

    /**
     * Loop through directories and delete orphaned files
     *
     * @return void
     */
    private function scanAndFixFiles(): void
    {
        $this->line('Scan files...');

        $directories = collect(self::disk()->directories());
        $media = Media::get();

        $toDelete = $directories->filter(function ($directory) use ($media) {
            return $media->find($directory) === null;
        });

        $count = $toDelete->count();

        if (!$count) {
            $this->info('No orphaned folders found');
            return;
        }

        $textFolders = \Str::plural('folder', $count);
        $this->line("Found {$count} orphaned {$textFolders}");

        if (!$this->option('fix')) {
            $this->info('(provide --fix to delete folders)');
            return;
        }

        $this->info("Delete orphaned {$textFolders}...");
        $this->withProgressBar($toDelete, function ($directory) {
            self::disk()->deleteDirectory($directory);
        });
        $this->newLine();
    }

    /**
     * Loop through recipes and delete orphaned entries
     *
     * @return void
     */
    public function scanAndFixDatabase(): void
    {
        $this->line('Scan database...');

        $directories = collect(self::disk()->directories());
        $media = Media::get();

        $toDelete = $media->filter(function ($media) use ($directories) {
            return $directories->search($media->id) === false;
        });

        $count = $toDelete->count();

        if (!$count) {
            $this->info('No orphaned entries found');
            return;
        }

        $textEntries = \Str::plural('entry', $count);
        $this->line("Found {$count} orphaned {$textEntries}");

        if (!$this->option('fix')) {
            $this->info('(provide --fix to delete entries)');
            return;
        }

        $this->info("Delete orphaned {$textEntries}...");
        $this->withProgressBar($toDelete, function ($media) {
            $media->delete();
        });
        $this->newLine();
    }
}
