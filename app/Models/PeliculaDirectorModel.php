<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaDirectorModel extends Model{

    protected $table = 'peliculas_directores';
    protected $primaryKey = 'id_pelicula';
    protected $allowedFields = ['id_pelicula', 'id_director'];

    public function inserta($id_p, $id_d){
        $sql = "insert into peliculas_directores values(:id_pel:, :id_dir:)";
        $this->query($sql, ['id_pel' => $id_p, 'id_dir' => $id_d]);
    }
}

?>