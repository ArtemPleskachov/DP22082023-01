<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\PhoneAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\UniquePhone;
use App\Services\LinkService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
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
	
    public function store(Request $request, LinkService $linkService): RedirectResponse
	{
		$request->validate([
			'name' => 'required|string',
			'phone' => 'required|string|regex:/^(\+?\d{1,2})?\s?\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{2}[-\s]?\d{2}$/',
		]);
		try {
			$user = User::create([
				'name' => $request->name,
				'phone' => $request->phone,
			]);
		} catch (QueryException $e) {
			if ($e->getCode() === '23000') { // MySQL error code for duplicate entry
				return redirect()->route('register')->with('error', 'This phone number is already in use.');
			}
		}
		
		Auth::login($user);
		$linkService->generateNewLink($user);
		return redirect()->route('registration.link', ['id' => $user->id]);
	}
	
	/**
	 * @param $id
	 * @return Factory|View|\Illuminate\Foundation\Application|RedirectResponse|Application
	 */
	public function showLink($id): Factory|View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|Application
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
