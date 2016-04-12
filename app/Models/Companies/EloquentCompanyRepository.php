<?php
namespace EQM\Models\Companies;

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
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug)
    {
        return count($this->company->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());
    }
}
