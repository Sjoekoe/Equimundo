<?php namespace EQM\Models\Users;

use EQM\Models\Horses\Horse;

trait FollowingTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(Horse::class, 'follows', 'user_id', 'horse_id')->withTimestamps();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function follow(Horse $horse)
    {
        return $this->follows()->attach($horse);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return int
     */
    public function unFollow(Horse $horse)
    {
        return $this->follows()->detach($horse);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function isFollowing(Horse $horse)
    {
        $followedHorses = $this->follows()->lists('horse_id')->all();

        return in_array($horse->id, $followedHorses);
    }
}
