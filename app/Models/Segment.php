<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'segment',
        'division_id'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'segment_id', 'id');
    }
}
