<?php
namespace EQM\Models\Statuses;

use EQM\Core\Helpers\StatusConvertor;
use EQM\Models\Companies\Company;
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
        $followIds = $user->follows()->lists('id');

        $horseIds = $followIds->toArray();

        foreach ($user->horses() as $horse) {
            array_push($horseIds, $horse->id());
        }

        $companyIds = [];

        foreach ($user->companies() as $company) {
            array_push($companyIds, $company->id());
        }

        return $this->status
            ->orWhere(function ($query) use ($horseIds) {
                $query->whereIn('horse_id', array_flatten($horseIds));
            })
            ->orWhere(function($query) use ($companyIds) {
                $query->whereIn('company_id', array_flatten($companyIds));
            })
            ->latest()
            ->paginate(10);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findFeedForUserPaginated(User $user, $limit = 10)
    {
        $followIds = $user->follows()->lists('id');

        $horseIds = $followIds->toArray();

        foreach ($user->horses() as $horse) {
            array_push($horseIds, $horse->id());
        }

        $companyIds = [];

        foreach ($user->companies() as $company) {
            array_push($companyIds, $company->id());
        }

        return $this->status
            ->orWhere(function ($query) use ($horseIds) {
                $query->whereIn('horse_id', array_flatten($horseIds));
            })
            ->orWhere(function($query) use ($companyIds) {
                $query->whereIn('company_id', array_flatten($companyIds));
            })
            ->latest()
            ->paginate($limit);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Statuses\Status[]
     */
    public function findFeedForHorse(Horse $horse)
    {
        return $this->status->where('horse_id', $horse->id())->latest()->paginate(10);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findFeedForHorsePaginated(Horse $horse, $limit = 10)
    {
        return $this->status->where('horse_id', $horse->id())->latest()->paginate($limit);
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findForCompanyPaginated(Company $company, $limit = 10)
    {
        return $this->status->where('company_id', $company->id())->latest()->paginate($limit);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param string $body
     * @param int|null $prefix
     * @return \EQM\Models\Statuses\Status
     */
    public function create(Horse $horse, $body, $prefix = null)
    {
        $status = new EloquentHorseStatus();
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
        $status->body = (new StatusConvertor())->convert($values['body']);

        $status->save();

        return $status;
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

    public function createForCompany(Company $company, array $values)
    {
        $status = new EloquentCompanyStatus();
        $status->body = (new StatusConvertor())->convert($values['body']);
        $status->prefix = null;
        $status->company_id = $company->id();

        $status->save();

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
