<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentTaggable\Taggable;

class Design extends Model
{
    use Taggable;
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

    public function getImagesAttribute()
    {
        return [
            'thumbnail' => $this->getImagePath('thumbnail'),
            'large' => $this->getImagePath('large'),
            'original' => $this->getImagePath('original'),
        ];
    }

    protected function getImagePath($size) {
            return Storage::disk($this->disk)
                ->url("uploads/designs/{$size}/" . $this->image );
    }

}
