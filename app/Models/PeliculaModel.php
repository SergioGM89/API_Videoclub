<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaModel extends Model{

    protected $table = 'peliculas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo', 'anyo', 'duracion'];

    //Obtenemos todas las peliculas
    public function getAll(){
        $query = $this->query("SELECT p.*, a.id_actor, act.nombre as nombre_actor, act.anyoNacimiento as anyoN_actor, act.pais as pais_actor, 
        d.id_director, dir.nombre as nombre_director, dir.anyoNacimiento as anyoN_director, dir.pais as pais_director FROM peliculas AS p 
        LEFT JOIN peliculas_actores AS a ON p.id=a.id_pelicula LEFT JOIN peliculas_directores AS d ON p.id=d.id_pelicula 
        LEFT JOIN actores AS act ON a.id_actor=act.id LEFT JOIN directores AS dir ON d.id_director=dir.id");
        return $query->getResult('array');
    }

    //Obtenemos una única pelicula
    public function get($id){
        $sql = "SELECT p.*, a.id_actor, act.nombre as nombre_actor, act.anyoNacimiento as anyoN_actor, act.pais as pais_actor, 
        d.id_director, dir.nombre as nombre_director, dir.anyoNacimiento as anyoN_director, dir.pais as pais_director FROM peliculas AS p 
        LEFT JOIN peliculas_actores AS a ON p.id=a.id_pelicula LEFT JOIN peliculas_directores AS d ON p.id=d.id_pelicula 
        LEFT JOIN actores AS act ON a.id_actor=act.id LEFT JOIN directores AS dir ON d.id_director=dir.id WHERE p.id=$id"; 
        $query = $this->query($sql, ['id' => $id]);
        return $query->getResult('array');
    }
}

?>