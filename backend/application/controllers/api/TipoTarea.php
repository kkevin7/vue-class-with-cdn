<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

require(APPPATH . 'libraries/REST_Controller.php');
class TipoTarea extends REST_Controller
{
    
  public function __construct()
  {
    parent::__construct();
  }

  public function index_get($id = null)
  {
    if (isset($id)) {
      $this->db->where('id_tipo_tarea',$id);
      $data = $this->db->get('tipo')->result();
      if (sizeof($data) == 0) {
      $data =['No encontrado'];
      }
    } else {
      $data = $this->db->get('tipo')->result();
    }
    $this->response($data,REST_Controller::HTTP_OK);
  }

  public function index_post()
  {
    $datos = array(
      'nombre' =>$this->post('nombre'), 
      'descripcion' =>$this->post('descripcion'),      
    );
    $this->db->insert('tipo',$datos);
    $this->db->from('tipo');
    $this->db->order_by('id_tipo_tarea','DESC');
    $this->db->limit(1);
    $data = $this->db->get()->result();
    $this->response($data,REST_Controller::HTTP_CREATED);
  }

  public function index_put($id=null)
  {
    if (isset($id)) {
      $datos=$this->put();
      $this->db->where('id_tipo_tarea',$id);
      $this->db->update('tipo',$datos);
    }else{
      return $this->response('Contenido faltante',REST_Controller::HTTP_NO_CONTENT);
    }
    $this->response(['Actualizado'],REST_Controller::HTTP_ACCEPTED);
  }
  
  public function index_delete($id = null)
  {
    $this->db->where('id_tipo_tarea',$id);
    $this->db->delete('tipo');
    $this->response(['Eliminado'],REST_Controller::HTTP_OK);
  }
}
