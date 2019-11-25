<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Sukurti relationship su user modeliu
	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	// sukurti relationship su newsItem modeliu
	public function newsItem() {
		return $this->hasOne('App\NewsItem', 'id', 'news_id');
	}
}
