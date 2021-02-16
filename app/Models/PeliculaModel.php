<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaModel extends Model{

    protected $table = 'peliculas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo', 'anyo', 'duracion'];

    //Obtenemos todos los jugadores
    public function getAll(){
        $query = $this->query("SELECT p.*, d.nombre, a.nombre FROM peliculas AS p INNER JOIN directores AS d, actores AS a ON j.ID_equipo=e.id");
        return $query->getResult('array');
    }

    //Obtenemos un único jugador
    public function get($id){
        $sql = "SELECT j.*, e.Ciudad, e.Conferencia, e.Division, e.Nombre AS Nombre_equipo FROM jugadores AS j INNER JOIN equipos AS e ON j.ID_equipo=e.id WHERE j.id=$id"; 
        $query = $this->query($sql, ['id' => $id]);
        return $query->getResult('array');
    }
}

?>