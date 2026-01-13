<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show user profile
     */
    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // avoid duplicate emails
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile image if uploaded
        if ($request->hasFile('profile_image')) {
            $this->deleteOldImage($user);

            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/profile', $imageName);
            $user->profile_image = $imageName;
        }

        // Update other fields
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'job' => $validated['job'] ?? null,
            'country' => $validated['country'] ?? null,
            'address' => $validated['address'] ?? null,
            'about' => $validated['about'] ?? null,
        ])->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }

    /**
     * Delete profile image
     */
    public function deleteImage(Request $request)
    {
        $user = Auth::user();
        $this->deleteOldImage($user);

        $user->profile_image = null;
        $user->save();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('profile.index')->with('success', 'Profile image deleted successfully');
    }

    /**
     * Change user password
     */
    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password changed successfully');
    }

    /**
     * Update profile image via Ajax
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $this->deleteOldImage($user);

        $image = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/profile', $imageName);

        $user->profile_image = $imageName;
        $user->save();

        return response()->json([
            'success' => true,
            'profile_image_url' => asset('storage/profile/' . $imageName)
        ]);
    }

    /**
     * Helper function to delete old profile image
     */
    private function deleteOldImage($user)
    {
        if ($user->profile_image && Storage::disk('public')->exists('profile/' . $user->profile_image)) {
            Storage::disk('public')->delete('profile/' . $user->profile_image);
        }
    }
}
