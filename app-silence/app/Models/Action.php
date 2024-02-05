<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'owner_type',
        'projet_action_id',
        'titre_oeuvre',
        'thematique',
        'pitch',
        'situtation_initiale',
        'element_pertubateur',
        'peripeties',
        'element_resolution',
        'situation_finale',
        'synopsis',
        'titre_film',
        'scenario',
        'traitement',
        'decoupage_id'
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
