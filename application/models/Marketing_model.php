<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marketing_model extends CI_Model
{
    public function byManager($id_manager)
    {
        return $this->db->get_where('marketing', ['id_manager' => $id_manager])->result_array();
    }
}
