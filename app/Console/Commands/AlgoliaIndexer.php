<?php
namespace EQM\Console\Commands;

use DB;
use EQM\Core\Search\SearchEngine;
use EQM\Models\Horses\HorseRepository;
use Illuminate\Console\Command;

class AlgoliaIndexer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eqm:search-index {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes a table and sends it to an indice in algolia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HorseRepository $horses)
    {
        parent::__construct();

        $this->horses = $horses;
    }

    public function handle(SearchEngine $search)
    {
        $table = $this->argument('table');

        $collection = collect(
            DB::table($table)->get()
        )->map(function($item) {
            $item->objectID = $item->id;

            return (array) $item;
        });

        $search->index($table)->saveObjects($collection);

        $this->info('All done');
    }
}
