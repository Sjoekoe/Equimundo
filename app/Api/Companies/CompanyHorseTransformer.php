<?php
namespace EQM\Api\Companies;

use EQM\Api\Horses\HorseTransformer;
use EQM\Models\Companies\Horses\CompanyHorse;
use League\Fractal\TransformerAbstract;

class CompanyHorseTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'horseRelation',
        'companyRelation'
    ];
    
    /**
     * @param \EQM\Models\Companies\Horses\CompanyHorse $companyHorse
     * @return array
     */
    public function transform(CompanyHorse $companyHorse)
    {
        return [
            'id' => $companyHorse->id(),
        ];
    }

    /**
     * @param \EQM\Models\Companies\Horses\CompanyHorse $companyHorse
     * @return \League\Fractal\Resource\Item
     */
    public function includeHorseRelation(CompanyHorse $companyHorse)
    {
        return $this->item($companyHorse->horse(), new HorseTransformer());
    }

    /**
     * @param \EQM\Models\Companies\Horses\CompanyHorse $companyHorse
     * @return \League\Fractal\Resource\Item
     */
    public function includeCompanyRelation(CompanyHorse $companyHorse)
    {
        return $this->item($companyHorse->company(), new CompanyTransformer());
    }
}
