<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class APIBaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validateRequest($request)
    {
        $hasHeader = $request->hasHeader('API-KEY');

        if (!$hasHeader) {
			return false;
		}

		$key = $request->header('API-KEY');

        if ($key == config('app.api_key')) {
            return true;
        }

        return false;
    }
}
