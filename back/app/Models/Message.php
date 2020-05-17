<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use softDeletes;
    
    protected $fillable = [
        'title',
        'content',
        'link',
    ];
}
