<?php

namespace App\Services;

use App\Models\Result;

class GameService
{
	public function playGame($user): array
	{
		$randomNumber = rand(1,1000);
		
		$result = ($randomNumber % 2 === 0) ? 'WIN' : 'LOSE';
		
		if($result === 'WIN') {
			if ($randomNumber > 900) {
				$amount = $randomNumber * 0.7;
			} elseif ($randomNumber > 600) {
				$amount = $randomNumber * 0.5;
			} elseif ($randomNumber > 300) {
				$amount = $randomNumber * 0.3;
			} else {
				$amount = $randomNumber * 0.1;
			}
		} else {
			$amount = 0;
		}
		
		Result::create([
			'user_id' => $user->id,
			'win' => ($result === 'WIN'),
			'random_number' => $randomNumber,
			'amount' => $amount,
		]);
		
		return [
			'randomNumber'	=> $randomNumber,
			'result' => $result,
			'winAmount' => $amount,
		];
		
	}
	
	public function history($user)
	{
		return Result::where('user_id', $user->id)
			->orderBy('created_at', 'desc')
			->take(3)
			->get();
	
	}
	
	
	
}