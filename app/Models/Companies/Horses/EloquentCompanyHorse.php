<?php
namespace EQM\Models\Companies\Horses;

use EQM\Models\Companies\EloquentCompany;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;

class EloquentCompanyHorse extends Model implements CompanyHorse
{
    use UsesTimeStamps;

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horseRelation()
    {
        return $this->belongsTo(EloquentHorse::class, 'horse_id', 'id');
    }

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse()
    {
        return $this->horseRelation()->first();
    }

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
}
