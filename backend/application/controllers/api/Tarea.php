<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

require(APPPATH . 'libraries/REST_Controller.php');
class Tarea extends REST_Controller
{
    
  public function __construct()
  {
    parent::__construct();
  }

  public function index_get($id = null)
  {
    if (isset($id)) {
      $this->db->where('id_tarea',$id);
      $data = $this->db->get('tarea')->result();
      if (sizeof($data) == 0) {
      $data =['No encontrado'];
      }
    } else {
        $this->db->select('tarea.id_tarea, tarea.titulo, tarea.descripcion, tarea.fecha_entrega, tipo.nombre ');
        $this->db->from('tarea');
        $this->db->join('tipo','tarea.id_tipo_tarea=tipo.id_tipo_tarea');
        $data = $this->db->get()->result();
    }
    $this->response($data,REST_Controller::HTTP_OK);
  }

  public function index_post()
  {
    $datos = array(
      'titulo' =>$this->post('titulo'), 
      'descripcion' =>$this->post('descripcion'),
      'fecha_entrega' =>$this->post('fecha_entrega'),  
      'id_tipo_tarea' =>$this->post('id_tipo_tarea')       
    );
    $this->db->insert('tarea',$datos);
    $this->db->from('tarea');
    $this->db->order_by('id_tarea','DESC');
    $this->db->limit(1);
    $data = $this->db->get()->result();
    $this->response($data,REST_Controller::HTTP_CREATED);
  }

  public function index_put($id = null)
  {
    if (isset($id)) {
      $datos=$this->put();
      $this->db->where('id_tarea',$id);
      $this->db->update('tarea',$datos);
    }else{
      return $this->response('Contenido faltante',REST_Controller::HTTP_NO_CONTENT);
    }
    $this->response(['Actualizado'],REST_Controller::HTTP_ACCEPTED);
  }
  
  public function index_delete($id = null)
  {
    $this->db->where('id_tarea',$id);
    $this->db->delete('tarea');
    $this->response(['Eliminado'],REST_Controller::HTTP_OK);
  }
}
