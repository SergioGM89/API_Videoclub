<?php

namespace App\Models;

use CodeIgniter\Model;

class DirectorModel extends Model{

    protected $table = 'directores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'anyoNacimiento', 'pais'];

    //Obtenemos todos los directores
    public function getAll(){
        $query = $this->query("SELECT * FROM directores");
        return $query->getResult('array');
    }

    //Obtenemos un único director
    public function get($id){
        $sql = "SELECT * FROM directores WHERE id=$id"; 
        $query = $this->query($sql, ['id' => $id]);
        return $query->getResult('array');
    }
}

?>