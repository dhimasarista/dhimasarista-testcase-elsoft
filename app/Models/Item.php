<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Item extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'item_type',
        'code',
        'label',
        'item_group',
        'item_account_group',
        'item_unit',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the company that owns the item.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the item group associated with the item.
     */
    public function group()
    {
        // return $this->belongsTo(ItemGroup::class, 'item_group');
    }

    /**
     * Get the item account group associated with the item.
     */
    public function accountGroup()
    {
        // return $this->belongsTo(ItemAccountGroup::class, 'item_account_group');
    }

    /**
     * Get the item unit associated with the item.
     */
    public function unit()
    {
        // return $this->belongsTo(ItemUnit::class, 'item_unit');
    }

    // method untuk membuat uuid secara otomatis saat data baru dibuat
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
