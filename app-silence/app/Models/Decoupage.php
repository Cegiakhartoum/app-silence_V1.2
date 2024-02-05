<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decoupage extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'action_id',
        'sequence_id',
        'plan',
        'lieu',
        'description',
        'echelle',
        'angle',
        'sur',
        'mouvement',
        'audio',
        'raccord',
        'durée',
        'decords',
        'jours'
         

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
