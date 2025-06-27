<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function adminlogin(Request $request)
    {
     
         $identifiants = $request->only('email', 'password', 'role');
         $remember = $request->boolean('remember');

    if (Auth::attempt($identifiants, $remember)&& Auth::user()->role
 === "admin") 
    {
        $request->session()->regenerate();
        return redirect()->route('login');
    } 

    else if (Auth::attempt($identifiants, $remember)&& Auth::user()->role
 === "utilisateur") 
    {
      $request->session()->regenerate();
      return redirect()->intended(RouteServiceProvider::HOME);
    } 

    else
    {
        return redirect()->back()->withErrors([
            'email' => "Les identifiants fournis ne correspondent à aucun compte.",
        ]);

    }


    }

    public function dashboardadmin(Request $request)
    {
     
         $identifiants = $request->only('email', 'password', 'role');
         $remember = $request->boolean('remember');

    if (Auth::attempt($identifiants, $remember)&& Auth::user()->role
 === "admin") 
    {
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    } 


    else
    {
        return redirect()->back()->withErrors([
            'email' => "Les identifiants fournis ne correspondent à aucun compte.",
        ]);

    }


    }
    
}
