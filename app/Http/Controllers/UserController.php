<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Http\Controllers;

use App\Services\User\UserService;
use App\Traits\ResponseJsonWithHttpStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    use ResponseJsonWithHttpStatus;

    /**
     * Creat new user
     *
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function store(Request $request, UserService $userService): JsonResponse
    {
        try {
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'password' => 'required',

            ]);

            return $this->success($userService->store($request));
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , 400);
        }
    }

}
