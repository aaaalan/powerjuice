<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class User extends Model
{
    use HasFactory;

    protected $fillable = ['firstName', 'lastName', 'email', 'phone', 'sex', 'password','isAdmin', 'isVaccinated', 'ssn','vaccination_id'];

    public function vaccination(): BelongsTo
    {
        return $this->belongsTo(Vaccination::class);
    }


}
