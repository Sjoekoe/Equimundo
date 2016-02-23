<?php
namespace EQM\Core\Slugs;

use EQM\Models\Horses\HorseRepository;
use EQM\Models\Users\UserRepository;
use Illuminate\Support\Str;

class SlugCreator
{
    /**
     * @param string $title
     * @return string
     */
    public function createForHorse($title)
    {
        $horses = app(HorseRepository::class);
        $slug = Str::slug($title);
        $slugCount = $horses->findSlugCounts($slug);

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    public function createForUser($firstName, $lastName)
    {
        $users = app(UserRepository::class);
        $slug = Str::slug($firstName . '-' . $lastName);
        $slugCount = $users->findSlugCount($slug);

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}
