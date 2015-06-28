<?php
namespace HorseStories\Models\Palmares;

use DateTime;

class PalmaresUpdater
{
    /**
     * @param \HorseStories\Models\Palmares\Palmares $palmares
     * @param array $values
     */
    public function update(Palmares $palmares, $values)
    {
        $palmares->discipline = $values['discipline'];
        $palmares->level = $values['level'];
        $palmares->ranking = $values['ranking'];
        $palmares->date = DateTime::createFromFormat('d/m/Y', $values['date']);
        $palmares->event->name = $values['event_name'];

        $palmares->save();
    }
}
