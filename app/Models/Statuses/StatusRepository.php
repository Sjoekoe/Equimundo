<?php
namespace EQM\Models\Statuses;

use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;

class StatusRepository
{
    /**
     * @var \EQM\Models\Statuses\Status
     */
    private $status;

    /**
     * @param \EQM\Models\Statuses\Status $status
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * @param $id
     * @return \EQM\Models\Statuses\Status
     */
    public function findById($id)
    {
        return $this->status->findOrFail($id);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status[]
     */
    public function getAllForUser(User $user)
    {
        return $user->statuses()->with('horse')->latest()->get();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status[]
     */
    public function getFeedForUser(User $user)
    {
        $horseIds = $user->follows()->lists('horse_id');

        $horseIds[] = $user->horses()->lists('id')->all();

        return $this->status->with('comments')->whereIn('horse_id', array_flatten($horseIds))->latest()->get();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Statuses\Status[]
     */
    public function getFeedForHorse(Horse $horse)
    {
        return $this->status->where('horse_id', $horse->id)->orderBy('created_at', 'DESC')->get();
    }
}
