<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
	protected $fillable = ['user_id', 'win', 'random_number', 'amount'];
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}