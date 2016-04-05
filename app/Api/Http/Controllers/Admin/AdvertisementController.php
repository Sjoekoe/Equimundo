<?php
namespace EQM\Api\Http\Controllers\Admin;

use EQM\Api\Advertising\AdvertisementTransformer;
use EQM\Api\Advertising\Requests\AdvertisementRequest;
use EQM\Api\Advertising\Requests\UpdateAdvertisementRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Advertising\Advertisements\Advertisement;
use EQM\Models\Advertising\Advertisements\AdvertisementRepository;
use Input;

class AdvertisementController extends Controller
{
    /**
     * @var \EQM\Models\Advertising\Advertisements\AdvertisementRepository
     */
    private $advertisements;

    public function __construct(AdvertisementRepository $advertisements)
    {
        $this->advertisements = $advertisements;
    }

    public function index()
    {
        $advertisements = $this->advertisements->findAllPaginated(Input::get('limit', 10));

        return $this->response()->paginator($advertisements, new AdvertisementTransformer());
    }

    public function store(AdvertisementRequest $request)
    {
        $advertisement = $this->advertisements->create($request->all());

        return $this->response()->item($advertisement, new AdvertisementTransformer());
    }

    public function show(Advertisement $advertisement)
    {
        return $this->response()->item($advertisement, new AdvertisementTransformer());
    }

    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement)
    {
        $advertisement = $this->advertisements->update($advertisement, $request->all());

        return $this->response()->item($advertisement, new AdvertisementTransformer());
    }

    public function delete(Advertisement $advertisement)
    {
        $this->advertisements->delete($advertisement);

        return $this->response()->noContent();
    }
}
