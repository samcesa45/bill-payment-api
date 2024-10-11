<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Model
{
   use HasUuids, HasApiTokens, HasFactory;
   public $table ="transactions";
   protected $fillable = ['user_id','amount','status'];

   public function user()
   {
    return $this->belongsTo(User::class);
   }
}
