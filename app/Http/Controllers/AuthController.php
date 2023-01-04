<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;

class AuthController extends Controller
{
    /** @var AuthService */
    private $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Create a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        $response = $this->authService->createUser($request);

        return $response;
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function loginUser(Request $request)
    {
        $response = $this->authService->loginUser($request);

        return $response;
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logoutUser(Request $request)
    {
        $response = $this->authService->logoutUser($request);

        return $response;
    }
}
