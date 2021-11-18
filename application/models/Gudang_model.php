<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang_model extends CI_Model
{
    public function getAll()
    {
        return $this->db->get('gudang')->result_array();
    }
}
