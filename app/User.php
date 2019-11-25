<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function news($orderBy = 'title') {
    	return $this->hasMany('App\NewsItem', 'user_id', 'id')
			->orderBy($orderBy);
	}

	// aprasyti relationship su comment modeliu
	public function comments() {
    	return $this->hasMany('App\Comment', 'user_id', 'id');
	}

	public function fullName() {
    	return $this->email . " " . $this->name;
	}

	public function longNews() {
    	$count = 0;
    	foreach ($this->news as $newsItem) {
    		if(strlen($newsItem->content) > 10) {
    			$count++;
			}
		}

		return $count;
	}

	public function totalCharacters() {
    	$total = 0;

    	foreach($this->news as $newsItem) {
    		$total += strlen($newsItem->content);
    		$total += strlen($newsItem->title);
		}

		return $total;
	}

}
