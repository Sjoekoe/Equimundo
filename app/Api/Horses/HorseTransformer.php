<?php
namespace EQM\Api\Horses;

use EQM\Api\Pictures\PictureTransformer;
use EQM\Api\Statuses\StatusTransformer;
use EQM\Models\Horses\Horse;
use League\Fractal\TransformerAbstract;

class HorseTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'statuses',
        'pictures'
    ];

    public function transform(Horse $horse)
    {
        return [
            'id' => $horse->id(),
            'name' => $horse->name(),
            'life_number' => $horse->lifeNumber(),
            'date_of_birth' => $horse->dateOfBirth() ? $horse->dateOfBirth()->toIso8601String() : null,
            'gender' => (int) $horse->gender(),
            'height' => $horse->height(),
            'breed' => (int) $horse->breed(),
            'color' => (int) $horse->color(),
            'slug' => $horse->slug(),
            'profile_picture' => $horse->getProfilePicture() ? route('file.picture', $horse->getProfilePicture()->id()) : asset('images/eqm.png')
        ];
    }

    public function includeStatuses(Horse $horse)
    {
        return count($horse->statuses()) ? $this->collection($horse->statuses(), new StatusTransformer()) : null;
    }

    public function includePictures(Horse $horse)
    {
        return count($horse->pictures()) ? $this->collection($horse->pictures(), new PictureTransformer()) : null;
    }
}
