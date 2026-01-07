<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user()
        ]);
    }

    // Update profile details
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists('public/profile/' . $user->profile_image)) {
                Storage::delete('public/profile/' . $user->profile_image);
            }

            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/profile', $imageName);
            $user->profile_image = $imageName;
        }

        // Update
        $user->update($request->only([
            'name',
            'email',
            'phone',
            'company',
            'job',
            'country',
            'address',
            'about',
        ]));

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }

    // Delete profile image
    public function deleteImage()
    {
        $user = Auth::user();

        if ($user->profile_image && Storage::exists('public/profile/' . $user->profile_image)) {
            Storage::delete('public/profile/' . $user->profile_image);
        }

        $user->profile_image = null;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile image deleted successfully');
    }

    // Change password
    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Wrong password']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password changed successfully');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old image if exists
        if ($user->profile_image && Storage::exists('public/profile/' . $user->profile_image)) {
            Storage::delete('public/profile/' . $user->profile_image);
        }

        // Save new image
        $image = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/profile', $imageName);

        $user->profile_image = $imageName;
        $user->save();

        // Return JSON for Ajax
        return response()->json([
            'success' => true,
            'profile_image_url' => asset('storage/profile/' . $imageName)
        ]);
    }
}
