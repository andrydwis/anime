<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DeployApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the deployment script for Laravel application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Deployment Script...');

        // Start timer to calculate the total time
        $startTime = microtime(true);

        if (config('app.env') == 'local') {
            $this->executeShellCommand('Pulling latest changes', ['git', 'pull']);
            $this->executeShellCommand('Installing Composer dependencies', ['composer', 'install', '--no-interaction']);
            $this->executeShellCommand('Installing npm packages', ['npm', 'install']);
            $this->executeShellCommand('Building assets', ['npm', 'run', 'build']);
            $this->executeShellCommand('Clearing optimization cache', ['php', 'artisan', 'optimize:clear']);
            $this->executeShellCommand('Optimizing application', ['php', 'artisan', 'optimize']);
        } else {
            $this->executeShellCommand('Pulling latest changes', ['sudo', 'git', 'pull']);
            $this->executeShellCommand('Installing Composer dependencies', ['sudo', 'composer', 'install', '--no-interaction']);
            $this->executeShellCommand('Installing npm packages', ['npm', 'install']);
            $this->executeShellCommand('Building assets', ['npm', 'run', 'build']);
            $this->executeShellCommand('Clearing optimization cache', ['sudo', 'php', 'artisan', 'optimize:clear']);
            $this->executeShellCommand('Optimizing application', ['sudo', 'php', 'artisan', 'optimize']);
        }

        // Calculate and display the total time taken
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $this->info('🚀 Deployment Completed Successfully! 🎉');
        $this->info('⏱️ Total deployment time: '.round($executionTime, 2).' seconds.');
    }

    public function executeShellCommand($description, array $command)
    {
        $this->line("⏳ {$description}...");
        $process = new Process($command);
        $process->setTimeout(600); // Set timeout (optional)
        $process->run();

        if (! $process->isSuccessful()) {
            $this->error("❌ Failed: {$description}");
            throw new ProcessFailedException($process);
        }

        $this->info("✅ Success: {$description}");
    }
}
