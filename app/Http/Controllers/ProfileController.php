<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = Profile::query();

        if ($request->ajax()) {
            $profiles = $query
                ->when($request->name, function (Builder $query) use ($request) {
                    return $query->where('name', 'LIKE', '%' . $request->name . '%');
                })
                ->when($request->email, function (Builder $query) use ($request) {
                    return $query->where('email', 'LIKE', '%' . $request->email . '%');
                })
                ->when($request->gender, function (Builder $query) use ($request) {
                    return $query->where('gender', 'LIKE', '%' . $request->gender . '%');
                })
                ->latest()
                ->get();

            return response()->json([
                'status' => true,
                'data' => [
                    'view' => view('profile-list', ['profiles' => $profiles])->render()
                ]
            ]);
        }

        return view('welcome');
    }

    public function create(Request $request, ?Profile $profile)
    {
        if ($request->ajax()) {
            $view = view('profile-form', ['profile' => $profile])->render();
    
            return response()->json([
                'status' => true,
                'data' => [
                    'view' => $view,
                ],
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles',
            'phone' => 'required|digits:10',
            'gender' => 'required|in:male,female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profileData = $request->except(['image', 'file']);

        if ($request->hasFile('image')) {
            $profileData['image'] = $request->file('image')->store('images', 'public');
        }

        if ($request->hasFile('file')) {
            $profileData['file'] = $request->file('file')->store('files', 'public');
        }

        $profile = Profile::create($profileData);

        return response()->json($profile);
    }

    public function edit(Request $request, Profile $profile)
    {
        return $this->create($request, $profile);
    }

    public function update(Request $request, Profile $profile)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:profiles,email,' . $profile->id,
                'phone' => 'required|digits:10',
                'gender' => 'required|in:male,female',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'file' => 'nullable|mimes:pdf|max:2048',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $profileData = $request->except(['image', 'file']);
    
            if ($request->hasFile('image')) {
                $profileData['image'] = $request->file('image')->store('images', 'public');
            }
    
            if ($request->hasFile('file')) {
                $profileData['file'] = $request->file('file')->store('files', 'public');
            }
    
            $profile->update($profileData);
    
            return response()->json($profile);
        }
    }

    public function destroy(Request $request, Profile $profile)
    {
        if ($request->ajax()) {
            $profile->delete();

            return response()->json(['success' => true]);
        }
    }
}
