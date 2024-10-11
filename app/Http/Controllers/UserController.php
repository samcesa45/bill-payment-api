<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserApiRequest;
use App\Http\Requests\UpdateUserApiRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserApiRequest $request)
    {
        $user = User::create($request->only('name','email','password'));
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if(empty($user)) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserApiRequest $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->only('name','email','password'));
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->noContent();
    }
}
