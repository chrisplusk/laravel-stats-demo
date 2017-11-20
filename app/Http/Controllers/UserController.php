<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate();
        
        return view('users/index', [
                                        'users' => $users
                                    ]);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store(StoreUser $request)
    {
        $user = User::create(   [
                                'name'      => $request->name,
                                'email'     => $request->email,
                                'password'  => bcrypt($request->password),
                                'public'    => $request->public
                                ] );
        
        $user->save();
        
        session()->flash('status', 'User created successfully');
        
        return redirect('users');
    }

    public function show($user)
    {
        return view('users.view', [
                                        'user' => $user
                                    ]);
    }

    public function edit($user)
    {
        return view('users.update', [
                                        'user' => $user
                                    ]);
    }

    public function update(UpdateUser $request, $user)
    {
        $user->update($request->all());

        session()->flash('status', 'User updated successfully');
        
        return redirect()->route('users.index');
    }

    public function destroy($user)
    {
        if ($user->delete()) {
            session()->flash('status', 'User deleted successfully');
        } else {
            session()->flash('status', 'Unable to delete user. Please try again');
        }

        return back();
    }
}
