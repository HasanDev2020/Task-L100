<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertFilesStructrToTamatemStructureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-files-structr-to-tamatem-structure-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'convert files structure to tamatem structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Converting files structure to tamatem structure...');

        // get all files in public/files directory
        $publicFiles = collect(scandir(public_path('files')))->reject(function ($file) {
            return in_array($file, ['.', '..']);
        });

        $progressBar = $this->output->createProgressBar(1000);
        $progressBar->start();

        // group files by explode file name and get first index for group name and capitalize first letter
        $files = $publicFiles->groupBy(function ($file) {
            $fileGroupName = explode('-', $file)[0];
            return ucfirst(substr($fileGroupName, 0));
        });

        // loop through files and move them to their new directory
        $files->each(function ($fileGroup, $fileGroupName) use ($progressBar) {
            $fileGroup->each(function ($file) use ($progressBar, $fileGroupName) {
                $fileGroupPath = public_path('files/' . $fileGroupName);
                if (!file_exists($fileGroupPath)) {
                    mkdir($fileGroupPath, 0777, true);
                }
                rename(public_path('files/' . $file), $fileGroupPath . '/' . $file);
                $progressBar->advance();
            });
        });

        $progressBar->finish();
        $this->info("\nFiles structure converted successfully.");
    }
}
