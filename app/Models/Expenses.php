<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'description', 'date', 'user_id', 'value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
