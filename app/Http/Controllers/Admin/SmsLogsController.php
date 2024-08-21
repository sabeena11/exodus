<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\StoreSmsLog;
use App\Http\Requests\UpdateSmsLog;
use App\Models\UpdateLog; 
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest; 
use Yajra\DataTables\Facades\DataTables;
use DB;

class SmsLogsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.smslogs');
        $this->pageIcon = 'icon-people';
    }

    public function index(){
        abort_if(! $this->user->cans('view_sms_logs'), 403);

        $this->users = User::all();
        $this->smslogs = SmsLog::all();
        return view('admin.smslogs.index', $this->data);
    }

    public function create(){
        abort_if(! $this->user->cans('add_sms_logs'), 403);

        $this->users = User::all();
        $this->smslogs = SmsLog::all();
        return view('admin.smslogs.create', $this->data);
    }

    public function store(StoreSmsLog $request){
        abort_if(! $this->user->cans('add_sms_logs'), 403);

        $smslogs  = new SmsLog();
        $smslogs->response = $request->response;
        $smslogs->message = $request->message;
 
        $smslogs->user_id= $request->user_id;
        $smslogs->success= $request->success;
        $smslogs->created = now();
         
        $smslogs->save();
        
        $logData = [
            'user_id' => auth()->user()->id, 
            'action' => 'smslog_created', 
            'details' => 'A new smslog was created with message: ' . $request->message,
            'branch_id' => auth()->user()->branch_id, // Adding branch_id to logData
            'created_at' => now(),
            'updated_at' => now()
        ];
    
        // Serialize $logData into JSON
        $serializedLogData = json_encode($logData);
        UpdateLog::create([
            'data' => $serializedLogData,
            'end_device_id' => auth()->user()->branch_id,
            'created' => now(),
        ]); // Save the serialized data




        return Reply::redirect(route('admin.smslogs.index'), __('menu.smslogs').' '.__('messages.createdSuccessfully'));
    }

    public function edit($id){
        abort_if(! $this->user->cans('edit_sms_logs'), 403);

        if($id == $this->user->id){
            abort(403);
        }

            $this->users = User::all();
        $this->smslogData =  SmsLog::find($id);
     $this->selectedUserId = $this->smslogData->user_id;  
        return view('admin.smslogs.edit', $this->data);
    }

    public function update(UpdateSmsLog $request, $id){
        abort_if(! $this->user->cans('edit_sms_logs'), 403);

        if($id == $this->user->id){
            abort(403);
        }

        $smslogs = SmsLog::find($id);
        $smslogs->response = $request->response;
 
        $smslogs->message = $request->message;
        $smslogs->user_id= $request->user_id;
        $smslogs->success= $request->success;
        $smslogs->created = now();
        $smslogs->save();

        $logData = [
            'user_id' => auth()->user()->id, 
            'action' => 'smslog_updated', 
            'details' => 'A new smslog was updated with message: ' . $request->message,
            'branch_id' => auth()->user()->branch_id, // Adding branch_id to logData
            'created_at' => now(),
            'updated_at' => now()
        ];
    
        // Serialize $logData into JSON
        $serializedLogData = json_encode($logData);
        UpdateLog::create([
            'data' => $serializedLogData,
            'end_device_id' => auth()->user()->branch_id,
            'created' => now(),
        ]); // Save the serialized data

    
        return Reply::redirect(route('admin.smslogs.index'), __('menu.smslogs').' '.__('app.messages.updatedSuccessfully'));
    }


    public function data() {
        
        abort_if(! $this->user->cans('view_sms_logs'), 403);

        $users = User::all();
     
       
          $smslogs = SmsLog::all();
          $smslogs = SmsLog::select('rewardapp_smslog.*','users.name')
                        ->join('users', 'rewardapp_smslog.user_id', '=', 'users.id')->orderBy('rewardapp_smslog.created_at', 'desc')
                        ->get();
                        
        return DataTables::of($smslogs)
               ->addColumn('action', function ($row) {
            // Actions for banners
            $action = '<a href="' . route('admin.smslogs.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

            $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

            return $action;
        })

        ->rawColumns([ 'response', 'message', 'name', 'success','created','action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function destroy($id)
    {
        abort_if(! $this->user->cans('delete_sms_logs'), 403);

        SmsLog::destroy($id);

        $logData = [
            'user_id' => auth()->user()->id, 
            'action' => 'smslog_deleted', 
            'details' => 'A new smslog was deleted with id: ' . $id,
            'branch_id' => auth()->user()->branch_id, // Adding branch_id to logData
            'created_at' => now(),
            'updated_at' => now()
        ];
    
        // Serialize $logData into JSON
        $serializedLogData = json_encode($logData);
        UpdateLog::create([
            'data' => $serializedLogData,
            'end_device_id' => auth()->user()->branch_id,
            'created' => now(),
        ]); // Save the serialized data
        return Reply::success(__('messages.recordDeleted'));
    }

   

}
