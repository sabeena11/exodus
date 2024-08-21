<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Trebol\Entrust\Traits\EntrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class CoreAppUser extends Authenticatable implements JWTSubject
{
    use Notifiable, EntrustUserTrait,HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
protected $table = 'coreapp_user';
     protected $fillable = [
        'name', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends =[
        'profile_image_url', 'mobile_with_code', 'formatted_mobile'
    ];

    public function getProfileImageUrlAttribute(){
        if(is_null($this->image)){
            return asset('avatar.png');
        }
        return asset_url('profile/'.$this->image);
    }

    public function role() {
        return $this->hasOne(RoleUser::class, 'user_id');
    }

    public static function allAdmins($exceptId = NULL)
    {
        $users = CoreAppUser::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.mobile', 'users.mobile_verified', 'users.created_at')
            ->where('roles.id', 1);

        if(!is_null($exceptId)){
            $users->where('users.id', '<>', $exceptId);
        }

        return $users->get();
    }

    public function getMobileWithCodeAttribute()
    {
        return $this->mobile;
    }

    public function getFormattedMobileAttribute()
    {
        return $this->mobile;
    }
      public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
