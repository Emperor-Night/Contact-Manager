<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $fillable = ["name", "size"];


    public function user()
    {
        return $this->hasOne(User::class);
    }


}
