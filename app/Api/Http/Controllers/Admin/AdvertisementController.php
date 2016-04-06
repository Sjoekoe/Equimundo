<?php
namespace EQM\Api\Http\Controllers\Admin;

use EQM\Api\Advertising\AdvertisementTransformer;
use EQM\Api\Advertising\Requests\AdvertisementRequest;
use EQM\Api\Advertising\Requests\UpdateAdvertisementRequest;
use EQM\Api\Http\Controller;
use EQM\Core\Files\Uploader;
use EQM\Models\Advertising\Advertisements\Advertisement;
use EQM\Models\Advertising\Advertisements\AdvertisementRepository;
use Input;

class AdvertisementController extends Controller
{
    /**
     * @var \EQM\Models\Advertising\Advertisements\AdvertisementRepository
     */
    private $advertisements;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    public function __construct(AdvertisementRepository $advertisements, Uploader $uploader)
    {
        $this->advertisements = $advertisements;
        $this->uploader = $uploader;
    }

    public function index()
    {
        $advertisements = $this->advertisements->findAllPaginated(Input::get('limit', 10));

        return $this->response()->paginator($advertisements, new AdvertisementTransformer());
    }

    public function store(AdvertisementRequest $request)
    {
        $picture = $this->uploader->uploadAdvertisement($request->file('picture'), $request->get('type'));

        $values = $request->all();
        $values['picture_id'] = $picture->id();

        $advertisement = $this->advertisements->create($values);


        return $this->response()->item($advertisement, new AdvertisementTransformer());
    }

    public function random()
    {
        $advertisements = $this->advertisements->findRandomByType(Input::get('type'));
        
        if (! $advertisements->isEmpty()) {
            $advertisement = $advertisements->random(1);

            return $this->response()->item($advertisement, new AdvertisementTransformer());
        }

        return $this->response()->noContent();
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
