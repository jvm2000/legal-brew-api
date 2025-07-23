<?php

namespace App\Models;

use App\Models\Service;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'method',
        'amount',
        'currency',
        'services',
    ];

    protected $casts = [
        'services' => 'array',
    ];
    
    public function services() {
        return $this->hasMany(Service::class);
    }
}
