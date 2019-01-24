<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id', 'likeable_type', 'likeable_id'
    ];

    public $timestamp = false;

    public function likeable()
    {
        return $this->MorphTo();
    }
}
