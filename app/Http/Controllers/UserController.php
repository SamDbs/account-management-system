<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class UserController extends Controller
{
    /**
     * Display all users
     *
     * @return InertiaResponse
     */
    public function index(): InertiaResponse
    {
        $response = Gate::inspect('viewAny', auth()->user());
        $authIsAdmin = auth()->user()->role->name === 'admin';
        if ($response->allowed()) {
            $users = User::withTrashed()->get();

            return Inertia::render('Dashboard', [
                'users' => $users,
                'status' => session('status'),
                'authIsAdmin' => $authIsAdmin,
            ]);
        }

        return Inertia::render('Dashboard', [
            'authIsAdmin' => $authIsAdmin,
        ]);
    }

    /**
     * Create form user
     *
     * @return InertiaResponse
     */
    public function create(): InertiaResponse
    {
        $response = Gate::inspect('create', auth()->user());

        if ($response->allowed()) {
            return Inertia::render('Auth/Form/NewUser');
        }
        abort('403');
    }

    /**
     * Store new user
     *
     * @param UserRequest $userRequest
     *
     * @throws ValidationException
     * @return RedirectResponse
     */
    public function store(UserRequest $userRequest, User $user): RedirectResponse
    {
        $response = Gate::inspect('store', auth()->user());

        if ($response->allowed()) {
            $validatedData = $userRequest->validated();

            $userRole = Role::where('name', 'user')->first();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'description' => $validatedData['description'],
                'password' =>  Hash::make($validatedData['password']),
                'role_id' => $userRole->id,
            ]);

            event(new Registered($user));

            return redirect('dashboard')->with('status', 'User has been created!');
        }
        abort('403');
    }

    /**
     * Display the user's form.
     *
     * @param User $user
     *
     * @return InertiaResponse
     */
    public function edit(User $user): InertiaResponse
    {
        $response = Gate::inspect('edit', $user);

        $authAdmin = auth()->user()->role->name === 'admin';
        if ($response->allowed()) {
            return Inertia::render('Profile/Edit', [
                'user' => $user,
                'authIsAdmin' => $authAdmin,
                'mustVerifyEmail' => $user instanceof MustVerifyEmail,
                'status' => session('status'),
            ]);
        }
        abort('403');
    }

    /**
     * Update the user's information.
     *
     * @param UserRequest $request
     *
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('user.edit', ['user' => $user]);
    }

    /**
     * Delete the user's account.
     *
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, User $user): RedirectResponse
    {
        $response = Gate::inspect('destroy', $user);

        // If user is admin or owner of profile
        if ($response->allowed()) {

            // If user is admin and try to delete user, we don't want to verify password
            if ($user->id !== auth()->id()) {
                $user->delete();

                return Redirect::to('/dashboard');
            }

            $request->validate([
                'password' => ['required', 'current-password'],
            ]);

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');
        }
        abort('403');
    }

    /**
     * Delete the user's account.
     *
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $response = Gate::inspect('destroy', $user);

        // If user is admin or owner of profile
        if ($response->allowed()) {
            $user->forceDelete();

            return Redirect::to('/dashboard');
        }
        abort('403');
    }
}
