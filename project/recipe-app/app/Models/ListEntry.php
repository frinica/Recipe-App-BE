<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListEntry extends Model
{
    use HasFactory;

    protected $table = 'listentries';
    protected $fillable = [
        'customlist_id',
        'recipe_id'
    ];

    public function customList()
    {
        return $this->belongsTo(CustomList::class);
    }
}
