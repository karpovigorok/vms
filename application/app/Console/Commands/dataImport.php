<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from Json File.';

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
     * @return mixed
     */
    public function handle()
    {
        $this->argument('file');
        print "OK";
    }
}
