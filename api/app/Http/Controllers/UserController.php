<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getData(Request $request)
    {
        $user = $this->userService->getData();

        return response()->json(['user' => $user], 200);
    }
}
