<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\UpdateProfile;
use App\Models\User;
use App\Helper\HashPassword;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.profile');
        $this->pageIcon = 'ti-user';
    }

    public function index()
    {
        return view('admin.profile.index', $this->data);
    }

    public function update(UpdateProfile $request)
    {
        $user = User::find($this->user->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password != '') {
            // $user->password = Hash::make($request->password);
            // $user->password = hash_hmac('sha256', '+977'.$request->mobile.$request->password, env('JWT_SECRET')); //Hash::make($request->password);
            $user->password = HashPassword::create($request->password);
        }

        if ($request->has('mobile')) {
            if ($user->mobile !== '+977'.$request->mobile) {
                $user->mobile_verified = 0;
            }

            $user->mobile = '+977'.$request->mobile;
        }

        if ($request->hasFile('image')) {
            $user->image = Files::uploadLocalOrS3($request->image, 'profile');
        }/*else{
             Files::deleteFile($user->image, 'profile');
            $user->image = null;
        }*/
        $user->save();

        return Reply::redirect(route('admin.profile.index'), __('menu.profile') . ' ' . __('app.messages.updatedSuccessfully'));
    }
}
