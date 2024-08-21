<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Helper\HttpClient;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\HashPassword;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\UpdateLog;
use App\Models\Branch;
use App\Models\SmsLog;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\Gift;
class AdminUserController extends AdminBaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.user');
        $this->pageIcon = 'icon-people';
    }

    public function index(){
        abort_if(! $this->user->cans('view_user'), 403);

        $this->users = User::all();
        return view('admin.user.index', $this->data);
    }

    public function create(){
        abort_if(! $this->user->cans('add_user'), 403);

        $this->branches = Branch::all();
        return view('admin.user.create', $this->data);
    }

    public function store(StoreUser $request){
        abort_if(! $this->user->cans('add_user'), 403);

        // Check if mobile number already exists
    $existingUser = User::where('mobile', '+977'.$request->mobile)->first();
    if ($existingUser) {
        return Reply::error(__('mobile number already exists'));
    }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $password = $request->filled('password') ? $request->password : rand(100000, 999999);
        $user->password = HashPassword::create($password);
        //hash_hmac('sha256', '+977'.$request->mobile.$request->password, env('JWT_SECRET')); //Hash::make($request->password);
        $user->mobile = '+977'.$request->mobile;
        $user->address = $request->address;
        $user->sex = $request->sex;
        $user->dob = $request->dob;
        $user->is_staff = 0;
        $user->is_verified = 0;
        $user->branch_id = $request->branch_id;

        if ($request->hasFile('image')) {
            $user->image = Files::uploadLocalOrS3($request->image,'profile');
        }
        $user->save();

        //Send SMS
        
        $sms_message = "Dear ".$user->name.",\nYour Account has been Created for A to Z Mobile!\nPassword is ".$password;

        HttpClient::send_sms($user, $sms_message);

        //attach role
        $user->roles()->attach(4);
        $branchName = Branch::find(auth()->user()->branch_id)->name;
    
        $logData = [
            'user_id' => auth()->user()->id, 
            'action' => 'user_created', 
            'details' => 'A new user was created with title: ' . $request->name,
            'branch_id' => auth()->user()->branch_id, // Adding branch_id to logData
            'branch_name' => $branchName,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $logDetails = "User ID: " . $logData['user_id'] . "\n" .
        "Action: " . $logData['action'] . "\n" .
        "Details: " . $logData['details'] . "\n" .
        "Branch ID: " . $logData['branch_id'] . "\n" .
        "Branch Name: " . $logData['branch_name'] . "\n" .
        "Created At: " . $logData['created_at'] . "\n" .
        "Updated At: " . $logData['updated_at'];

        // // Serialize $logData into JSON
        // $serializedLogData = json_encode($logData);
        UpdateLog::create([
            'data' => $logDetails,
            'end_device_id' => auth()->user()->branch_id,
            'created' => now(),
        ]); // Save the serialized data

        return Reply::redirect(route('admin.user.index'), __('menu.user').' '.__('messages.createdSuccessfully'));
    }

    public function edit($id){
        abort_if(! $this->user->cans('edit_user'), 403);

        
        // if($id == $this->user->id){
        //     abort(403);
        // }

        $this->roles = Role::all();
        $this->userData = User::find($id);
        $this->branches = Branch::all();
        return view('admin.user.edit', $this->data);
    }

    public function update(UpdateUser $request, $id)
    {
        abort_if(! $this->user->cans('edit_user'), 403);
    
        if($id == $this->user->id){
            abort(403);
        }
    
        $user = User::find($id);
    
        // Check if the mobile number is being changed to a number that already exists
        if ($user->mobile != '+977'.$request->mobile) {
            $existingUser = User::where('mobile', '+977'.$request->mobile)->first();
            if ($existingUser) {
                return Reply::error(__('Mobile number already exists for a different user.'));
            }
        }
    
        try {
            // Update the user's information
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password != null){
                $user->password = HashPassword::create($request->password);
            }
            
            $user->address = $request->address;
            $user->sex = $request->sex;
            $user->dob = $request->dob;
            $user->branch_id = $request->branch_id;
            $user->is_staff = $request->has('is_staff') ? 1 : 0;
            $user->is_verified = $request->has('is_verified') ? 1 : 0;
    
            if (substr($request->mobile, 0, 4) == '+977'){
                $user->mobile = $request->mobile;
            } else {
                $user->mobile = '+977'.$request->mobile;
            }
    
            if ($request->hasFile('image')) {
                $user->image = Files::uploadLocalOrS3($request->image,'profile');
            }
            $user->save();
    
            //Send SMS
            if($request->password != null){
                $sms_message = "Dear ".$user->name.",\nYour Account has been Created for A to Z Mobile!\nPassword is ".$request->password;
    
                HttpClient::send_sms($user, $sms_message);
            }
    
            //attach role
            RoleUser::where('user_id', $id)->delete();
            $user->roles()->attach($request->role_id);
            $branchName = Branch::find(auth()->user()->branch_id)->name;
            $logData = [
                'user_id' => auth()->user()->id, 
                'action' => 'user_updated', 
                'details' => 'A user was updated with title: ' . $request->name,
                'branch_id' => auth()->user()->branch_id,
                'branch_name' => $branchName,
                'created_at' => now(),
                'updated_at' => now()
            ];
            
            $logDetails = "User ID: " . $logData['user_id'] . "\n" .
                "Action: " . $logData['action'] . "\n" .
                "Details: " . $logData['details'] . "\n" .
                "Branch ID: " . $logData['branch_id'] . "\n" .
                    "Branch Name: " . $logData['branch_name'] . "\n" .
                "Created At: " . $logData['created_at'] . "\n" .
                "Updated At: " . $logData['updated_at'];
            
            UpdateLog::create([
                'data' => $logDetails,
                'end_device_id' => auth()->user()->branch_id,
                'created' => now(),
            ]);
    
            return Reply::redirect(route('admin.user.index'), __('menu.user').' '.__('app.messages.updatedSuccessfully'));
    
        } catch (QueryException $e) {
            // Handle the duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                return Reply::error(__('Mobile number already exists for a different user.'));
            }
    
            // Re-throw the exception if it's not a duplicate entry error
            throw $e;
        }
    }


    public function data(Request $request) {
        abort_if(! $this->user->cans('view_user'), 403);

        $draw = $request->input('draw');
        $start = $request->input('start');
        $limit = $request->input('length');
        $order = $request->input('order')[0]['column'];
        $order_dir = $request->input('order')[0]['dir'];
        $total = User::count();

        $gifts = Gift::query(); // Use the Gift model for filtering total points
        $gifts->select('user_id', \DB::raw('sum(points) as total_points'))
              ->groupBy('user_id');
    
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
    
            // Filter gifts based on the date range
            $gifts->whereBetween('created_at', [$fromDate, $toDate]);
        }
    
        // Add more conditions as needed...
    
        // Get the users with total points
        $users = User::leftJoinSub($gifts, 'gifts', function ($join) {
                    $join->on('users.id', '=', 'gifts.user_id');
                })->select('users.*', \DB::raw('IFNULL(total_points, 0) as total_points'));
      
        if ($order == "0") {
            $users = User::orderBy('id', $order_dir);
        } elseif ($order == "1") {
            $users = User::orderBy('name', $order_dir);
        } elseif ($order == "2") {
            $users = User::orderBy('email', $order_dir);
        } elseif ($order == "4") {
            $users = User::orderBy('is_verified', $order_dir);

        } elseif ($order == "5"){
            $users = User::orderBy('is_staff', $order_dir);
        } else {
            $users = User::orderBy('id', $order_dir);
        }

        // Filter by mobile number and name
        if ($request->has('search') && $request->input('search')['value'] != '') {
            $searchValue = $request->input('search')['value'];

            $users->where('mobile', 'like', '%' . $searchValue . '%')
                ->orWhere('name', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%');
        }

        if ($limit < 0) {
            $users = $users->get();
        } else {
            $users = $users->skip($start)->limit($limit)->get();
        }

        $roles = Role::all();

        $admin = $users->filter(function($user){
            return $user->hasRole('admin');
        })->sortBy('created_at')->first();

        $users->each(function ($user) use ($roles, $admin) {
            // Verified or Unverified
            if ($user->is_verified == 1) {
                $user->is_verified = '<div class="btn btn-success btn-circle"><i class="fa fa-check"></i></div>';
            }

            if($user->is_verified == 0){
                $user->is_verified = '<div class="btn btn-danger btn-circle"><i class="fa fa-times"></i></div>';
            }

            if ($user->is_staff == 1) {
                $user->is_staff = '<div class="btn btn-success btn-circle"><i class="fa fa-check"></i></div>';
            }

            if($user->is_staff == 0){
                $user->is_staff = '<div class="btn btn-danger btn-circle"><i class="fa fa-times"></i></div>';
            }

            // Action
            $user->action = '';

            if ($user->id != ($admin == null ? 0 : $admin->id) && $this->user->cans('edit_user')) {
                $user->action .= '<a href="' . route('admin.user.edit', [$user->id]) . '" class="btn btn-primary btn-circle"
                    data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }

            if ($user->id != ($admin == null ? 0 : $admin->id) && $this->user->cans('delete_user')) {
                $user->action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                    data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $user->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
            }


            // Add Role
            // Get the user's role name
            $user->role_name = $user->role->role->display_name;

            // $user->role_name = '';
            // // Do not allow user to change own role
            // if ($user->id == ($admin == null ? 0 : $admin->id)) {
            //     $user->role_name = $user->role->role->display_name;
            // } elseif ($user->id == $this->user->id) {
            //     $user->role_name = $user->role->role->display_name;
            // } elseif (!$this->user->cans('edit_user')) {
            //     $user->role_name = $user->role->role->display_name;
            // } else {
            //     // User can edit role
            //     $roleOption = '<select name="role_id" class="form-control role_id" data-row-id="'.$user->id.'">';
            //     foreach ($roles as $role) {
            //         $roleOption .= '<option ';
            //         if ($user->id != ($admin == null ? 0 : $admin->id) && $user->role->role->id == $role->id) {
            //             $roleOption .= ' selected ';
            //         }
        
            //         $roleOption .= 'value="'.$role->id.'">'.ucwords($role->display_name).'</option>';
            //     }

            //     $roleOption .= '</select>';
            //     $user->role_name = $roleOption;
            // }


            // Modify the user's name to include the profile image
            $user->name = '<div class="image-container"><div class="image"><img src='.$user->profile_image_url.' /></div>'.ucwords($user->name).'</div>';
        });

        return DataTables::of($users)
        ->with([
            "draw" => (int)$draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $users,
        ])
        ->rawColumns(['name', 'email', 'role_name','is_verified','is_staff','action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function destroy($id)
    {
        abort_if(! $this->user->cans('delete_user'), 403);

        User::destroy($id);

        $branchName = Branch::find(auth()->user()->branch_id)->name;
        $logData = [
            'user_id' => auth()->user()->id, 
            'action' => 'user_deleted', 
            'details' => 'A user was deleted with id: ' . $id,
            'branch_id' => auth()->user()->branch_id,
            'branch_name' => $branchName,
            'created_at' => now(),
            'updated_at' => now() 
        ];
        
        $logDetails = "User ID: " . $logData['user_id'] . "\n" .
            "Action: " . $logData['action'] . "\n" .
            "Details: " . $logData['details'] . "\n" .
            "Branch ID: " . $logData['branch_id'] . "\n" .
            "Branch Name: " . $logData['branch_name'] . "\n" .
            "Created At: " . $logData['created_at'] . "\n" .
            "Updated At: " . $logData['updated_at'];
        
        UpdateLog::create([
            'data' => $logDetails,
            'end_device_id' => auth()->user()->branch_id,
            'created' => now(),
        ]); // Save the serialized data
        return Reply::success(__('messages.recordDeleted'));
    }

    public function changeRole(Request $request){
        //attach role
        $user = User::find($request->userId);

        RoleUser::where('user_id', $request->userId)->delete();
        $user->roles()->attach($request->roleId);

        return Reply::dataOnly(['status' => 'success']);
    }

    


}
