<?php
namespace EQM\Http\Controllers\Api;

use EQM\Api\Horses\HorseTransformer;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Users\User;
use Input;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

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
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $horses = $user->horses();
        $collection  = new Collection($horses, new HorseTransformer());

        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function show(Horse $horse)
    {
        $manager = new Manager();

        if (Input::has('include')) {
            $manager->parseIncludes(Input::get('include'));
        }

        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($horse, new HorseTransFormer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }
}
