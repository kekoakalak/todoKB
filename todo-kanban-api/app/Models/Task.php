<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id' // This links the task to a user
    ];

    // Optional: Define the inverse relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
