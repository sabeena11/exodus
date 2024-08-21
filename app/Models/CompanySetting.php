<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = ['company_name', 'company_email', 'company_phone', 'website', 'address', 'locale', 'logo','facebook_url','linkedin_url','instagram_url','twitter_url'];
    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute()
    {
        if (is_null($this->logo)) {
            return asset('app-logo.png');
        }
        return asset_url('app-logo/' . $this->logo);
    }
}
