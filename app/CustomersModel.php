<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomersModel extends Model
{
    public function user() {
        return $this->hasOne('App\CompaniessModel', 'id', 'company_id');
    }
}
