<?php
namespace EQM\Models\Advertising\Advertisements;

use Carbon\Carbon;
use EQM\Core\Advertisements\AdObject;

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
        switch ($values['type']) {
            case AdObject::RECTANGLE:
                return $this->createRectangle($values);

            case AdObject::LEADERBOARD:
                return $this->createLeaderBoard($values);
        }
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

        if (array_key_exists('paid', $values)) {
            $advertisement->paid = array_get($values, 'paid', false);
        }

        if (array_key_exists('amount', $values)) {
            $advertisement->amount = $values['amount'];
        }

        if (array_key_exists('view', $values)) {
            $advertisement->views += 1;
        }

        if (array_key_exists('click', $values)) {
            $advertisement->clicks += 1;
        }

        if (array_key_exists('picture_id', $values)) {
            $advertisement->picture_id = $values['picture_id'];
        }

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

    /**
     * @return \EQM\Models\Advertising\Advertisements\Advertisement[]
     */
    public function findAll()
    {
        return $this->advertisement->get();
    }

    public function findAllPaginated($limit = 10)
    {
        return $this->advertisement->paginate($limit);
    }

    /**
     * @param string $type
     * @return \EQM\Models\Advertising\Advertisements\Advertisement[]
     */
    public function findRandomByType($type)
    {
        $now = Carbon::now();

        return $this->advertisement
            ->where('type', $type)
            ->where('start', '<', $now)
            ->where('end', '>', $now)
            ->get();
    }

    /**
     * @param \EQM\Models\Advertising\Advertisements\Advertisement $advertisement
     * @param array $values
     * @return \EQM\Models\Advertising\Advertisements\Advertisement
     */
    private function make(Advertisement $advertisement, array $values)
    {
        $advertisement->start = Carbon::createFromFormat('d/m/Y', $values['start'])->startOfDay();
        $advertisement->end = Carbon::createFromFormat('d/m/Y', $values['end'])->endOfDay();
        $advertisement->adv_company_id = $values['company_id'];
        $advertisement->picture_id = array_get($values, 'picture_id');
        $advertisement->paid = array_get($values, 'paid', false);
        $advertisement->amount = $values['amount'];
        $advertisement->clicks = 0;
        $advertisement->views = 0;
        $advertisement->website = eqm_protocol_prepend($values['website']);

        $advertisement->save();

        return $advertisement;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Advertising\Advertisements\Advertisement
     */
    private function createRectangle(array $values)
    {
        $advertisement = new EloquentRectangle();

        return $this->make($advertisement, $values);
    }

    private function createLeaderBoard(array $values)
    {
        $advertisement = new EloquentLeaderBoard();

        return $this->make($advertisement, $values);
    }
}
