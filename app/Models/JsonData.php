<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JsonData extends Model
{
    use HasFactory;

    protected $fillable = ['list', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
