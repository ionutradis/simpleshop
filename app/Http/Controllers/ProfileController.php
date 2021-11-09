<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function show() {
        return view('user/profile');
    }
    public function index() {
        return view('user/profile');
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();
        return redirect('user/profile')->with('message', 'User profile updated!');
    }

    public function orders() {
        return view('user/orders', ['orders'=>Order::where('user_id', Auth::user()->id)->orderByDesc('created_at')->paginate(10)]);
    }
}
