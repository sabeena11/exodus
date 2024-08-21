<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;

use App\Models\UpdateLog;
use App\Models\RoleUser;

use App\Models\EndDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest; 
use Yajra\DataTables\Facades\DataTables;

class UpdateLogsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.updatelogs');
        $this->pageIcon = 'icon-people';
    }

    public function index(){
        abort_if(! $this->user->cans('view_update_logs'), 403);

        $this->enddevices = EndDevice::all();
        
        $this->viewLogs = $this->user->cans('view_update_logs');

        return view('admin.updatelogs.index', $this->data);
    }


    public function data() {
        
        abort_if(! $this->user->cans('view_update_logs'), 403);

        $updatelogs = UpdateLog::all();
        $user = auth()->user();
        $role = RoleUser::where('user_id','=',$user->id)->pluck('role_id')->first();

        $updatelogs = DB::table("rewardapp_updatelog")->select('rewardapp_updatelog.*','rewardapp_branch.name')
            ->join('rewardapp_branch','rewardapp_updatelog.end_device_id', '=', 'rewardapp_branch.id')
            ->get();

        if ($role != 1) {
            foreach($updatelogs as $key => $log) {
                $data = json_decode($log->data, true);
                if (array_key_exists('user_id', $data)) {
                    $my_user_id = $data['user_id'] ;    
                    if($data['user_id'] != $user->id){
                        $updatelogs->forget($key);
                    }
                }
            }
        }

         return DataTables::of($updatelogs)
               ->addColumn('action', function ($row) {
            // Actions for banners
            
            $action = '';

            $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

            return $action;
        })


        ->rawColumns([ 'created', 'end_device_id','data','action'])
        ->addIndexColumn()
        ->make(true);
    }

    

    public function destroy($id)
    {
        abort_if(! $this->user->cans('delete_update_logs'), 403);

       UpdateLog::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

}
