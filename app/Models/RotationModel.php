<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotationModel extends Model
{
    use HasFactory;
    protected $table = 'rotation';
    protected $guarded = [];

    public function DataRuleRotation (){
        return $this->hasMany(RuleRotation::class, 'rotation_id');
    }
}
