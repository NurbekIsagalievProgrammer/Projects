<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclerRequest extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'status',
        'recycler_id',
        'theme_id',
        'solution_id',
    ];
   
    public function recyclers()
    {
        return $this->belongsToMany(Recycler::class, 'recycler_requests', 'recycler_id', 'id');
    }

    public function themes()
    {
        return $this->belongsToMany(RecyclerTheme::class, 'recycler_requests', 'theme_id', 'id');
    }

    public function solutions()
    {
        return $this->belongsToMany(RecyclerSolution::class, 'recycler_requests', 'solution_id', 'id');
    }
}
