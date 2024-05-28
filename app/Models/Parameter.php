<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'division_id',
        'category',
        'parameter',
        'weight',
        'description',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function score()
    {
        return $this->hasMany(Score::class, 'division_id');
    }
}
