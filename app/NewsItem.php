<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model {
	//

	protected $table = "news_items";

	public function user() {
		return $this->hasOne( 'App\User', 'id', 'user_id' );
	}

	public function comments() {
		// Relationshipui, galime nustatyti rikiavima prideje orderBy() pabaigoje
		return $this->hasMany( 'App\Comment', 'news_id', 'id' )->orderBy( 'created_at', 'DESC' );
	}

	public function categories() {

		return $this->belongsToMany(
			'App\Category',
			'news_categories',
			'news_id',
			'category_id'
		);
	}

	public function execerpt( $length = 20 ) {
		$result = $this->content;

		// istriname visus html tagus is teksto
		$result = strip_tags( $result );

		if ( strlen( $result ) > $length ) {
			// sutrumpiname string'a iki 50 simboliu
			$result = substr( $result, 0, $length );
			$result .= "...";
		}

		return $result;
	}

}
