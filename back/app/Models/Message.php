<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Message extends Model
{
  protected $fillable = [
      'title',
      'content'
  ];
}
