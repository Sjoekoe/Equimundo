<?php
namespace EQM\Http\Controllers\Api;

use EQM\Api\Horses\HorseTransformer;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use Input;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

class HorseController extends Controller
{
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
