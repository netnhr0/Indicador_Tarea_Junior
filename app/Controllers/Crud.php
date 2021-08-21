<?php

namespace App\Controllers;

use DateTime;

class Crud extends BaseController{
    protected $myArray = [];

    public function __construct()
    {   
        session_start();
        if (!isset($_SESSION['newsession'])) {
            $data = Home::api();
            $this->setArray($data->serie);
        }
    }

    public function setArray($data){
        $_SESSION["newsession"] = $data;
    }
    
    public function index(){
        $data = Home::api();
        asort($this->get());
        $array_data = [
            'codigo' => $data->codigo,
            'nombre' => $data->nombre,
            'unidad_medida' => $data->unidad_medida,
            'serie' => $this->get()
        ];

        return view('dato_historico', $array_data);
    }

    private function get(){
        return $_SESSION["newsession"];
    }

    public function getId($id){
        foreach ($_SESSION["newsession"] as $key => $value) {
            if ($id == $key) {
                $array = [
                    'fecha' => $value->fecha, 
                    'valor' => $value->valor
                ];
            }
        }
        return $array;
    }

    public function editar($id){
        $array = $this->getId($id);

        $fecha_array = new DateTime($array['fecha']);
        $fecha = $fecha_array->format('Y-m-d');

        $datos_a_enviar = [
            'id' => $id, 
            'fecha' => $fecha, 
            'valor' => $array['valor']
        ];

        return view('datos_uf\edit', $datos_a_enviar);
    }

    public function editarPost($id){
        $array_edit = [
            $id => (object)[
                'fecha' => $_POST['fecha'],
                'valor' => floatval($_POST['valor'])
            ]
        ];

        foreach ($this->get() as $key => $value) {
            if ($id == $key) {
                $nuevoArray = array_replace($this->get(), $array_edit);
            }
        }
        $this->setArray($nuevoArray);
        return redirect()->to(base_url().'/uf/dato_historico');
    }
    
    public function delete($id){
        unset($_SESSION['newsession'][$id]);
        return redirect()->to(base_url().'/uf/dato_historico');
    }

}
?>