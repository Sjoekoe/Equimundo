<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\HorseStatusTransformer;
use EQM\Api\Statuses\StatusTransformer;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\StatusRepository;
use Input;

class HorseStatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    public function __construct(StatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    public function index(Horse $horse)
    {
        $statuses = $this->statuses->findFeedForHorsePaginated($horse, Input::get('limit', 10));

        return $this->response()->paginator($statuses, new HorseStatusTransformer());
    }
}
