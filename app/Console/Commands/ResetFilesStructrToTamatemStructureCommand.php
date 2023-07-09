<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetFilesStructrToTamatemStructureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-files-structr-to-original-structure-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset files structure to tamatem structure';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting files structure to tamatem structure...');

        $publicFiles = collect(scandir(public_path('files')))->reject(function ($file) {
            return in_array($file, ['.', '..']);
        });

        $progressBar = $this->output->createProgressBar(1000);
        $progressBar->start();
        $publicFiles->each(function ($file) use ($progressBar) {
            $fileGroupPath = public_path('files/' . $file);
            if (!file_exists($fileGroupPath)) {
                return;
            }
            $fileGroup = collect(scandir($fileGroupPath))->reject(function ($file) {
                return in_array($file, ['.', '..']);
            });
            $fileGroup->each(function ($file) use ($progressBar, $fileGroupPath) {
                rename($fileGroupPath . '/' . $file, public_path('files/' . $file));
                $progressBar->advance();
            });
            rmdir($fileGroupPath);
        });
        $progressBar->finish();
        $this->info("\nFiles structure reset successfully.");
    }
}
