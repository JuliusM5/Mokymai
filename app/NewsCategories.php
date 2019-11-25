<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategories extends Model
{
    // SUKURTI relationship su category modeliu
	public function category() {
		return $this->hasOne('App\Category', 'id', 'category_id');
	}


	// Sukurti relationship su newsItem modeliu
	public function newsItem() {
		return $this->hasOne('App\NewsItem', 'id', 'news_id');
	}


}
