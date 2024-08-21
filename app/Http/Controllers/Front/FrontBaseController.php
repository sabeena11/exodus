<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\CompanySetting;
use App\Models\Slider;
use App\Models\SliderCard;
use App\Models\Feature;
use App\Models\Overview;
use App\Models\Menu;

use App\Models\ClientsOverview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class FrontBaseController extends Controller
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[ $name ]);
    }

    public function __construct()
    {
        parent::__construct();
        $hash = request()->hash;
        $this->global = CompanySetting::first();
        $this->companyName = $this->global->company_name;
        $this->sliders = Slider::all();
        $this->slidercards = SliderCard::all();
        $this->overviews = Overview::all();
        $this->features = Feature::all();
        $this->menus = Menu::all();
         $this->clientsoverview = ClientsOverview::all();
    }
}
