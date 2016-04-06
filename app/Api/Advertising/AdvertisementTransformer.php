<?php
namespace EQM\Api\Advertising;

use EQM\Models\Advertising\Advertisements\Advertisement;
use League\Fractal\TransformerAbstract;

class AdvertisementTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'companyRelation',
    ];

    /**
     * @param \EQM\Models\Advertising\Advertisements\Advertisement $advertisement
     * @return array
     */
    public function transform(Advertisement $advertisement)
    {
        return [
            'id' => $advertisement->id(),
            'start' => $advertisement->start()->toIso8601String(),
            'end' => $advertisement->end()->toIso8601String(),
            'clicks' => (int) $advertisement->clicks(),
            'views' => (int) $advertisement->views(),
            'type' => $advertisement->type(),
            'paid' => (bool) $advertisement->paid(),
            'amount' => (int) $advertisement->amount(),
            'website' => $advertisement->website(),
            'picture_path' => $advertisement->picture() ? route('file.advertisement', $advertisement->picture()->id()) : null,
        ];
    }

    public function includeCompanyRelation(Advertisement $advertisement)
    {
        return $this->item($advertisement->company(), new AdvertisingCompanyTransformer());
    }
}
