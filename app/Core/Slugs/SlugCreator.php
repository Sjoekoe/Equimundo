<?php 
namespace HorseStories\Core\Slugs;
  
use HorseStories\Models\Horses\Horse;
use Illuminate\Support\Str;

class SlugCreator
{
    /**
     * @var \HorseStories\Models\Horses\Horse
     */
    private $horse;

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     */
    function __construct(Horse $horse)
    {
        $this->horse = $horse;
    }

    /**
     * @param string $title
     * @return string
     */
    public function createForHorse($title)
    {
        $slug = Str::slug($title);
        $slugCount = count( $this->horse->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get() );

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}