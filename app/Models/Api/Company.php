<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website'
    ];
    
    public function getLogoAttribute($value)
    {
        if(!is_null($value)) { 
            return asset('storage/'.$value);
        }
        return $value;
        
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
