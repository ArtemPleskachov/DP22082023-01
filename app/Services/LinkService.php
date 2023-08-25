<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LinkService
{
	public function generateNewLink(User $user): string
	{
		$uniqueHash = md5($user->name . $user->phone . $user->id . now());
		return uniqid() . $uniqueHash;
	}
	
	public function updateLink(User $user): void
	{
		$uniqueHash = md5($user->name . $user->phone . $user->id . now());
		$uniqueLink = uniqid() . $uniqueHash;
		$user->update(['unique_link' => $uniqueLink]);
		
	}
	
	
	public function destroyLink(User $user): void
	{
		$user->update(['unique_link' => null]);
	}
	
	public function checkLinkExpiration(User $user): bool
	{
		$currentDate = Carbon::now();
		$expirationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->addDays(7);
		
		return $expirationDate->lt($currentDate);
	}
	
	
	
	
}