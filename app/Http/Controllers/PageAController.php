<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use App\Services\GameService;
use App\Services\LinkService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageAController extends Controller
{
	/**
	 * @param $link
	 * @param LinkService $linkService
	 * @return Factory|View|Application|RedirectResponse|\Illuminate\Contracts\Foundation\Application
	 */
	public function show($link, LinkService $linkService): Factory|View|Application|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
	{
		$user = $linkService->getUserByLink($link);
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'Not found link.');
		}
		
		if(!$linkService->isUserHasUniqueLink($user)) {
			return redirect()->route('registration.form')->with('error', 'Sorry, your link has expired.');
		}
		
		if (!$linkService->isActiveLink($user)) {
			return redirect()->route('register')->with('error', 'Sorry, your link has expired.');
		}
		
		return view('pages.pageA', ['user' => $user]);
	}
	
	public function createNewLink($link, LinkService $linkService): \Illuminate\Http\RedirectResponse
	{
		$user = $linkService->getUserByLink($link);
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'User not found.');
		}
		
		$uniqueLink = $linkService->generateNewLink($user);
		
		return redirect()->route('pages.pageA', ['link' => $uniqueLink])
			->with('successMessage', 'Your link has been regenerated.');
	}
	
	public function destroyLink($link, LinkService $linkService): \Illuminate\Http\RedirectResponse
	{
		$user = $linkService->getUserByLink($link);
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'Invalid link.');
		}
		
		$linkService->destroyLink($user);
		
		return redirect()->route('register')
			->with('error', 'Your link has been deleted, please create a new one!');
	}
	
	
	public function playGame(GameService $gameService, LinkService $linkService)
	{
		$user = Auth::user();
		$link = $linkService->getLinkByUser($user);
		$gameResult = $gameService->playGame($user);
		
		session([
			'randomNumber' => $gameResult['randomNumber'],
			'result' => $gameResult['result'],
			'winAmount' => $gameResult['winAmount'],
		]);


		return redirect()->route('pages.pageA', [
			'link' => $link])->with('gameStart', 'Game start');
	}
	
	
	public function history(GameService $gameService, LinkService $linkService)
	{
		$user = Auth::user();
		$link = $linkService->getLinkByUser($user);
		$gameHistory = $gameService->history($user);
		
		session([
			'gameHistory' => $gameHistory,
		
		]);
		
		return redirect()->route('pages.pageA', [
			'link' => $link])->with('history', 'history');
	}
	
	
	
	
}
