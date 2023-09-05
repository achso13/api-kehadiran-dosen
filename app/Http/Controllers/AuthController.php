<?php

namespace App\Http\Controllers;

use App\Helpers\FormatHelpers;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function validateDosen()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:45',
            'jabatan' => 'required|string|max:90',
            'username' => 'required|string|max:255|unique:dosen,username',
            'password' => 'required|string',
            'image_url' => 'nullable|sometimes|image|mimes:jpg,png,jpeg|max:512',
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validateDosen();

        if ($validator->fails()) {
            return response()->json([
                'message' => "failed",
                'errors' => FormatHelpers::formatErrors($validator),
            ], 422);
        }

        $data = [
            'name' => $request->input('name'),
            'jabatan' => $request->input('jabatan'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'status' => false,
        ];

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('images', 'public');
            $data['image_url'] = $path;
        }

        $user = Dosen::create($data);

        return response()->json([
            'message' => "success",
            'data' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API_TOKEN')->plainTextToken;

            return response()->json([
                'message' => "success",
                'data' => [
                    'token' => $token
                ]
            ], 200);
        }

        return response()->json([
            'message' => "Authentication failed. Wrong username or password",
            'errors' => null
        ], 401);
    }
}
