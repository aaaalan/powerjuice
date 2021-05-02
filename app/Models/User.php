<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model  implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['firstName', 'lastName', 'email', 'phone', 'sex', 'password','isAdmin', 'isVaccinated', 'ssn','vaccination_id'];

    public function vaccination(): BelongsTo
    {
        return $this->belongsTo(Vaccination::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['user'=>['id'=>$this->id]];
    }
}
