<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
	protected $fillable = ['user_id', 'unique_link', 'active'];
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}