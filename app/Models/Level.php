<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'level'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
