<?php
namespace EQM\Models\Companies;

use Carbon\Carbon;
use EQM\Core\Slugs\SlugCreator;
use EQM\Models\Addresses\Address;

class EloquentCompanyRepository implements CompanyRepository
{
    /**
     * @var \EQM\Models\Companies\EloquentCompany
     */
    private $company;

    public function __construct(EloquentCompany $company)
    {
        $this->company = $company;
    }

    /**
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Companies\Company
     */
    public function create(Address $address, array $values)
    {
        switch ($values['type']) {
            case $values['type'] == Stable::ID:
                return $this->createStable($address, $values);
        }
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param array $values
     * @return \EQM\Models\Companies\Company
     */
    public function update(Company $company, array $values)
    {
        if (array_key_exists('name', $values)) {
            $company->name = $values['name'];
        }

        if (array_key_exists('telephone', $values)) {
            $company->telephone = $values['telephone'];
        }

        if (array_key_exists('website', $values)) {
            $company->website = eqm_protocol_prepend($values['website']);
        }

        if (array_key_exists('about', $values)) {
            $company->about = $values['about'];
        }

        if (array_key_exists('email', $values)) {
            $company->email = $values['email'];
        }

        if (array_key_exists('address_id', $values)) {
            $company->address_id = $values['address_id'];
        }

        $company->save();

        return $company;
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     */
    public function delete(Company $company)
    {
        $company->delete();
    }

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllPaginated($limit = 10)
    {
        return $this->company->paginate($limit);
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Companies\Company
     */
    private function make(Company $company, Address $address, array $values)
    {
        $company->name = $values['name'];
        $company->slug = (new SlugCreator())->createForCompany($values['name']);
        $company->telephone = $values['telephone'];
        $company->address_id = $address->id();
        $company->website = eqm_protocol_prepend($values['website']);
        $company->about = $values['about'];
        $company->email = $values['email'];

        $company->save();

        return $company;
    }

    /**
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Companies\Company
     */
    private function createStable(Address $address, array $values)
    {
        $company = new EloquentStable();

        return $this->make($company, $address, $values);
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Companies\Company|null
     */
    public function findBySlug($slug)
    {
        return $this->company->where('slug', $slug)->first();
    }

    /**
     * @param int $id
     * @return \EQM\Models\Companies\Company|null
     */
    public function findById($id)
    {
        return $this->company->where('id', $id)->first();
    }

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug)
    {
        return count($this->company->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());
    }

    /**
     * @param string $keyWord
     * @return \EQM\Models\Companies\Company[]
     */
    public function search($keyWord)
    {
        return $this->company->_search($keyWord);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->company->all());
    }

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated($limit = 10)
    {
        return $this->company->paginate($limit);
    }

    /**
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return int
     */
    public function findCountByDate(Carbon $start, Carbon $end)
    {
        return count($this->company->where('created_at', '>', $start)->where('created_at', '<', $end)->get());
    }

    /**
     * @param \Carbon\Carbon $date
     * @return int
     */
    public function findRegisteredUsersBeforeDate(Carbon $date)
    {
        return count($this->company->where('created_at', '<=', $date)->get());
    }
}
