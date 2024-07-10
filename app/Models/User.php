<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = 'string'; // menetapkan tipe data primary key
    protected $fillable = [
        'name',
        'username',
        'password',
        'company_id',
    ];
    // method untuk membuat uuid secara otomatis saat data baru dibuat
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
        static::saving(function ($model) {
            if ($model->isDirty('password')) {
                $model->password = Hash::make($model->password);
            }
        });
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    // Memeriksa status is_admin
    public static function checkIsActive($username){
        $user = self::where("username", $username)->where("is_active", true)->first();
        return $user ? true : false;
    }
}
