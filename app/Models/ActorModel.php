<?php

namespace App\Models;

use CodeIgniter\Model;

class ActorModel extends Model{

    protected $table = 'actores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'anyoNacimiento', 'pais'];

    //Obtenemos todos los actores
    public function getAll(){
        $query = $this->query("SELECT * FROM actores");
        return $query->getResult('array');
    }

    //Obtenemos un único actor
    public function get($id){
        $sql = "SELECT * FROM actores WHERE id=$id"; 
        $query = $this->query($sql, ['id' => $id]);
        return $query->getResult('array');
    }
}

?>