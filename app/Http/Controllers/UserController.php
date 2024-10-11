<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

use App\Models\User;

class UserController extends Controller
{
    // Index method with optional country code filter
    public function index($country_code = null)
    {
        $users = User::select('first_name', 'last_name', 'user_name', 'country_code', 'ip_address');

        // Filter by country code if provided and make sure it's a valid country code
        if ($country_code) {
            if (array_key_exists(strtoupper($country_code), config('countries'))) {
                $users = $users->where('country_code', $country_code);
            } else {
                return response()->json(['message' => 'Invalid country code.'], 400);
            }
        }

        $users = UserResource::collection($users->get());

        return response()->json($users, 200);
    }

    // Store a new user
    public function store(UserRequest $request)
    {
        // The request is automatically validated before reaching here
        $validatedData = $request->validated();

        // Create the user with validated data
        $user = new UserResource(User::create($validatedData));

        return response()->json($user, 201);
    }

}
