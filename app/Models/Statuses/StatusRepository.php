<?php
namespace HorseStories\Models\Statuses;

use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Users\User;

class StatusRepository
{
    /**
     * @var \HorseStories\Models\Statuses\Status
     */
    private $status;

    /**
     * @param \HorseStories\Models\Statuses\Status $status
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * @param $id
     * @return \HorseStories\Models\Statuses\Status
     */
    public function findById($id)
    {
        return $this->status->findOrFail($id);
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \HorseStories\Models\Statuses\Status[]
     */
    public function getAllForUser(User $user)
    {
        return $user->statuses()->with('horse')->latest()->get();
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \HorseStories\Models\Statuses\Status[]
     */
    public function getFeedForUser(User $user)
    {
        $horseIds = $user->follows()->lists('horse_id');

        $horseIds[] = $user->horses()->lists('id');

        return $this->status->with('comments')->whereIn('horse_id', array_flatten($horseIds))->latest()->get();
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @return \HorseStories\Models\Statuses\Status[]
     */
    public function getFeedForHorse(Horse $horse)
    {
        return $this->status->where('horse_id', $horse->id)->orderBy('created_at', 'DESC')->get();
    }
}
