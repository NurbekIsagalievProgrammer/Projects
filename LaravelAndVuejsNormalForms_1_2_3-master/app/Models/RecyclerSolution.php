<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclerSolution extends Model
{
    use HasFactory;
    protected $fillable = ['theme_id','title'];

    public function theme()
    {
        return $this->belongsTo(RecyclerTheme::class, 'theme_id');
    }
}
