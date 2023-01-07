<?php

namespace LeadBrowser\API\Http\Controllers\V1\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use LeadBrowser\API\Http\Controllers\V1\Controller;
use LeadBrowser\API\Http\Resources\V1\Setting\UserResource;
use LeadBrowser\User\Models\User;

class AccountController extends Controller
{
    /**
     * Get the details for current logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    /**
     * Update the details for current logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $isPasswordChanged = false;

        $data = $request->validate([
            'name'             => 'required',
            'email'            => 'email|unique:users,email,' . $user->id,
            'password'         => 'nullable|min:6|confirmed',
            'current_password' => 'nullable|required|min:6',
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            return response([
                'message' => __('admin::app.user.account.password-match'),
            ], 400);
        }

        if (isset($data['role_id']) || isset($data['view_permission'])) {
            return response([
                'message' => __('admin::app.user.account.permission-denied'),
            ], 400);
        }

        if (isset($data['password'])) {
            $isPasswordChanged = true;

            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        if ($isPasswordChanged) {
            Event::dispatch('user.account.update-password', $user);
        }

        return response([
            'data'    => new UserResource($user),
            'message' => __('admin::app.user.account.account-save'),
        ]);
    }

    /**
     * Get usage
     */
    public function getUsage(Request $request)
    {
        $user = $request->user();
        // $user = auth()->guard('user')->user();

        $usage = $user->usage;

        return response([
            'data'    => $usage,
            'message' => __('admin::app.user.account.account-save'),
        ]);
    }

    /**
     * Delete credit card
     */
    public function deleteCreditCard()
    {
        $user = auth()->guard('user')->user();

        User::findOrFail($user->id)->update([
            'pm_type' => null,
            'pm_last_four' => null
        ]);

        return response([
            'message' => __('admin::app.user.account.account-save'),
        ]);
    }
}
