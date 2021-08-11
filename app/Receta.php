<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{

    // Campos que se agregaran
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes','imagen','categoria_id'
    ];
    
     
    //Obtiene la categoria de la receta via FK
    public function categoria(){

            return $this->belongsTo(CategoriaReceta::class);
    }

    // Obtiene la informacion del usuario via FK
    public function autor(){

        return $this->belongsTo(User::class, 'user_id'); //user_id FK de la tabla USers
    }

    // liKES WQUE HA RECIBIDO UNA RECETA
    public function likes(){

        return $this->belongsToMany(User::class,'likes_receta');
    }
}

