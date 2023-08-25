<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LinkService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class PageAController extends Controller
{
	public function show($link, LinkService $linkService)
	{
		$user = User::where('unique_link', $link)->first();
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'Invalid link.');
		}
		if ($linkService->checkLinkExpiration($user)) {
			$user->delete();
			return redirect()->route('register')->with('error', 'Sorry, your link has expired.');
		}
		
//		session(['user' => $user]);
//		$user = session('user');
		
		return view('pages.pageA', ['user' => $user]);
	}
	
	
	
	public function createNewLink($link, LinkService $linkService): \Illuminate\Http\RedirectResponse
	{
		$user = User::where('unique_link', $link)->first();
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'User not found.');
		}
		
		$uniqueLink = $linkService->generateNewLink($user);
		
		return redirect()->route('pages.pageA', ['link' => $uniqueLink])
			->with('successMessage', 'Your link has been regenerated.');
	}
	
	public function destroyLink($link): \Illuminate\Http\RedirectResponse
	{
		$user = User::where('unique_link', $link)->first();
		if (!$user) {
			return redirect()->route('register')->with('error', 'Invalid link.');
		}
		
		$user->update(['unique_link' => '4']);
		
		return redirect()->route('pages.pageA', ['link' => $user->unique_link])
			->with('successDestroy', 'Your link deleted.');
	}
	
	
	
	
}
