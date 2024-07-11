<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = "id";
    public $incrementing = false; // untuk menandakan bahwa primary key bukan incrementing integer
    protected $keyType = 'string'; // menetapkan tipe data primary key
    protected $fillable = [
        "company_id",
        "code",
        "account_id",
        "note",
        "status_id"
    ];
    protected $dates = ["deleted_at"];
    /**
     * Get the company that owns the transaction.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the account associated with the transaction.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->status_id = 1;
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
