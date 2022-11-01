<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Services\User;

use App\Models\User;
use App\Services\IUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService implements IUser
{

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function store(Request $request): mixed
    {
        $inData = $request->all();

        $user = User::where('email', $inData['email'])->first();

        if ($user) {
            throw new \Exception('User with this email already exists', 400);
        }

        $inData['password'] = Hash::make($inData['password']);

        $id = User::create($inData);

        return ['id' => $id->id];
    }

}
