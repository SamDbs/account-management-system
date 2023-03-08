<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display all users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $response = Gate::inspect('viewAny', auth()->user());
        if ($response->allowed()) {
            $users = User::all();

            return Inertia::render('Dashboard', [
                'users' => $users,
                'status' => session('status'),
            ]);
        }
        return Inertia::render('Dashboard');
    }

    /**
     * Display the user's form.
     */
    public function edit(User $user): Response
    {
        $response = Gate::inspect('edit', $user);
        $roleAdmin = Role::where('name', 'admin')->first();

        $authAdmin = auth()->user()->role_id === $roleAdmin->id;
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
     */
    public function update(UserRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('user.edit', ['id' => $request->user()->id]);;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, User $user): RedirectResponse
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
}
