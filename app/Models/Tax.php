<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'taxes';

    protected $fillable = [
        'percentage'
    ];

    public function report()
    {
        return $this->hasMany(Report::class, 'tax_id', 'id');
    }
}
