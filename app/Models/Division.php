<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'division'
    ];

    public function segment()
    {
        return $this->hasMany(Segment::class, 'division_id', 'id');
    }

    public function division()
    {
        return $this->hasMany(Division::class, 'division_id', 'id');
    }
}
