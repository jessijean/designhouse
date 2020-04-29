<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'image',
        'description',
        'slug',
        'close_to_comment',
        'is_live',
        'upload_success',
        'disk',
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }
}
