<?php
namespace EQM\Models\Statuses;

use EQM\Models\Companies\Company;
use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;

interface StatusRepository
{
    /**
     * @param $id
     * @return \EQM\Models\Statuses\Status
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status
     */
    public function findAllForUser(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status
     */
    public function findFeedForUser(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findFeedForUserPaginated(User $user, $limit = 10);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Statuses\Status[]
     */
    public function findFeedForHorse(Horse $horse);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findFeedForHorsePaginated(Horse $horse, $limit = 10);

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findForCompanyPaginated(Company $company, $limit = 10);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param string $body
     * @param int|null $prefix
     * @return \EQM\Models\Statuses\Status
     */
    public function create(Horse $horse, $body, $prefix = null);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param string $body
     * @return \EQM\Models\Statuses\Status
     */
    public function createForPalmares(Horse $horse, $body);

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param array $values
     * @return \EQM\Models\Statuses\Status
     */
    public function update(Status $status, array $values = []);

    /**
     * @param \EQM\Models\Statuses\Status $status
     */
    public function delete(Status $status);

    /**
     * @return int
     */
    public function count();
}
