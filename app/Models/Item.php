<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = "id";
    public $incrementing = false; // untuk menandakan bahwa primary key bukan incrementing integer
    protected $keyType = 'string'; // menetapkan tipe data primary key
    protected $fillable = [
        'company_id',
        'item_type_id',
        'code',
        'label',
        'item_group_id',
        'item_account_group_id',
        'item_unit_id',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    // Definisi relasi belongsTo untuk setiap foreign key
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    public function itemGroup()
    {
        return $this->belongsTo(ItemGroup::class, 'item_group_id');
    }

    public function itemAccountGroup()
    {
        return $this->belongsTo(ItemAccountGroup::class, 'item_account_group_id');
    }

    public function itemUnit()
    {
        return $this->belongsTo(ItemUnit::class, 'item_unit_id');
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
