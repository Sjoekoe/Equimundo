<?php
namespace EQM\Http\Controllers\Admin;

use Carbon\Carbon;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseRepository;

class HorseController extends Controller
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    public function __construct(HorseRepository $horses)
    {
        $this->horses = $horses;
    }

    public function index()
    {
        $horses = $this->horses->paginated(10);
        $horseData = $this->collectHorseData();
        $horseGrowth = $this->getHorseGrowth();

        return view('admin.horses.index', compact('horses', 'horseData', 'horseGrowth'));
    }

    /**
     * @return array
     */
    private function collectHorseData()
    {
        $month = 30;
        $result = [];

        for ($i = $month; $i >= 0; $i--) {
            $date = Carbon::now()->subDay($i);
            $start = Carbon::now()->subDay($i)->startOfDay();
            $end = Carbon::now()->subDay($i)->endOfDay();
            $count = $this->horses->findCountByDate($start, $end);

            $result[] = [
                'date' => $date->format('Y-m-d'),
                'horses' => $count
            ];
        }

        return $result;
    }

    private function getHorseGrowth()
    {
        $month = 30;
        $result = [];

        for ($i = $month; $i >= 0; $i--) {
            $date = Carbon::now()->subDay($i);
            $end = Carbon::now()->subDay($i)->endOfDay();
            $count = $this->horses->findCreatedHorsesBeforeDate($end);

            $result[] = [
                'date' => $date->format('Y-m-d'),
                'horses' => $count
            ];
        }

        return $result;
    }
}
