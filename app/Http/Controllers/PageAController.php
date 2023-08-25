<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageAController extends Controller
{
	public function show($link)
	{
		$user = User::where('unique_link', $link)->first();
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'Invalid link.');
		}
		$currentDate = Carbon::now();
		$expirationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->addDays(7);
		
		if ($expirationDate->lt($currentDate)) {
			$user->delete();
			return redirect()->route('register')->with('error', 'Sorry, your link has expired.');
		}
		
//		session(['user' => $user]);
//		$user = session('user');
		
		return view('pages.pageA', ['user' => $user]);
	}
	
	
	
	public function createNewLink($link)
	{
	
	}
	
	public function destroyLink($link)
	{
	
	}
	
	
	
	
}
