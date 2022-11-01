<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Http\Controllers;

use App\Services\Auth\AuthService;
use App\Traits\ResponseJsonWithHttpStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use ResponseJsonWithHttpStatus;

    /**
     * Login method
     *
     * @param Request $request
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function login(Request $request, AuthService $authService): JsonResponse
    {
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);

            return $this->success($authService->login($request));
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , 400);
        }
    }


    /**
     * Logout method
     *
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function logout (AuthService $authService): JsonResponse
    {
        try {
            return $this->success($authService->logout());
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , $e->getCode());
        }
    }


    /**
     * @param Request $request
     * @param AuthService $authService
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function recoverPassword(Request $request, AuthService $authService): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        try {
            return $this->success($authService->recoverPassword($request));
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , $e->getCode());
        }
    }


    /**
     * @param Request $request
     * @param AuthService $authService
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request, AuthService $authService): JsonResponse
    {
        $this->validate($request, [
            'token'    => 'required',
            'email' => 'required|string',
            'password' => 'required|min:6',
            ]);

        try {
            return $this->success($authService->resetPassword($request));
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , $e->getCode());
        }
    }
}
