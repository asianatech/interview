<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->save();

        return response()->json(['success' => 'user save']);
    }

    public function edit($id, Request $request)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json(['error' => 'user not found'], 404);
        }

        $user->name = $request->name;
        $user->save();

        return response()->json(['success' => 'user updated']);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json(['error' => 'user not found'], 404);
        }

        $user->delete();

        return response()->json(['success' => 'user has been deleted']);

    }
}
