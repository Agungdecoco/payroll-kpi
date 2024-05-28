<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tunjangan',
        'tax_id',
        'bpjs_tk',
        'bpjs_jp',
        'bpjs_kes',
        'skor_kedisiplinan',
        'skor_sikap',
        'skor_kesehatan',
        'deduction_total',
        'salary_per_hour',
        'salary_total',
        'absent_total',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
