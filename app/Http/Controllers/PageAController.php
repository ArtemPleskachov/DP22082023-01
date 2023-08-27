<?php

namespace App\Http\Controllers;

use App\Exceptions\DataNotFoundException;
use App\Services\GameService;
use App\Services\LinkService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
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
		try {
			$user = $linkService->getUserByLink($link);
		} catch (DataNotFoundException $e) {
			return redirect()->route('register')->with('error', $e->getMessage());
		}
		
		try {
			$linkService->isUserHasUniqueLink($user);
		} catch (DataNotFoundException $e) {
			return redirect()->route('register')->with('error', $e->getMessage());
		}
		
		if (!$linkService->isActiveLink($user)) {
			return redirect()->route('register')->with('error', 'Sorry, your link has expired.');
		}
		
		return view('pages.pageA', ['user' => $user]);
	}
	
	public function createNewLink($link, LinkService $linkService): \Illuminate\Http\RedirectResponse
	{
		try {
			$user = $linkService->getUserByLink($link);
		} catch (DataNotFoundException $e) {
			return redirect()->route('register')->with('error', $e->getMessage());
		}
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'User not found.');
		}
		
		$uniqueLink = $linkService->generateNewLink($user);
		
		return redirect()->route('pages.pageA', ['link' => $uniqueLink])
			->with('successMessage', 'Your link has been regenerated.');
	}
	
	public function destroyLink($link, LinkService $linkService): \Illuminate\Http\RedirectResponse
	{
		try {
			$user = $linkService->getUserByLink($link);
		} catch (DataNotFoundException $e) {
			return redirect()->route('register')->with('error', $e->getMessage());
		}
		
		if (!$user) {
			return redirect()->route('register')->with('error', 'Invalid link.');
		}
		
		$linkService->destroyLink($user);
		
		return redirect()->route('register')
			->with('error', 'Your link has been deleted, please create a new one!');
	}
	
	
	/**
	 * @param GameService $gameService
	 * @param LinkService $linkService
	 * @return RedirectResponse
	 */
	public function playGame(GameService $gameService, LinkService $linkService): RedirectResponse
	{
		$user = Auth::user();
		
		try {
			$link = $linkService->getLinkByUser($user);
		} catch (DataNotFoundException $e) {
			return redirect()->route('register')->with('error', $e->getMessage());
		}
		
		$gameResult = $gameService->playGame($user);
		
		session([
			'randomNumber' => $gameResult['randomNumber'],
			'result' => $gameResult['result'],
			'winAmount' => $gameResult['winAmount'],
		]);


		return redirect()->route('pages.pageA', [
			'link' => $link])->with('gameStart', 'Game start');
	}
	
	
	/**
	 * @param GameService $gameService
	 * @param LinkService $linkService
	 * @return RedirectResponse
	 */
	public function history(GameService $gameService, LinkService $linkService): RedirectResponse
	{
		$user = Auth::user();
		try {
			$link = $linkService->getLinkByUser($user);
		} catch (DataNotFoundException $e) {
			return redirect()->route('register')->with('error', $e->getMessage());
		}
		$gameHistory = $gameService->history($user);
		
		session([
			'gameHistory' => $gameHistory,
		]);
		
		return redirect()->route('pages.pageA', [
			'link' => $link])->with('history', 'history');
	}
}
