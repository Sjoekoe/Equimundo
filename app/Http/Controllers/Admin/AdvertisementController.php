<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Core\Info\Info;
use EQM\Http\Controllers\Controller;
use EQM\Models\Advertising\Companies\AdvertisingCompanyCollection;
use EQM\Models\Advertising\Companies\AdvertisingCompanyRepository;

class AdvertisementController extends Controller
{
    /**
     * @var \EQM\Models\Advertising\Companies\AdvertisingCompanyRepository
     */
    private $companies;

    public function __construct(AdvertisingCompanyRepository $companies)
    {
        $this->companies = $companies;
    }

    public function index()
    {
        return view('admin.advertisements.index');
    }

    public function create(Info $info)
    {
        $companies = (new AdvertisingCompanyCollection())->getIdAndNamePairs($this->companies->findAll());

        $info->flash('companies', $companies);

        return view('admin.advertisements.create', compact('companies'));
    }
}
