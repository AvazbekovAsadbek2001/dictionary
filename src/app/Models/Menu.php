<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menus";

    protected $fillable = [
        "name_uz",
        "name_ru"
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }
}
