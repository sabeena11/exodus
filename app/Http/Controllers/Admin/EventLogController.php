<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helper\Files;
use App\Helper\Reply;
use App\Models\User;
use App\Models\EventLog;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest; 
use Yajra\DataTables\Facades\DataTables;

class EventLogController extends AdminBaseController
{
    
     public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.eventlogs');
        $this->pageIcon = 'icon-people';
    }

    public function index(){
        abort_if(! $this->user->cans('view_event_logs'), 403);

          $this->users = User::all();
          
        return view('admin.eventlogs.index', $this->data);
    }


    public function data() {
        
        abort_if(! $this->user->cans('view_event_logs'), 403);

        $eventlogs = EventLog::all();

       $eventlogs  = DB::table("rewardapp_event")->select('rewardapp_event.*','users.name as user_name')
                 
                    ->join('users', 'rewardapp_event.user_id', '=', 'users.id')
                    ->orderByDesc('created_at')->get();
                

         return DataTables::of($eventlogs)
        ->rawColumns(['name','title', 'desc', 'image','created'])
        ->addIndexColumn()
        ->make(true);
    }

    

    public function destroy($id)
    {
        abort_if(! $this->user->cans('delete_event_logs'), 403);

       EventLog::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

}
