<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Trainor extends Authenticatable
{
    use Notifiable;

    protected $table = 'trainors';
    protected $fillable = ['batch_id', 'name', 'email', 'phone', 'expertise', 'password', 'status'];
    protected $hidden = ['password', 'remember_token'];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
