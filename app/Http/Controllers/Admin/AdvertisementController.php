<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Core\Info\Info;
use EQM\Http\Controllers\Controller;
use EQM\Models\Advertising\Advertisements\Advertisement;
use EQM\Models\Advertising\Advertisements\AdvertisementRepository;
use EQM\Models\Advertising\Companies\AdvertisingCompanyCollection;
use EQM\Models\Advertising\Companies\AdvertisingCompanyRepository;

class AdvertisementController extends Controller
{
    /**
     * @var \EQM\Models\Advertising\Companies\AdvertisingCompanyRepository
     */
    private $companies;

    /**
     * @var \EQM\Models\Advertising\Advertisements\AdvertisementRepository
     */
    private $advertisements;

    public function __construct(AdvertisingCompanyRepository $companies, AdvertisementRepository $advertisements)
    {
        $this->companies = $companies;
        $this->advertisements = $advertisements;
    }

    public function index()
    {
        return view('admin.advertisements.index');
    }

    public function overview()
    {
        $companies = $this->companies->findAll();
        $countries = $companies->groupBy('addressRelation.country');
        $advertisements = $this->advertisements->findAll();
        $advertisementTypes = $advertisements->groupBy('type');
        $payments = $advertisements->groupBy('paid');

        $countryData = $this->getCountriesData($countries);
        $countryColors = $this->getColors($countries);
        $advertisementData = $this->getAdvertisementData($advertisementTypes);
        $advertisementColors = $this->getColors($advertisementTypes);
        $paymentData = $this->getPaymentData($payments);
        $paymentColors = $this->getColors($payments);

        return view('admin.advertisements.overview', compact(
            'companies', 'countryData', 'countryColors', 'advertisements', 'advertisementColors', 'advertisementData',
            'paymentData', 'paymentColors'
        ));
    }

    public function create(Info $info)
    {
        $companies = (new AdvertisingCompanyCollection())->getIdAndNamePairs($this->companies->findAll());

        $info->flash('companies', $companies);

        return view('admin.advertisements.create', compact('companies'));
    }

    public function show(Info $info, Advertisement $advertisement)
    {
        $info->flash('advertisement', $advertisement);

        return view('admin.advertisements.show');
    }

    private function getCountriesData($countries)
    {
        $data = [];

        foreach ($countries as $key => $country) {
            $data[] = [
                'label' => $key,
                'value' => count($country),
            ];
        }

        return $data;
    }

    private function getAdvertisementData($advertisements)
    {
        $data = [];

        foreach ($advertisements as $key => $advertisement) {
            $data[] = [
                'label' => $key,
                'value' => count($advertisement),
            ];
        }

        return $data;
    }

    private function getPaymentData($payments)
    {
        $data = [];

        foreach ($payments as $key => $advertisement) {
            $amount = 0;

            foreach ($advertisement as $ad) {
                $amount += $ad->amount();
            }

            $data[] = [
                'label' => $key ? 'Paid' : 'Unpaid',
                'value' => $amount,
            ];
        }

        return $data;
    }

    private function getColors($values)
    {
        $data = [];

        foreach ($values as $value) {
            $data[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        return $data;
    }
}
