<?php
namespace EQM\Models\Advertising\Companies;

use Illuminate\Database\Eloquent\Collection;

class AdvertisingCompanyCollection
{
    public function getIdAndNamePairs(Collection $collection)
    {
        $result = [];

        foreach ($collection as $company) {
            $result[$company->id()] = [
                'id' => $company->id(),
                'name' => $company->name(),
            ];
        }

        return $result;
    }
}
