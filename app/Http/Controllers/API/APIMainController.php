<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\UserFeedback;
use App\Http\Controllers\Controller;
use App\Helper\HashPassword;
use App\Helper\HttpClient;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Coupon;
use App\Models\SlidingBanner;
use App\Models\EventLog;
use JWTAuth;
use App\Models\coreapp_notification;
use App\Models\rewardapp_product;
use Yajra\DataTables\Facades\DataTables;
use App\Models\rewardapp_category;
use App\Models\SubCategory;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use ErrorException;
use App\Helper\Files;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class APIMainController extends APIBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

	public function login(Request $request)
	{
		$parameters = $request->only('phone', 'password');

		$user = User::where('mobile', '+977'.$parameters['phone'])->first();

		// if (!$user || ('+977'.$parameters['phone'] != $user->mobile || hash_hmac('sha256', '+977'.$parameters['phone'].$parameters['password'], env('JWT_SECRET')) != $user->password)) {
		if (!$user || ('+977'.$parameters['phone'] != $user->mobile || !HashPassword::verify($parameters['password'], $user->password))) {
			return response()->json(['detail' => 'No active account found with the given credentials'], 401);
		}

		if (!$user || $user->is_verified != 1) {
			return response()->json(['detail' => 'No active account found with the given credentials'], 401);
		}

		$token = JWTAuth::fromUser($user);

		$refreshToken = $token; //JWTAuth::fromUser($user);

		return response()->json([
			'success' => true,
			'message' => 'User logged in successfully',
			'token' => $token,
			'refresh' => $refreshToken,
			'user' => [
				'id' => $user->id,
				'email' => $user->email,
				'name' => $user->name,
				'phone' => $user->mobile,
				'is_verified' => $user->is_verified == 1 ? true : false,
				'last_login' => $user->last_login,
				'fcm' => $user->fcm,
				'picture' => $user->image != "" ? asset($user->image) : '',
				'sex' => $user->sex,
				'point' => $user->point,
			],
		]);
	}

	public function signup(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			//'email' => 'required|email|unique:users,email',
			'phone' => 'required|string|unique:users,mobile',
		]);

		if ($validator->fails()) {
			return response()->json([
				'errors' => $validator->errors(),
			], 400);
		}

		// try {
			$userCheck = User::where('mobile', '+977'.$request->phone)->first();

			if ($userCheck) {
				return response()->json(['detail' => 'User found with the given phone number'], 404);
			}
	
			$branch = Branch::orderBy('id', 'asc')->first();

			$password = Str::random(8);

			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->mobile = '+977'.$request->phone;
			$user->password = HashPassword::create($password);
			$user->address = $request->address;
			$user->sex = $request->gender;
			$user->dob = $request->dob;
			$user->is_staff = 0;
			$user->is_verified = 1;
			$user->branch_id = $branch->id;
			$user->save();

			//Send SMS
			$sms_message = "Dear ".$user->name.",\nYour Account has been Created for A to Z Mobile!\nPassword is ".$password;

			HttpClient::send_sms($user, $sms_message);
			
			//attach role
			$user->roles()->attach(4);

			return response()->json([
				'success' => true,
				'message' => 'User registered successfully',
				'user' => [
					'id' => $user->id,
					'name' => $user->name,
					'email' => $user->email,
					'mobile' => $user->mobile,
				],
			]);
		// } catch (\Throwable $e) {
		// 	return response()->json([
		// 		'detail' => 'An error occurred while processing the signup',
		// 		'code' => 'signup_error',
		// 	], 500);
		// }
	}

	public function forgotPassword(Request $request)
	{
		
		$parameters = $request->only('phone');

		$user = User::where('mobile', '+977'.$parameters['phone'])->first();

		if (!$user) {
			return response()->json(['detail' => 'No user found with the given phone number'], 404);
		}

		$newPassword = Str::random(8);

		$user->password = HashPassword::create($newPassword);
		$user->save();

		//Send SMS
		$sms_message = "Dear ".$user->name.",\nYour password has been changed for A to Z Mobile!\nPassword is ".$newPassword;

		HttpClient::send_sms($user, $sms_message);
		
		return response()->json(['message' => 'Password reset successful. New password sent to user']);
	}

	public function refresh(Request $request)
    {
		$parameters = $request->only('token');

		if(!$parameters) {
			return response()->json([
				'token' => [
					"This field is required."
				],
			], 400);
		}

		/*try {
			$token = JWTAuth::getToken();

			$token = JWTAuth::refresh($parameters['token']);
		} catch(TokenInvalidException $e) {
			return response()->json([
				'detail' => 'Token is invalid or expired',
				'code' => 'token_not_valid',
			], 401);
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Token is invalid or expired',
				'code' => 'token_not_valid',
			], 401);
		} catch(ErrorException $e) {
			return response()->json([
				'error' => [
					"This field is required."
				],
			], 400);
		}*/

		try {
			$token = JWTAuth::getToken();

			$token = JWTAuth::refresh($parameters['token']);

			$refreshToken = $token; //JWTAuth::refresh($parameters['token']);
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Token is invalid or expired',
				'code' => 'token_not_valid',
			], 401);
		}

		return response()->json([
			'access' => $token,
			'refresh' => $refreshToken,
		]);
    }

	public function deleteAccount(Request $request)
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		$parameters = $request->only('phone');

		// $user = User::where('mobile', '+977'.$parameters['phone'])->first();
		$user = User::where('mobile', $parameters['phone'])->first();

		if (!$user) {
			return response()->json(['detail' => 'No user found with the given phone number'], 404);
		}

		$user->is_verified = 0;
		$user->save();

		return response()->json([
			'success' => true,
			'message' => 'User deleted successfully',
		]);
	}

	public function profile(Request $request)
	{
		/*try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
				return response()->json([
					'detail' => 'Cannot Authenticate',
				], 401);
            }
        } catch(TokenInvalidException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Authentication credentials were not provided.',
			], 401);
		} catch(ErrorException $e) {
			return response()->json([
				'error' => [
					"This field is required."
				],
			], 400);
		}*/

		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		try {
			DB::table('users')->where('id', $user->id)->limit(1)->update(array('fcm' => $request->fcm_token));

			return response()->json([
				'id' => $user->id,
				'email' => $user->email,
				'name' => $user->name,
				'phone' => $user->mobile,
				'is_verified' => $user->mobile_verified == 1 ? true : false,
				'last_login' => $user->last_login,
				'fcm' => $user->fcm,
				'picture' => $user->image != "" ? asset($user->image) : '',
				'sex' => $user->sex,
				'point' => $user->point,
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}

	public function sliders()
	{
		try {
			$data = SlidingBanner::where('is_Active', true)->get()->map(function ($banner) {
				return [
					'id' => $banner->id,
					'image' =>asset('user-uploads/banners/'.$banner->image),
					'title' => $banner->title,
					'url' => $banner->url,
					'desc' => $banner->desc,
					'views' => intval($banner->views)
				];
			});

    		return response()->json($data);

		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}

	public function purchase()
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		try {
			$count = Purchase::where('user_id', $user->id)->count();

			$purchases = Purchase::where('user_id', $user->id)->get();

			$data = $purchases->map(function ($purchase) {
				$branches = Branch::where('id', $purchase->branch_id)->first();

				if ($branches) {
					$branchdata = [
						"id" => $branches->id,
						"name" => $branches->name,
						"address" => $branches->address,
						"image" => asset('user-uploads/branches/'.$branches->image),
						"phone" => $branches->phone,
						"email" => $branches->email,
						"desc" => $branches->desc,
						"contact_person" => $branches->contact_person,
					];
				} else {
					$branchdata = null;
				}

				if ($branches) {
					$enddevicedata = [
						"id" => $branches->id,
						"created" => $branches->created_at,
						"device_id" => '',
						"unique_id" => '',
						"paired" => true,
						"desc" => $branches->desc,
						"branch" => $branches->id,
					];
				} else {
					$enddevicedata = null;
				}

				return [
					'id' => $purchase->id,
					'purchase_id' => $purchase->purchase_id,
					'master_id' => $purchase->master_id,
					"points" => strval($purchase->points),
					"date" => $purchase->date,
					"bill_no" => $purchase->bill_no,
					"total" => strval($purchase->total),
					"gross_amount" => strval($purchase->gross_amount),
					"discount" => strval($purchase->discount),
					"nepali_date" => $purchase->nepali_date,
					"branch" => $branchdata,
					"end_device" => $enddevicedata,
				];
			});

			return response()->json([
				'count' => $count,
				'next' => null,
				'previous' => null,
				'results' => $data,
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}

	public function purchaseitem(Request $request)
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		$parameters = $request->only('purchase');

		if(!$parameters) {
			return response()->json([
				'purchase' => [
					'This field is required.'
				],
			], 400);
		}	

		try {
			$data = PurchaseItem::where(['purchase_id' => $parameters['purchase']])->get()->map(function ($purchaseItem) {
				return [
					'id' => $purchaseItem->id,
					'item_name' => $purchaseItem->item_name,
					'item_price' => $purchaseItem->item_price,
					'quantity' => $purchaseItem->quantity,
					'purchase' => $purchaseItem->purchase_id,
				];
			});

    		return response()->json($data);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 400);
		}
	}

	public function categories()
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		try {
			$count = rewardapp_category::count();

			$categories = rewardapp_category::all();

			$data = $categories ->map(function ($category) {
				return [
					'id' => $category->id,
					'name' => $category->name,
					'image' => asset('user-uploads/catagories/'.$category->image),
				];
			});

			return response()->json ([
				'count' => $count,
				'next' => null,
				'previous' => null,
				'results' => $data,
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}


	public function subcategories(Request $request)
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		try {
			$parameters = $request->only('category');

			if(!$parameters) {
				return response()->json([
					'category' => [
						"This field is required."
					],
				], 400);
			}	
	
			$count = SubCategory::where('category_id', $parameters['category'])->count();

			$subcategories = SubCategory::where('category_id', $parameters['category'])->get();

			$data = $subcategories ->map(function ($subcategory) {
				return [
					'id' => $subcategory->id,
					'name' => $subcategory->name,
					'image' => asset('user-uploads/sub-catagories/'.$subcategory->image),
					'category_id' => $subcategory->category_id,
				];
			});

			return response()->json ([
				'count' => $count,
				'next' => null,
				'previous' => null,
				'results' => $data,
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}

	public function products(Request $request)
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		$parameters = $request->only('category');

		if(!$parameters) {
			return response()->json([
				'category' => [
					"This field is required."
				],
			], 400);
		}	

		$products = rewardapp_product::where('category_id', $parameters['category'])->get();

		$data = $products->map(function ($product) {
			$category = rewardapp_category::where('id',$product->category_id)->first();

			if ($category) {
				$catdata = [
					'id' => $category->id,
					'name' => $category->name,
					'image' => asset('user-uploads/catagory/' . $category->image),
				];
			} else {
				$catdata = null;
			}

			return [
				'id' => $product->id,
				'name' => $product->name,
				'image' => asset('user-uploads/product/'.$product->image),
				'desc' => $product->desc,
				'price' => $product->price,
				"category" => $catdata,
			];
		});

		try {
			$count = rewardapp_product::where('category_id', $parameters['category'])->count();

			return response()->json([
				"count" => $count,
				"next" => null,
				"previous" => null,
				'results' => $data
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}

	public function notifications()
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		try {
			$data = coreapp_notification::all()->map(function ($notification) {
				return [
					'id' => $notification->id,
					'title' => $notification->title,
					'details' => $notification->details,
					'created' => $notification->created,
					'user' => $notification->user_id,
				];
			});

			return response()->json([
				'next' => null,
				'previous' => null,
				'results' => $data,
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}

	public function coupons()
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		try {
			$data = Coupon::all()->map(function ($coupon) {
				return [
					'id' => $coupon->id,
					'point' => $coupon->point,
					'image' => asset('user-uploads/eventlogs/'.$coupon->image),
					'title' => $coupon->title,
					'desc' => $coupon->desc,
					'created' => $coupon->created,
					'start_date' => $coupon->start_date,
					'end_date' => $coupon->end_date
				];
			});

			return response()->json($data);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}
	}

	public function branches()
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		try {
			$data = Branch::all()->map(function ($branch) {
				return [
					'id' => $branch->id,
					'name' => $branch->name,
					'address' => $branch->address,
					'image' => asset('user-uploads/branches/'.$branch->image),
					'phone' => $branch->phone,
					'email' => $branch->email,
					'desc' => $branch->desc,
					'contact_person' => $branch->contact_person
				];
			});

			return response()->json($data);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'Parse Error',
				'code' => 'parse_Error',
			], 401);
		}		
	}

	public function feedback()
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		$data = UserFeedback::all();

		$count = UserFeedback::count();

		return response()->json(
			$data
		);
	}

	public function postFeedback(Request $request)
	{
		try {
			$user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		$requestBody = json_decode($request->getContent(), true);

		$validator = Validator::make($request->all(), [
			'details' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json([
				'errors' => $validator->errors(),
			], 400);
		}

		try {
			$feedback = new UserFeedback();
			$feedback->user_id = $user->id;
			$feedback->details = $request->details;
			$feedback->created = now();
			$feedback->status = 0;
			$feedback->save();

			return response()->json([
				'message' => 'Feedback received successfully',
				'feedback' => $feedback,
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'An error occurred while processing the feedback',
				'code' => 'feedback_error',
			], 500);
		}
	}

	public function events()
	{
		try {
            $user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		$count = EventLog::where('user_id', $user->id)->count();

		$events = EventLog::where('user_id', $user->id)->get();

		$data = $events->map(function ($event) {
			return [
				'id' => $event->id,
				'user_id' => $event->user_id,
				'title' => $event->title,
				'desc' => $event->desc,
				'image' => asset('user-uploads/eventlogs/'.$event->image),
				'created_at' => $event->created_at,
			];
		});

		return response()->json ([
			'count' => $count,
			'next' => null,
			'previous' => null,
			'results' => $data,
		]);

		return response()->json(
			$data
		);
	}

	public function postEvents(Request $request)
	{
		try {
			$user = JWTAuth::parseToken()->authenticate();
		} catch(JWTException $e) {
			return response()->json([
				'detail' => 'Given token not valid for any token type',
				'code' => 'token_not_valid',
			], 401);
		}

		$validator = Validator::make($request->all(), [
			'title' => 'required|string',
			'desc' => 'required|string',
			'image' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json([
				'errors' => $validator->errors(),
			], 400);
		}

		$count = EventLog::where('user_id', $user->id)->count();

		if ($count > 0) {
			return response()->json([
				'detail' => 'Event already exists',
				'code' => 'already_exists',
			], 401);
		}

		try {
			$eventlogs = new EventLog();
			$eventlogs->user_id = $user->id;
			$eventlogs->title = $request->title;
			$eventlogs->desc = $request->desc;
			$eventlogs->start_date = $request->start_date;
			$eventlogs->end_date = $request->end_date;
			if ($request->hasFile('image')) {
				$eventlogs->image = Files::uploadResize($request->image, 'eventlogs');
			}
			$eventlogs->save();

			return response()->json([
				'message' => 'Event received successfully',
				'eventlog' => $eventlogs,
			]);
		} catch (\Throwable $e) {
			return response()->json([
				'detail' => 'An error occurred while processing the Eventlog',
				'code' => 'Eventlog_error',
			], 500);
		}
	}

	// public function getAllUsers(Request $request) {
	// 	$validateHeader = $this->validateRequest($request);

	// 	if (!$validateHeader) {
	// 		return response()->json([
	// 			'success' => 0
	// 		], 401);
	// 	}

	// 	// $requestBody = json_decode($request->getContent(), true);

	// 	// $userID = $requestBody['userID'];

	// 	//Response
	// 	$response["users"] = array();

	// 	$users = User::orderByDesc('created_at')->get();

	// 	if (sizeof($users) != 0) {
	// 		return $users;
	// 	} else {
	// 		return response()->json([
	// 			'success' => 0
	// 		]);
	// 	}
	// }

	// public function postUser(Request $request)
    // {
	// 	$validateHeader = $this->validateRequest($request);

	// 	if (!$validateHeader) {
	// 		return response()->json([
	// 			'success' => 0
	// 		], 401);
	// 	}

	// 	/* Method 1 - Using Json Body */
	// 	$requestBody = json_decode($request->getContent(), true);
    //     $user = new User();
    //     $user->name = $requestBody['name'];
    //     $user->email = $requestBody['email'];
    //     $user->mobile = $requestBody['mobile'];
    //     $user->mobile_verified = $requestBpdy['mobile_verified'];

	// 	// // /* Method 2 - Using Form Data */
    //     // $user = new User();
    //     // $user->name = $request->name;
    //     // $user->email = $request->email;
    //     // $user->mobile = $request->mobile;
    //     // $user->mobile_verified = $request->mobile_verified;
    //     // if ($request->hasFile('image')) {
    //     //     $user->image = Files::upload($request->image, 'image', null, null, false);
    //     // }

    //     $user->save();

	// 	return response()->json([
	// 		'success' => 1
	// 	]);
    // }


	public function updateUserPoints(Request $request)
{
    $users = User::all();

    foreach ($users as $user) {
        // Sum points from the Gifts and Purchases relationships
        $giftPoints = $user->gifts->sum('points');
        $purchasePoints = $user->purchases->sum('points');
        $totalPoints = $giftPoints + $purchasePoints;

        // Update the user's points
        $user->update(['points' => $totalPoints]);
    }

    return response()->json([
        'success' => true,
        'message' => 'User points updated successfully',
    ]);
}



}
