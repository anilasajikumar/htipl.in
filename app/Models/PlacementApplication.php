<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PlacementApplication extends Model
{
 

    protected $fillable = [
        'placement_id',
        'name',
        'experience',
        'qualification',
        'resume',
        'email',
    ];
    
    
    public function placement()
    {
        return $this->belongsTo(Placement::class, 'placement_id');
    }

}
