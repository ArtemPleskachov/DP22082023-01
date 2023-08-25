<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
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
		$uniqueHash = md5($request->name . $request->phone . $request->user()->id . now());
		$uniqueLink = uniqid() . $uniqueHash;
		
		$user = User::create([
			'name' => $request->name,
			'phone' => $request->phone,
			'unique_link' => $uniqueLink,
		]);
		
		return redirect()->route('registration.link', ['id' => $user->id]);
	}
	
	public function showLink($id)
	{
		$user = User::where('id', $id)->first();
		$expirationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)
			->addDays(7)
			->format('d M Y');
		
		if (!$user) {
			return redirect()->route('registration.form')->with('error', 'Invalid link.');
		}
		
		return view('registration.link', ['user' => $user, 'expirationDate' => $expirationDate]);
	}
	
	
}
