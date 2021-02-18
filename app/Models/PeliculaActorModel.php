<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaActorModel extends Model{

    protected $table = 'peliculas_actores';
    protected $allowedFields = ['id_pelicula', 'id_actor'];

    public function inserta($id_p, $id_a){
        $sql = "insert into peliculas_actores values(:id_pel:, :id_act:)";
        $this->query($sql, ['id_pel' => $id_p, 'id_act' => $id_a]);
    }
}


?>