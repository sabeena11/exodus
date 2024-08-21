<?php

namespace App\Traits;

use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Config;

trait FileSystemSettingTrait
{

    public function setFileSystemConfigs()
    {
        $settings = storage_setting();
        
        switch($settings->filesystem) {
        case 'local':
        config(['filesystems.default' => $settings->filesystem]);
            break;
        }
    }
}
