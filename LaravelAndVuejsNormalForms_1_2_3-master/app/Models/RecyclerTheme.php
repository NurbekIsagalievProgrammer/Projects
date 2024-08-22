<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclerTheme extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description'];

    public function solutions()
    {
        return $this->hasMany(RecyclerSolution::class);
    }
}
