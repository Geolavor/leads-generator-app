<?php

namespace LeadBrowser\API\Http\Controllers\V1\User;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use LeadBrowser\Admin\Notifications\User\UserResetPassword;
use LeadBrowser\API\Http\Controllers\V1\Controller;
use LeadBrowser\API\Http\Resources\V1\Setting\UserResource;
use LeadBrowser\User\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LeadBrowser\User\Repositories\UserRepository  $userRepository
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request, UserRepository $userRepository)
    {
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
            'device_name' => 'required',
        ]);

        $user = $userRepository->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        /**
         * Preventing multiple token creation.
         */
        $user->tokens()->delete();

        return response([
            'data'    => new UserResource($user),
            'message' => __('rest-api::app.common-response.success.login')
        ]);
    }

    /**
     * Logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $customer = $request->user();

        $customer->tokens()->delete();

        return response([
            'message' => __('rest-api::app.common-response.success.logout'),
        ]);
    }

    /**
     * Send forgot password link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = Password::broker('users')->sendResetLink($request->only('email'), function ($user, $token) {
            $user->notify(new UserResetPassword($token));
        });

        if ($response == Password::RESET_LINK_SENT) {
            return response([
                'message' => __('admin::app.sessions.forgot-password.reset-link-sent'),
            ]);
        }

        return response([
            'message' => __('admin::app.sessions.forgot-password.email-not-exist'),
        ], 400);
    }

    /**
     * Register user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LeadBrowser\User\Repositories\UserRepository  $userRepository
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, UserRepository $userRepository)
    {
        $request->validate([
            'email'       => 'required|email|unique:users,email',
            'name'        => 'required',
            'password'    => 'required'
        ]);

        $data = request()->all();

        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        }

        $data['status'] = 1;
        $data['role_id'] = 2;
        $data['view_permission'] = 'individual';

        $user = $userRepository->create($data);
        $user->save();

        $user = $userRepository->where('email', $data['email'])->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['The provided credentials are incorrect.'],
        //     ]);
        // }

        event(new Registered($user));

        return response([
            'data'    => new UserResource($user),
            'message' => __('rest-api::app.common-response.success.register'),
            'token'   => $user->createToken('register-api')->plainTextToken
        ]);
    }
}
