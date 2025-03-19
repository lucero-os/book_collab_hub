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

    public function addBookPermission(Request $request)
    {
        $request->validate([
            'userId' => 'required|integer',
            'bookId' => 'required|integer',
            'permissionCode' => 'required|string',
        ]);
        $credentials = $request->only('userId', 'bookId', 'permissionCode');

        $this->userService->addBookPermission($credentials);

        return response()->json(['message' => 'Permissions have been added'], 200);
    }
}
