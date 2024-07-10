<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Currency extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    public $incrementing = false; // untuk menandakan bahwa primary key bukan incrementing integer
    protected $keyType = 'string'; // menetapkan tipe data primary key
    protected $fillable = [
        'name',
        'code'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
