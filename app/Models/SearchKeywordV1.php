<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchKeywordV1 extends Model
{
  protected $table = 'search_keywords_v1';
  protected $guarded = [];

  protected $casts = [
    // Laravel sẽ tự json_decode nếu là string JSON
    'related_keywords' => 'array',
  ];
  
}