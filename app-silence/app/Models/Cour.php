<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cour extends Model{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'emplacement_maquette',
        'video',
        'doc_recap',
        'fiche_recap_des_chapitres',
        'chapitre_par_ecrit',
        'tous_les_chapitres_par_ecrit',
        'integration',
        'commentaire',
        'action_message',
        'chapitre_id',
        'boite_idees',
        'video_steps',
        'to_do_list',
        'exemple',
        'doc_a_completer',
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