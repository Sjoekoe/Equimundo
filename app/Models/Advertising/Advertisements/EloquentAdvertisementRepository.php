<?php
namespace EQM\Models\Advertising\Advertisements;

use Carbon\Carbon;

class EloquentAdvertisementRepository implements AdvertisementRepository
{
    /**
     * @var \EQM\Models\Advertising\Advertisements\EloquentAdvertisement
     */
    private $advertisement;

    public function __construct(EloquentAdvertisement $advertisement)
    {
        $this->advertisement = $advertisement;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Advertising\Advertisements\Advertisement
     */
    public function create(array $values)
    {
        $advertisement = new EloquentAdvertisement([
            'start' => Carbon::createFromFormat('d/m/Y', $values['start'])->startOfDay(),
            'end' => Carbon::createFromFormat('d/m/Y', $values['end'])->endOfDay(),
            'type' => $values['type'],
            'adv_company_id' => $values['company_id'],
            'picture_id' => array_get($values, 'picture_id'),
            'paid' => array_get($values, 'paid', false),
            'amount' => $values['amount'],
            'clicks' => 0,
            'views' => 0,
            'website' => eqm_protocol_prepend($values['website']),
        ]);

        $advertisement->save();

        return $advertisement;
    }

    /**
     * @param \EQM\Models\Advertising\Advertisements\Advertisement $advertisement
     * @param array $values
     * @return \EQM\Models\Advertising\Advertisements\Advertisement
     */
    public function update(Advertisement $advertisement, array $values)
    {
        if (array_key_exists('start', $values)) {
            $advertisement->start = Carbon::createFromFormat('d/m/Y', $values['start'])->startOfDay();
        }

        if (array_key_exists('end', $values)) {
            $advertisement->end = Carbon::createFromFormat('d/m/Y', $values['end'])->endOfDay();
        }

        if (array_key_exists('website', $values)) {
            $advertisement->website = eqm_protocol_prepend($values['website']);
        }

        $advertisement->type = $values['type'];
        $advertisement->paid = array_get($values, 'paid', false);
        $advertisement->amount = $values['amount'];

        $advertisement->save();

        return $advertisement;
    }

    /**
     * @param \EQM\Models\Advertising\Advertisements\Advertisement $advertisement
     */
    public function delete(Advertisement $advertisement)
    {
        $advertisement->delete();
    }

    /**
     * @param int $id
     * @return \EQM\Models\Advertising\Advertisements\Advertisement|null
     */
    public function findById($id)
    {
        return $this->advertisement->where('id', $id)->first();
    }

    public function findAllPaginated($limit = 10)
    {
        return $this->advertisement->paginate($limit);
    }
}
