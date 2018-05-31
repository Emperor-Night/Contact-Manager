<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TraitsHelpers\PhotoHelper;

class Contact extends Model
{
    use PhotoHelper;

    protected $fillable = ["name", "company", "email", "phone", "address", "photo", "group_id", "user_id"];

    public $storagePath = "/public/images/contacts/";
    public $photoPath = "/storage/images/contacts/";


    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }


    // Additional methods
    public function scopeOrder($query)
    {
        $query->orderBy("name", "asc");
    }

    public function scopeSearch($query)
    {
        $search = request("searchContacts");
        $cond = "%" . $search . "%";

        $query->where("name", "LIKE", $cond)
            ->orWhere("email", "LIKE", $cond)
            ->orWhere("company", "LIKE", $cond);
    }

    public function scopeFilter($query)
    {
        $query->order()->search();
    }

    public function scopeAddedRelations($query)
    {
        $query->with(["photo"]);
    }


}
