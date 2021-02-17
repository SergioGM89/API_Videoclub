<?php namespace App\Controllers;
use App\Models\PeliculaModel;
use App\Models\ActorModel;
use App\Models\DirectorModel;
use CodeIgniter\RESTful\ResourceController;

class PeliculaController extends ResourceController{

    protected $modelName = "App\Models\PeliculaModel";
    protected $format = 'json';

    private function genericResponse($data, $msj, $code){
        if($code == 200){
            return $this->respond(array(
                "data" => $data, 
                "code" => $code
            ));
        }else{
            return $this->respond(array(
                "msj" => $msj, 
                "code" => $code
            ));
        }

    }

    private function url($segmento){
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }else{
            $protocol = "http";
        }
        return $protocol."://".$_SERVER['HTTP_HOST'].$segmento;

    }

    private function map($data){
        $peliculas = array();       
        foreach($data as $row){
            $peli_actualizada = false;
            if(count($peliculas)>0){//Accedemos al IF si ya hemos guardado los datos de alguna película
                for($i=0; $i<(count($peliculas)); $i++){
                    if($peliculas[$i]['id'] == $row['id']){//Y si la película actual coincide con otro, guardamos el nuevo actor
                        $actor = array(
                            "id_actor" => $row['id_actor'],
                            "nombre_actor" => $row['nombre_actor'],
                            "anyoN_actor" => $row['anyoN_actor'],
                            "pais_actor" => $row['pais_actor'],
                            "links_actor" => array(
                                array(
                                    "rel" => "actores",
                                    "href" => $this->url("/ActorController/".$row['id_actor']),
                                    "action" => "GET",
                                    "types" => ["text/xml", "application/json"]
                                ),
                                array(
                                    "rel" => "actores",
                                    "href" => $this->url("/ActorController/".$row['id_actor']),
                                    "action" => "PUT",
                                    "types" => ["application/x-www-form-urlencoded"]
                                ),
                                array(
                                    "rel" => "actores",
                                    "href" => $this->url("/ActorController/".$row['id_actor']),
                                    "action" => "DELETE",
                                    "types" => []
                                )
                            )//Cierro array de links_actor
                        );
                        array_push($peliculas[$i]['actores'], $actor);//Añadimos el actor a la película correspondiente
                        $peli_actualizada = true;
                    }
                }
            }
            if($peli_actualizada){
                continue;
            }
            if($row['id_actor'] == null){
                $pelicula = array(
                    "id" => $row['id'],
                    "titulo" => $row['titulo'],
                    "anyo" => $row['anyo'],
                    "duracion" => $row['duracion'],
                    "directores" => array(
                        "id_director" => $row['id_director'],
                        "nombre_director" => $row['nombre_director'],
                        "anyoN_director" => $row['anyoN_director'],
                        "pais_director" => $row['pais_director'],
                        "links_director" => array(
                            array(
                                "rel" => "directores",
                                "href" => $this->url("/DirectorController/".$row['id_director']),
                                "action" => "GET",
                                "types" => ["text/xml", "application/json"]
                            ),
                            array(
                                "rel" => "directores",
                                "href" => $this->url("/DirectorController/".$row['id_director']),
                                "action" => "PUT",
                                "types" => ["application/x-www-form-urlencoded"]
                            ),
                            array(
                                "rel" => "directores",
                                "href" => $this->url("/DirectorController/".$row['id_director']),
                                "action" => "DELETE",
                                "types" => []
                            )
                        )//Cierro array de links_director
                    ),
                    "links" => array(
                        array(
                            "rel" => "self",
                            "href" => $this->url("/PeliculaController/".$row['id']),
                            "action" => "GET",
                            "types" => ["text/xml", "application/json"]
                        ),
                        array(
                            "rel" => "self",
                            "href" => $this->url("/PeliculaController/".$row['id']),
                            "action" => "PUT",
                            "types" => ["application/x-www-form-urlencoded"]
                        ),
                        array(
                            "rel" => "self",
                            "href" => $this->url("/PeliculaController/".$row['id']),
                            "action" => "DELETE",
                            "types" => []
                        )
                    )//Cierro array de links              
                );//Cierro array de $pelicula
                array_push($peliculas, $pelicula);
            }else{
                $pelicula = array(
                    "id" => $row['id'],
                    "titulo" => $row['titulo'],
                    "anyo" => $row['anyo'],
                    "duracion" => $row['duracion'],
                    "actores" => array (array(
                        "id_actor" => $row['id_actor'],
                        "nombre_actor" => $row['nombre_actor'],
                        "anyoN_actor" => $row['anyoN_actor'],
                        "pais_actor" => $row['pais_actor'],
                        "links_actor" => array(
                            array(
                                "rel" => "actores",
                                "href" => $this->url("/ActorController/".$row['id_actor']),
                                "action" => "GET",
                                "types" => ["text/xml", "application/json"]
                            ),
                            array(
                                "rel" => "actores",
                                "href" => $this->url("/ActorController/".$row['id_actor']),
                                "action" => "PUT",
                                "types" => ["application/x-www-form-urlencoded"]
                            ),
                            array(
                                "rel" => "actores",
                                "href" => $this->url("/ActorController/".$row['id_actor']),
                                "action" => "DELETE",
                                "types" => []
                            )
                        )//Cierro array de links_actor
                    ),),
                    "director" => array(
                        "id_director" => $row['id_director'],
                        "nombre_director" => $row['nombre_director'],
                        "anyoN_director" => $row['anyoN_director'],
                        "pais_director" => $row['pais_director'],
                        "links_director" => array(
                            array(
                                "rel" => "directores",
                                "href" => $this->url("/DirectorController/".$row['id_director']),
                                "action" => "GET",
                                "types" => ["text/xml", "application/json"]
                            ),
                            array(
                                "rel" => "directores",
                                "href" => $this->url("/DirectorController/".$row['id_director']),
                                "action" => "PUT",
                                "types" => ["application/x-www-form-urlencoded"]
                            ),
                            array(
                                "rel" => "directores",
                                "href" => $this->url("/DirectorController/".$row['id_director']),
                                "action" => "DELETE",
                                "types" => []
                            )
                        )//Cierro array de links_director
                    ),
                    "links" => array(
                        array(
                            "rel" => "self",
                            "href" => $this->url("/PeliculaController/".$row['id']),
                            "action" => "GET",
                            "types" => ["text/xml", "application/json"]
                        ),
                        array(
                            "rel" => "self",
                            "href" => $this->url("/PeliculaController/".$row['id']),
                            "action" => "PUT",
                            "types" => ["application/x-www-form-urlencoded"]
                        ),
                        array(
                            "rel" => "self",
                            "href" => $this->url("/PeliculaController/".$row['id']),
                            "action" => "DELETE",
                            "types" => []
                        )
                    )//Cierro array de links              
                );//Cierro array de $pelicula
            array_push($peliculas, $pelicula);
            }
        }
        return $peliculas;
    }

    ////////////////////////////////////////////////////
    ///////////////OPERACIONES//////////////////////////
    ////////////////////////////////////////////////////

    //Tipo GET: nos devuelve todos los datos o un único dato filtrado por id
    public function index(){
        $data = $this->model->getAll();
        $peliculas = $this->map($data);

        return $this->genericResponse($peliculas, null, 200);
    }

    public function show($id = null){
        $data = $this->model->get($id);
        $pelicula = $this->map($data);

        return $this->genericResponse($pelicula, null, 200);
    }

    //Tipo POST: crea un nuevo recurso, en este caso una nueva pelicula
    public function create(){
        $peliculas = new PeliculaModel();
        $actores = new ActorModel();
        $directores = new DirectorModel();
        $peliculas_act = new PeliculaActorModel();
        $peliculas_dir = new PeliculaDirectorModel();

        //Validamos la película
        //if($this->validate('peliculas')){
        if(true){
            //Comprobamos el director
            if(!$this->request->getPost('id_director')){
                return $this->genericResponse(null, array("id_director" => "No se ha pasado el id del director por parámetro."), 500);
            }
            if(!$directores->get($this->request->getPost('id_director'))){
                return $this->genericResponse(null, array("id_director" => "El director no existe."), 500);
            }
            //Comprobamos los actores
            if($this->request->getPost('numActores') > 0){
                for($i=0; $i<($this->request->getPost('numActores')); $i++){
                    if(!$this->request->getPost([actores][$i])){
                        return $this->genericResponse(null, array("[actores][$i]" => "No se ha pasado el id del actor por parámetro."), 500);
                    }
                    if(!$actores->get($this->request->getPost([actores][$i]))){
                        return $this->genericResponse(null, array("[actores][$i]" => "El actor no existe."), 500);
                    }
                }
                for($i=0; $i<($this->request->getPost('numActores')); $i++){
                    $id_actor = $peliculas_act->insert([
                        'id_pelicula' => $this->request->getPost('titulo'),
                        'id_actor' => $this->request->getPost([actores][$i])
                    ]);
            
            $id = $peliculas->insert([
                'titulo' => $this->request->getPost('titulo'),
                'anyo' => $this->request->getPost('anyo'),
                'duracion' => $this->request->getPost('duracion')
            ]);

            //Internamente $this->model hace referencia a $modelName = 'App\Models\PeliculaModel';
            return $this->genericResponse($this->model->find($id), null, 200);
        }

        //Hemos creado validaciones en el archivo de configuración Validation.php
        $validation = \Config\Services::validation();
        //Si no pasa la validación devolvemos error 500
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }

    //Tipo PUT: actualización de un recurso
    public function update($id = null){
        $peliculas = new PeliculaModel();
        //$equipos = new EquipoModel();
        //Al ser un método de tipo PUT o PATCH debemos recoger los datos usando el método getRawInput
        $data = $this->request->getRawInput();

        //if($this->validate('peliculas')){
        if(true){
            if(!$data['ID_equipo']){
                return $this->genericResponse(null, array("ID_equipo" => "No se ha pasado el id del equipo por parámetro"), 500);
            }

            if(!$peliculas->get($id)){
                return $this->genericResponse(null, array("id" => "La pelicula no existe"), 500);
            }

            /*if(!$equipos->get($data['ID_equipo'])){
                return $this->genericResponse(null, array("ID_equipo" => "El equipo no existe"), 500);
            }*/

            $peliculas->update($id, [
                "Nombre" => $data['Nombre'],
                "Anyo_Inicio" => $data['Anyo_Inicio'],
                "Anyo_Fin" => $data['Anyo_Fin'],
                "Posicion" => $data['Posicion'],
                "Altura" => $data['Altura'],
                "Peso" => $data['Peso'],
                "Nacimiento" => $data['Nacimiento'],
                "Procedencia" => $data['Procedencia']
            ]);

            return $this->genericResponse($this->model->find($id), null, 200);
        }
    }

    //Tipo DELETE: borrado de un recurso
    public function delete($id = null){
        $peliculas = new PeliculaModel();
        $peliculas->delete($id);

        return $this->genericResponse("Pelicula eliminada", null, 200);
    }
}


?>