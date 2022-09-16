<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Album extends Model implements HasMedia
{
    use  InteractsWithMedia;
    public $fillable = ['name' , 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeWithAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public static function boot() {

        parent::boot();

        self::creating(function ($model) {

            $model->user_id = auth()->user()->id;

        });

        self::updating(function ($model) {

            $model->user_id = auth()->user()->id;

        });

    }
}
