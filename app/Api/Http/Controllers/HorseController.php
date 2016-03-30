<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Horses\HorseTransformer;
use EQM\Api\Http\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Users\User;
use Input;

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

    public function index(User $user)
    {
        $horses = collect($user->horses());
        
        return $this->response()->collection($horses, new HorseTransformer());
    }

    public function show(Horse $horse)
    {
        return $this->response()->item($horse, new HorseTransformer());
    }
}
