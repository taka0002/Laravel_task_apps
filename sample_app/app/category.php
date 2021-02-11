<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public function task_app() {
        return $this->belongsTo('App\task_app', 'id', 'category_id');
    }
}
