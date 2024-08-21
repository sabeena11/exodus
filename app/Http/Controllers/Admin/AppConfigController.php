<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\UpdateAppConfig;
use App\Models\AppConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest;
use Yajra\DataTables\Facades\DataTables;

class AppconfigController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.appConfigs');
        $this->pageIcon = 'icon-people';
    }

    public function index(){
        abort_if(! $this->user->cans('view_app_configs'), 403);
        $this->appconfigs = AppConfig::all();
        return view('admin.appconfig.index', $this->data);
    }

    public function edit($id){
        abort_if(! $this->user->cans('edit_app_configs'), 403);
        $this->appconfigData = AppConfig::find($id);
        return view('admin.appconfig.edit', $this->data);
    }

    public function update(UpdateAppConfig $request, $id){

        // $data = $request->all();
        $appconfig = AppConfig::find($id);
        $appconfig->reward_value = $request->rewardValue;
        $appconfig->sms_token = $request->smsToken;
        $appconfig->enable_sms = $request->enableSms;
        $appconfig->enable_notifications = $request->enableNotification;

        $appconfig->save();

        return Reply::redirect(route('admin.app-configs.index'), __('menu.appConfigs').' '.__('app.messages.updatedSuccessfully'));
    }


    public function data() {

        $appconfigs = AppConfig::all();
        foreach ($appconfigs as $data) {
            if ($data->enable_sms == 1) {
                $data->enable_sms = '<div class="btn-success btn-circle"><i class="fa fa-check"></i></div>';
            }
            if($data->enable_sms == 0){
                $data->enable_sms = '<div class="btn-danger btn-circle"><i class="fa fa-times"></i></div>';
            }
            if ($data->enable_notifications == 1) {
                $data->enable_notifications = '<div class="btn-success btn-circle"><i class="fa fa-check"></i></div>';
            }
            if($data->enable_notifications == 0){
                $data->enable_notifications = '<div class="btn-danger btn-circle"><i class="fa fa-times"></i></div>';
            }
        }
         
        return DataTables::of($appconfigs)
            ->addColumn('enable_sms', function ($row) {
                return $row->enable_sms;
            })
            ->addColumn('enable_notifications', function ($row) {
                return $row->enable_notifications;
            })->addColumn('action', function ($row){
                $action = '';

                    $action.= '<a href="' . route('admin.app-configs.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                      data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';


                    $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                return $action;
            })
            ->rawColumns(['id', 'sms_token', 'reward_value', 'enable_sms', 'enable_notifications', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function destroy($id)
    {
        // abort_if(! $this->appconfig->cans('delete_appconfig'), 403);
        abort_if(! $this->user->cans('delete_app_configs'), 403);

        AppConfig::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }
}
