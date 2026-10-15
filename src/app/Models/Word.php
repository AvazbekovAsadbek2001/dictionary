<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = "words";

    protected $fillable = [
        'section_id',
        'name_uz',
        'name_ru'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
