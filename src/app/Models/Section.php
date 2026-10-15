<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = "sections";

    protected $fillable = [
        'menu_id',
        'name_uz',
        'name_ru'
    ];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function word(){
        return $this->belongsTo(Word::class);
    }
}
