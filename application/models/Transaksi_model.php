<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{
    var $table = 'view_trx_mng';
    var $column_order = ['tanggal', 'nama_gudang', 'marketing', 'no_hp', 'konsumen', 'telp_konsumen', 'alamat_konsumen', 'nama_obat', 'expedisi', 'no_resi'];
    var $filter;
    var $user;

    public function __construct()
    {
        parent::__construct();
        switch (date('l')) {
            case 'Monday':
                $this->filter = [
                    'start' => date('Y-m-d', strtotime(date('Y-m-d') . ' -2 day')) . ' 15:15:00',
                    'end' => date('Y-m-d', strtotime(date('Y-m-d'))) . ' 15:15:00',
                ];
                break;
            default:
                $this->filter = [
                    'start' => date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day')) . ' 15:15:00',
                    'end' => date('Y-m-d', strtotime(date('Y-m-d'))) . ' 15:15:00',
                ];
                break;
        }
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setFilter($data)
    {
        $this->filter = $data;
    }

    private function _get_data_query()
    {
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->where('tanggal >=', $this->filter['start']);
        $this->db->where('tanggal <=', $this->filter['end']);
        $this->db->group_end();

        if ($this->user['role_id'] != 1) {
            $this->db->where('id_manager', $this->user['id']);
        }


        if (isset($_POST['search']['value'])) {
            $this->db->group_start();
            $this->db->like('tanggal', $_POST['search']['value']);
            $this->db->or_like('nama_gudang', $_POST['search']['value']);
            $this->db->or_like('marketing', $_POST['search']['value']);
            $this->db->or_like('no_hp', $_POST['search']['value']);
            $this->db->or_like('konsumen', $_POST['search']['value']);
            $this->db->or_like('telp_konsumen', $_POST['search']['value']);
            $this->db->or_like('alamat_konsumen', $_POST['search']['value']);
            $this->db->or_like('nama_obat', $_POST['search']['value']);
            $this->db->or_like('expedisi', $_POST['search']['value']);
            $this->db->or_like('no_resi', $_POST['search']['value']);
            $this->db->group_end();
        }

        if (isset($_POST['order'])) {
            $this->db->order_by(
                $this->column_order[$_POST['order']['0']['column']],
                $_POST['order']['0']['dir']
            );
        } else {
            $this->db->order_by('tanggal', 'ASC');
        }
    }

    public function get_data_table()
    {
        $this->_get_data_query();
        if ($_POST['length'] > 1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
