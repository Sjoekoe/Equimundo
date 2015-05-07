<?php
namespace HorseStories\Models\Palmares;

use HorseStories\Models\Horses\Horse;

class PalmaresRepository
{
    public function getPalmaresForHorse(Horse $horse)
    {
        return Palmares::with('event')->where('horse_id', $horse->id)->orderBy('date', 'desc')->get();
    }
}