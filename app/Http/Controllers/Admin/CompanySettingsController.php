<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanySetting;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\UpdateCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanySettingsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.companySettings');
        $this->pageIcon = 'icon-settings';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->cans('manage_settings'), 403);

        $setting = CompanySetting::first();

        if (!$setting) {
            abort(404);
        }

        return view('admin.settings.index', $this->data);
    }

    public function update(UpdateCompany $request, $id)
    {
        $data = $request->all();    
        
        $setting = CompanySetting::find($id);

        if ($request->hasFile('logo')) {
            $data['logo'] = Files::uploadLocalOrS3($request->logo, 'app-logo');
        }/*else {
            Files::deleteFile($request->logo, 'app-logo');
            $data ['logo'] = null;
        }*/

        $setting->update($data);

        return Reply::redirect(route('admin.settings.index'));
    }

}
