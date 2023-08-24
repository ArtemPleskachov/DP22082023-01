<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
	/**
	 * @return Application|Factory|View|\Illuminate\Foundation\Application
	 */
	public function create(): \Illuminate\Foundation\Application|View|Factory|Application
	{
		return view('registration.form');
	}
	
	
    public function store(Request $request)
	{
		$uniqueLink = uniqid();
		
		$user = User::create([
			'name' => $request->name,
			'phone' => $request->phone,
			'unique_link' => $uniqueLink,
		]);
//		dd($request->all());
		Auth::login($user);
		
		return redirect('/link');
		
//		return redirect()->route('registration.link', ['user' => $user->id]);
	}
	
	
//	public function showLink($link)
//	{
//		$user = User::where('unique_link', $link)->first();
//
//		if (!$user) {
//			return redirect()->route('registration.form')->with('error', 'Invalid link.');
//		}
//
//		return view('registration.link', ['user' => $user]);
//	}
}
