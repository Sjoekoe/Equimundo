<?php
namespace EQM\Core\Slugs;

use EQM\Models\Horses\HorseRepository;
use Illuminate\Support\Str;

class SlugCreator
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    function __construct(HorseRepository $horses)
    {
        $this->horses = $horses;
    }

    /**
     * @param string $title
     * @return string
     */
    public function createForHorse($title)
    {
        $slug = Str::slug($title);
        $slugCount = $this->horses->findSlugCounts($slug);

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}
