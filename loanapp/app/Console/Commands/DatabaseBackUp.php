<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup Database daily';

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
        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";
        $path = storage_path()."/app/backup/";
         $command = sprintf('mysqldump -h %s -u %s -p\'%s\' %s > %s', $host, $username, $password, $database, $path . $filename);
        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
    }
}
