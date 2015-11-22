<?php
namespace EQM\Models\Statuses;

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
        return $this->status->findOrFail($id);
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
        return $this->status->where('horse_id', $horse->id)->orderBy('created_at', 'DESC')->get();
    }

    /**
     * @param array $data
     * @return \EQM\Models\Statuses\Status
     */
    public function create(array $data = [])
    {
        $status = new EloquentStatus();
        $status->body = $data['status'];
        $status->horse_id = $data['horse'];

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
        $status->body = $values['status'];

        $status->save();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $data
     * @return \EQM\Models\Statuses\Status
     */
    public function createForPalmares(Horse $horse, array $data = [])
    {
        $data['status'] = $horse->name()  . ' has added an achievement.<br>';
        $data['status'] .= 'She finished ' . $data['ranking'] . ' at ' . $data['event_name']  . ' in the ' . $data['level'] . ' category<br><hr>';
        $data['status'] .= nl2br($data['body']);

        $data['horse'] = $horse->id();

        $data['status'] = $this->create($data);

        return $data;
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     */
    public function delete(Status $status)
    {
        $status->delete();
    }
}
