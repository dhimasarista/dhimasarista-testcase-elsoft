<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = "id";
    public $incrementing = false; // untuk menandakan bahwa primary key bukan incrementing integer
    protected $keyType = 'string'; // menetapkan tipe data primary key
    protected $fillable = [
        'transaction_id',
        'item_id',
        'quantity',
        'item_unit_id',
        'note'
    ];

    protected $dates = ["deleted_at"];

    /**
     * Get the transaction that owns the transaction detail.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function itemUnit(){
        return $this->belongsTo(ItemUnit::class);
    }

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
