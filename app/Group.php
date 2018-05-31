<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = ["name", "user_id"];


    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Additional methods
    public function scopeOrder($query)
    {
        $query->orderBy("name", "asc");
    }

    public function scopeSearch($query)
    {
        $search = request("searchGroups");
        $cond = "%" . $search . "%";

        $query->where("name", "LIKE", $cond);
    }

    public function scopeFilter($query)
    {
        $query->order()->search();
    }


}
