<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'user_id',
        'status'
    ];

    public function user() {  
        return $this->belongsTo(User::class, 'user_id');  
    }  

    public function students() {  
        return $this->belongsToMany(User::class);  
    }  
}
