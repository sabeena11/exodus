<?php

namespace App\Http\Controllers\Admin;

use App\Models\ApplicationSetting;
use App\Models\CompanySetting;
use App\Models\LanguageSetting;
use App\Models\Setting;
use App\Models\User;
use App\Models\Branch;

use App\Traits\FileSystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LinkedInSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class AdminBaseController extends Controller
{
    use FileSystemSettingTrait;
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
    

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        // Inject currently logged in user object into every view of user dashboard
        parent::__construct();

        $this->global = CompanySetting::first();

        $this->companyName = $this->global->company_name;
        
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();

            if ($this->user == null) {
                return redirect(route('login'));
            }

            $this->getPermissions = User::with('roles.permissions.permission')->find($this->user->id);
            $userPermissions = array();
            foreach ($this->getPermissions->roles[0]->permissions as $key => $value) {
                $userPermissions[] = $value->permission->name;
            }
            $this->userPermissions = $userPermissions;
            
            view()->share('global', $this->global);

            return $next($request);
        });
    }
}
