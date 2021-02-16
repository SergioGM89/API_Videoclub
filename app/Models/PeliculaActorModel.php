<?php

namespace App\Models;

use CodeIgniter\Model;

class JugadorModel extends Model{

    protected $table = 'jugadores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['Nombre', 'ID_equipo', 'Anyo_Inicio', 'Anyo_Fin', 'Altura', 'Peso', 'Nacimiento', 'Procedencia'];

    //Obtenemos todos los jugadores
    public function getAll(){
        $query = $this->query("SELECT j.*, e.Ciudad, e.Conferencia, e.Division, e.Nombre AS Nombre_equipo FROM jugadores AS j INNER JOIN equipos AS e ON j.ID_equipo=e.id");
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