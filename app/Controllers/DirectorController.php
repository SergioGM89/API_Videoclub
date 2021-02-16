<?php namespace App\Controllers;
use App\Models\DirectorModel;
use CodeIgniter\RESTful\ResourceController;

class DirectorController extends ResourceController{

    protected $modelName = "App\Models\DirectorModel";
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
        $directores = array();
        foreach($data as $row){
            $director = array(
                "id" => $row['id'],
                "nombre" => $row['nombre'],
                "anyoNacimiento" => $row['anyoNacimiento'],
                "pais" => $row['pais'],
                "links" => array(
                    array(
                        "rel" => "self",
                        "href" => $this->url("/DirectorController/".$row['id']),
                        "action" => "GET",
                        "types" => ["text/xml", "application/json"]
                    ),
                    array(
                        "rel" => "self",
                        "href" => $this->url("/DirectorController/".$row['id']),
                        "action" => "PUT",
                        "types" => ["application/x-www-form-urlencoded"]
                    ),
                    array(
                        "rel" => "self",
                        "href" => $this->url("/DirectorController/".$row['id']),
                        "action" => "DELETE",
                        "types" => []
                    )
                )//Cierro array de links              
            );//Cierro array de $director
            array_push($directores, $director);
        }
        return $directores;
    }

    ////////////////////////////////////////////////////
    ///////////////OPERACIONES//////////////////////////
    ////////////////////////////////////////////////////

    //Tipo GET: nos devuelve todos los datos o un único dato filtrado por id
    public function index(){
        $data = $this->model->getAll();
        $directores = $this->map($data);

        return $this->genericResponse($directores, null, 200);
    }

    public function show($id = null){
        $data = $this->model->get($id);
        $director = $this->map($data);

        return $this->genericResponse($director, null, 200);
    }

    //Tipo POST: crea un nuevo recurso, en este caso un nuvo director
    public function create(){
        $directores = new DirectorModel();

        if($this->validate('directores')){
            
            $id = $directores->insert([
                'nombre' => $this->request->getPost('nombre'),
                'anyoNacimiento' => $this->request->getPost('anyoNacimiento'),
                'pais' => $this->request->getPost('pais')
            ]);

            //Internamente $this->model hace referencia a $modelName = 'App\Models\DirectorModel';
            return $this->genericResponse($this->model->find($id), null, 200);
        }

        //Hemos creado validaciones en el archivo de configuración Validation.php
        $validation = \Config\Services::validation();
        //Si no pasa la validación devolvemos error 500
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }

    //Tipo PUT: actualización de un recurso
    public function update($id = null){
        $directores = new DirectorModel();
        //Al ser un método de tipo PUT o PATCH debemos recoger los datos usando el método getRawInput
        $data = $this->request->getRawInput();

        if($this->validate('directores')){

            if(!$directores->get($id)){
                return $this->genericResponse(null, array("id" => "El director no existe"), 500);
            }

            $directores->update($id, [
                "nombre" => $data['nombre'],
                "anyoNacimiento" => $data['anyoNacimiento'],
                "pais" => $data['pais']
            ]);

            return $this->genericResponse($this->model->find($id), null, 200);
        }
    }

    //Tipo DELETE: borrado de un recurso
    public function delete($id = null){
        $directores = new DirectorModel();
        $directores->delete($id);

        return $this->genericResponse("Director eliminado", null, 200);
    }
}


?>