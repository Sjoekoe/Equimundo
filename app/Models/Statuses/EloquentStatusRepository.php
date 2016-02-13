<?php
namespace EQM\Models\Statuses;

use EQM\Core\Helpers\StatusConvertor;
use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;

class EloquentStatusRepository implements StatusRepository
{
    /**
     * @var \EQM\Models\Statuses\EloquentStatus
     */
    private $status;

    /**
     * @param \EQM\Models\Statuses\EloquentStatus $status
     */
    public function __construct(EloquentStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @param $id
     * @return \EQM\Models\Statuses\Status
     */
    public function findById($id)
    {
        return $this->status->find($id);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status[]
     */
    public function findAllForUser(User $user)
    {
        return $user->statuses()->with('horse')->latest()->get();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status[]
     */
    public function findFeedForUser(User $user)
    {
        $followIds = $user->follows()->lists('horse_id');

        $horseIds = $followIds->toArray();

        foreach ($user->horses() as $horse) {
            array_push($horseIds, $horse->id());
        }

        return $this->status->whereIn('horse_id', array_flatten($horseIds))->latest()->get();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Statuses\Status[]
     */
    public function findFeedForHorse(Horse $horse)
    {
        return $this->status->where('horse_id', $horse->id())->latest()->get();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param string $body
     * @param int|null $prefix
     * @return \EQM\Models\Statuses\Status
     */
    public function create(Horse $horse, $body, $prefix = null)
    {
        $status = new EloquentStatus();
        $status->body = (new StatusConvertor())->convert($body);
        $status->horse_id = $horse->id();
        $status->prefix = $prefix;

        $status->save();

        return $status;
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param array $values
     * @return \EQM\Models\Statuses\Status
     */
    public function update(Status $status, array $values = [])
    {
        $status->body = (new StatusConvertor())->convert($values['status']);

        $status->save();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param string $body
     * @return \EQM\Models\Statuses\Status
     */
    public function createForPalmares(Horse $horse, $body)
    {
        $status = $this->create($horse, $body, Status::PREFIX_PALMARES);

        return $status;
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     */
    public function delete(Status $status)
    {
        $status->delete();
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->status->all());
    }
}
