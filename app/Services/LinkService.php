<?php

namespace App\Services;

use App\Exceptions\DataNotFoundException;
use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LinkService
{
	/**
	 * @param User $user
	 * @return bool
	 * @throws DataNotFoundException
	 */
	public function isUserHasUniqueLink(User $user): bool
	{
		$userHasLink = $user->links()->where('active', true)->exists();
		if (!$userHasLink) {
			throw new DataNotFoundException('This user has no link');
		}
		return true;
	}
	
	/**
	 * @param $link
	 * @return mixed
	 * @throws DataNotFoundException
	 */
	public function getUserByLink($link): mixed
	{
		$user = Link::where('unique_link', $link)->first()->user;
		if (!$user) {
			throw new DataNotFoundException('User not found');
		}
		return $user;
	}
	
	/**
	 * @param $user
	 * @return mixed
	 * @throws DataNotFoundException
	 */
	public function getLinkByUser($user): mixed
	{
		$link = $user->links->first()->unique_link;
		if (!$link) {
			throw new DataNotFoundException('Link not found');
		}
		return $link;
		
	}
	
	public function generateNewLink(User $user): string
	{
		$uniqueHash = md5($user->name . $user->phone . $user->id . now());
		$uniqueLink = uniqid() . $uniqueHash;
		
		Link::create([
			'user_id' => $user->id,
			'unique_link' => $uniqueLink,
		]);
		
		return $uniqueLink;
	}
	
	
	public function destroyLink(User $user): mixed
	{
		return $user->links->first()->delete();
	}
	
	public function isActiveLink(User $user): bool
	{
		$link = $user->links->first();
		
		if (!$link || !$link->active) {
			return false;
		}
		$currentDate = Carbon::now();
		$expirationDate = Carbon::createFromFormat('Y-m-d H:i:s', $link->created_at)->addDays(7);
		
		if ($expirationDate->lt($currentDate)) {
			$link->update(['active' => false]);
			return false;
		}
		
		return true;
	}
	
	
	
}