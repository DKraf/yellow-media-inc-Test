<?php

/**
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Services\Auth;

use App\Models\User;
use App\Services\IAuth;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Facades\Password;
use Laravel\Lumen\Routing\Controller;
use function Symfony\Component\Translation\t;

class AuthService implements IAuth
{

    /**
     * Login method
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function login(Request $request): mixed
    {
        if (!$user = User::where('email', $request->input('email'))->first()) {

            throw new \Exception('User is not found', 404);
        }

        if (!Hash::check($request->input('password'), $user->password)) {

            throw new \Exception('Incorrect password', 401);
        }

        try {
            $apikey = base64_encode(Str::random(40));
            $user->update(['api_token' => $apikey]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);

        }
        return [
            'user_id' => $user->id,
            'api_token' => $apikey,
        ];

    }


    /**
     * logout method
     *
     * @return array
     * @throws \Exception
     */
    public function logout()
    {
        if (!$user = Auth::user()) {
            throw new \Exception('Unauthorized', 401);
        }

        $user->update(['api_token' => null]);

        return ['user_id' => $user->id];
    }


    /**
     * Send Email for reset pass
     *
     * @param Request $request
     * @return bool[]|false[]
     * @throws \Exception
     */
    public function recoverPassword(Request $request)
    {
        try {
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
        return ($response == Password::RESET_LINK_SENT)
            ? ['sent' => true]
            : ['sent' => false];
    }

    /**
     * Reset pass
     *
     * @param Request $request
     * @return array
     */
    public function resetPassword(Request $request): array
    {
        $response = $this->broker()->reset($this->credentials($request),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
        return ($response == Password::PASSWORD_RESET)
            ? ['reset' => true]
            : ['reset' => false];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request): array
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }


    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        $passwordBrokerManager = new PasswordBrokerManager(app());
        return $passwordBrokerManager->broker();
    }
}
