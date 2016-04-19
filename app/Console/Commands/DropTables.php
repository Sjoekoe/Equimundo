<?php namespace EQM\Console\Commands;

use DB;
use Illuminate\Console\Command;

class DropTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'droptables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $colname = 'Tables_in_' . env('DB_DATABASE');

        $tables = DB::select('SHOW TABLES');

        foreach($tables as $table) {

            $droplist[] = $table->$colname;

        }
        $droplist = implode(',', $droplist);

        DB::beginTransaction();

        DB::raw('SET foreign_key_checks = 0;');
        //turn off referential integrity
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement("DROP TABLE $droplist");
        //turn referential integrity back on
        //DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        DB::commit();

        $this->comment(PHP_EOL."If no errors showed up, all tables were dropped".PHP_EOL);

    }
}
