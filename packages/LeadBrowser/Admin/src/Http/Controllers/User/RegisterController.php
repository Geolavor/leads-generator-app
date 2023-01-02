<?php

namespace LeadBrowser\Admin\Http\Controllers\User;

use Illuminate\Support\Str;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Admin\Notifications\User\UserCreate;
use LeadBrowser\User\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * UserRepository object
     *
     * @var \LeadBrowser\User\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\User\Repositories\UserRepository  $userRepository
     * @return void
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (auth()->guard('user')->check()) {
            return redirect()->route('dashboard.index');
        } else {
            if (strpos(url()->previous(), 'admin') !== false) {
                $intendedUrl = url()->previous();
            } else {
                $intendedUrl = route('dashboard.index');
            }

            session()->put('url.intended', $intendedUrl);

            return view('admin::sessions.register');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'email'            => 'required|email|unique:users,email',
            'name'             => 'required',
            'password'         => 'nullable'
        ]);

        $data = request()->all();

        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        }

        $data['status'] = 1;
        $data['role_id'] = 2;
        $data['view_permission'] = 'individual';

        Event::dispatch('settings.user.create.before');
        
        $user = $this->userRepository->create($data);
        $user->save();

        // TODO: promo
        // Add amount to wallet
        // $user->deposit(20);

        // try {
        //     Mail::queue(new UserCreate($user));
        // } catch (\Exception $e) {
        //     report($e);
        // }

        $token = $user->createToken('register-api')->plainTextToken;

        event(new Registered($user));

        Event::dispatch('settings.user.create.after', $user);
        
        // session()->flash('success', trans('admin::app.settings.users.create-success'));

        auth()->guard('user')->attempt(request(['email', 'password']), request('remember'));

        return redirect()->intended(route('dashboard.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        auth()->guard('user')->logout();

        return redirect()->route('session.register');
    }
}