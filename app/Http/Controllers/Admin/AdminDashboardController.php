<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\UpdateLog;
use App\Models\RoleUser;


class AdminDashboardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->pageIcon = 'icon-speedometer';
        $this->pageTitle = __('menu.dashboard');
    }

    public function index(Request $request)
    {
        // $this->branch = Branch::all();

        //Purchase
        // $record = DB::table("rewardapp_purchase")
        //     ->selectRaw('count(*) as count, rewardapp_branch.name')
        //     ->join('rewardapp_branch', 'rewardapp_purchase.branch_id', '=', 'rewardapp_branch.id')
        //     // ->leftJoin('rewardapp_gift', 'rewardapp_purchase.bill_no', '=', DB::raw('CONCAT("Gift/", rewardapp_gift.id)'))
        //     ->groupBy('rewardapp_branch.id')
        //     // ->where('rewardapp_gift.categories','!=','Refer')
        //     ->get();

        // $this->branchPurchase = [
        //     'branch' => json_encode($record->pluck('name')),
        //     'purchase' => json_encode($record->pluck('count')),
        // ];

        // //Point
        // $record = GiftCategory::select('gift_category_name AS categories')
        //     ->selectSub(function ($subQuery) {
        //         $subQuery->selectRaw('SUM(points)')
        //             ->from('rewardapp_gift')
        //             ->whereRaw('categories = gift_category_name')
        //             ->groupBy('gift_category_name');
        //     }, 'totalpoints')
        //     ->groupBy('gift_category.gift_category_name')
        //     ->get();
        // // Calculate total sum of points for all categories
        // $totalPointsSum = $record->sum('totalpoints');

        // $this->branchPoint = [
        //     'totalpoints' => json_encode($record->pluck('totalpoints')),
        //     'categories' => json_encode($record->pluck('categories')),
        //     'totalPointsSum' => $totalPointsSum,
        // ];
        
        // $this->viewLogs = $this->user->cans('view_update_logs');

        return view('admin.dashboard.index', $this->data);
    }

    
    // public function getPointsData(Request $request)
    // {
    //     $branchId = $request->branch_id;

    //     $pointsData = GiftCategory::select('gift_category_name AS categories')
    //         ->selectSub(function ($subQuery) use ($branchId) {
    //             $subQuery->selectRaw('SUM(points)')
    //                 ->from('rewardapp_gift')
    //                 ->where('branch_id', $branchId)
    //                 ->whereRaw('categories = gift_category_name')
    //                 ->groupBy('gift_category_name');
    //         }, 'totalpoints')
    //         ->groupBy('gift_category.gift_category_name')
    //         ->get();

    //     // Calculate total sum of points for all categories
    //     $totalPointsSum = $pointsData->sum('totalpoints');

    //     if($branchId == "All"){
    //         $pointsData = GiftCategory::select('gift_category_name AS categories')
    //             ->selectSub(function ($subQuery) {
    //                 $subQuery->selectRaw('SUM(points)')
    //                     ->from('rewardapp_gift')
    //                     ->whereRaw('categories = gift_category_name')
    //                     ->groupBy('gift_category_name');
    //             }, 'totalpoints')
    //             ->groupBy('gift_category.gift_category_name')
    //             ->get();

    //         // Calculate total sum of points for all categories
    //         $totalPointsSum = $pointsData->sum('totalpoints');
    //     }
        
    //     $branchPoint = [
    //         'totalpoints' => json_encode($pointsData->pluck('totalpoints')),
    //         'categories' => json_encode($pointsData->pluck('categories')),
    //         'totalPointsSum' => $totalPointsSum,
    //     ];
        

    //     return response()->json($branchPoint);
    // }

    public function data() {
        
        abort_if(! $this->user->cans('view_update_logs'), 403);

        $updatelogs = UpdateLog::all();
        $user = auth()->user();
        $role = RoleUser::where('user_id','=',$user->id)->pluck('role_id')->first();

        $updatelogs = DB::table("rewardapp_updatelog")->select('rewardapp_updatelog.*','rewardapp_branch.name')
            ->join('rewardapp_branch','rewardapp_updatelog.end_device_id', '=', 'rewardapp_branch.id')
            ->get();

        $count = 0;

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

        // foreach($updatelogs as $abc){
        //     $data = json_decode($abc->data, true);
        //     if ($data !== null) {
        //         $action = "Action: " . $data['action'] ;
        //         $details = "Details: ". $data['details'];
        //         $final = $action . "<br>" . $details;
        //         $abc->data = $final;
        //     } else {
        //         echo "Invalid JSON data.";
        //     }
        // }

        return DataTables::of($updatelogs)
            ->rawColumns([ 'created', 'end_device_id','data'])
            ->addIndexColumn()
            ->make(true);
    }
}
