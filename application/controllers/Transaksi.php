<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Transaksi extends CI_Controller
{
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Marketing_model', 'mrkt');
        $this->load->model('Gudang_model', 'gudang');
        $this->load->model('Transaksi_model', 'transaksi');
        $session = $this->session->userdata('user');
        $this->user = $this->db->get_where('user', ['email' => $session['email']])->row_array();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'nama' => $this->user['nama'],
            'transaksi' => $this->db->get_where('view_trx_mng', [
                'id_manager' => $this->user['id']
            ])->result_array(),
        ];

        template_view('transaksi/index', $data);
    }

    public function input()
    {
        $validasi = [
            [
                'field' => 'id_marketing',
                'label' => 'Nama Marketing',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Nama Marketing wajib diisi',
                ),
            ],
            [
                'field' => 'konsumen',
                'label' => 'Nama Konsumen',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Nama Konsumen wajib diisi',
                ),
            ],
            [
                'field' => 'telp_konsumen',
                'label' => 'No HP',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'No HP wajib diisi',
                ),
            ],
            [
                'field' => 'alamat_konsumen',
                'label' => 'Alamat',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Alamat wajib diisi',
                ),
            ],
            [
                'field' => 'alamat_konsumen',
                'label' => 'Alamat',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Alamat wajib diisi',
                ),
            ],
            [
                'field' => 'gudang',
                'label' => 'Gudang',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Gudang wajib diisi',
                ),
            ],
            [
                'field' => 'nama_obat',
                'label' => 'Nama Obat',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Nama Obat wajib diisi',
                ),
            ],
            [
                'field' => 'expedisi',
                'label' => 'Expedisi',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Expedisi wajib diisi',
                ),
            ],
            [
                'field' => 'no_resi',
                'label' => 'No Resi',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'No Resi wajib diisi',
                ),
            ],
        ];

        $this->form_validation->set_rules($validasi);

        if ($this->form_validation->run()) {
            $data = [
                'id_gudang' => $this->input->post('gudang', true),
                'id_marketing' => $this->input->post('id_marketing', true),
                'tanggal' => date('Y-m-d H:i:s'),
                'konsumen' => $this->input->post('konsumen', true),
                'telp_konsumen' => $this->input->post('telp_konsumen', true),
                'alamat_konsumen' => $this->input->post('alamat_konsumen', true),
                'nama_obat' => $this->input->post('nama_obat', true),
                'expedisi' => $this->input->post('expedisi', true),
                'no_resi' => $this->input->post('no_resi', true),
                'catatan' => $this->input->post('catatan', true),
            ];

            $this->db->insert('transaksi', $data);

            notify('success', 'Data berhasil tersimpan, <a href="' . base_url('transaksi/detail/' . $this->db->insert_id()) . '">tampilkan?</a>');
            redirect(base_url('transaksi/input'));
        } else {
            $date = date('Y-m-d');
            $data = [
                'title' => 'Input Transaksi',
                'css' => ['https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css'],
                'marketing' => $this->mrkt->byManager($this->user['id']),
                'gudang' => $this->gudang->getAll(),
                'nama' => $this->user['nama'],
            ];

            template_view('transaksi/input', $data);
        }
    }

    public function detail($id)
    {
        $data = [
            'nama' => $this->user['nama'],
            'data' => $this->db->get_where('view_trx_mng', [
                'id' => $id
            ])->row_array(),
        ];

        template_view('transaksi/detail', $data);
    }

    public function admin()
    {
        $data = [
            'nama' => $this->user['nama'],
            'title' => 'Data Transaksi',
            'css' => [
                base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'),
                base_url('assets/css/buttons.dataTables.min.css'),
                base_url('assets/css/style.css'),
                'https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css'
            ],
            'js' => [
                base_url('assets/vendor/datatables/jquery-3.5.1.js'),
                base_url('assets/vendor/datatables/jquery.dataTables.min.js'),
                base_url('assets/vendor/datatables/dataTables.buttons.min.js'),
                base_url('assets/vendor/datatables/jszip.min.js'),
                base_url('assets/vendor/datatables/pdfmake.min.js'),
                base_url('assets/vendor/datatables/vfs_fonts.js'),
                base_url('assets/vendor/datatables/buttons.html5.min.js'),
                base_url('assets/vendor/datatables/buttons.print.min.js'),
                base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js'),
                'https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js',
                base_url('assets/js/demo/moment.js'),
                base_url('assets/js/demo/datatables-demo.js'),
            ],
        ];
        template_view('transaksi/admin', $data);
    }

    public function ajax()
    {

        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            switch (date('l', strtotime($_GET['filter']))) {
                case 'Monday':
                    $filter = [
                        'start' => date('Y-m-d', strtotime($filter . ' -2 day')) . ' 15:15:00',
                        'end' => date('Y-m-d', strtotime($filter)) . ' 15:15:00',
                    ];
                    break;
                default:
                    $filter = [
                        'start' => date('Y-m-d', strtotime($filter . ' -1 day')) . ' 15:15:00',
                        'end' => date('Y-m-d', strtotime($filter)) . ' 15:15:00',
                    ];
                    break;
            }
            $this->transaksi->setFilter($filter);
        }

        $this->transaksi->setUser($this->user);
        $result = $this->transaksi->get_data_table();
        $data = [];
        foreach ($result as $key) {
            $row = [];
            $row[] = date('d/m/y H:i', strtotime($key->tanggal));
            $row[] = $key->nama_gudang;
            $row[] = $key->marketing;
            $row[] = $key->no_hp;
            $row[] = $key->konsumen;
            $row[] = $key->telp_konsumen;
            $row[] = $key->alamat_konsumen;
            $row[] = $key->nama_obat;
            $row[] = $key->expedisi;
            $row[] = $key->no_resi;
            $data[] = $row;
        }

        $ouput = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->transaksi->count_all(),
            'recordsFiltered' => $this->transaksi->count_filtered(),
            'data' => $data
        ];

        echo json_encode($ouput);
    }
}
