<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class QuoteComment extends Model
{
    protected $fillable = ['subject', 'quote_id', 'user_id'];
    
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function isOwner()
    {
        if(Auth::guest())
            return false;

        return Auth::user()->id == $this->user->id;
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }
}
