<?php
namespace EQM\Models\Statuses;

use EQM\Models\Companies\EloquentCompany;

class EloquentCompanyStatus extends EloquentStatus implements Status, CompanyStatus
{
    /**
     * @var string
     */
    protected static $singleTableType = self::TYPE;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyRelation()
    {
        return $this->belongsTo(EloquentCompany::class, 'company_id', 'id');
    }
    /**
     * @return \EQM\Models\Companies\Company
     */
    public function company()
    {
        return $this->companyRelation()->first();
    }

    /**
     * @return string
     */
    public function type()
    {
        return self::TYPE;
    }

    public function poster()
    {
        return $this->belongsTo(EloquentCompany::class, 'company_id', 'id');
    }
}
