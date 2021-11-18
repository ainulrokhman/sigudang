<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'user');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$session = $this->session->userdata('user');
		if (!$session) {
			redirect('auth/login');
		} else {
			$user = $this->db->get_where('user', ['email' => $session['email']])->row_array();
			$data = [
				'title' => 'Dashboard',
				'nama' => $user['nama'],
			];
			template_view('auth/index', $data);
		}
	}

	public function register()
	{
		$validasi = [
			[
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required|trim',
				'errors' => array(
					'required' => 'Nama wajib diisi',
				),
			],
			[
				'field' => 'telp',
				'label' => 'No HP',
				'rules' => 'required|trim',
				'errors' => array(
					'required' => 'No HP wajib diisi',
				),
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|trim|valid_email|is_unique[user.email]',
				'errors' => array(
					'is_unique' => 'Email sudah terdaftar',
					'required' => 'Email wajib diisi',
					'valid_email' => 'Email tidak valid',
				),
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|trim|min_length[6]|matches[pass]',
				'errors' => array(
					'required' => 'Password wajib diisi',
					'min_length' => 'Password minimal 6 karakter',
					'matches' => 'Password tidak cocok',
				),
			],
			[
				'field' => 'pass',
				'label' => 'pass',
				'rules' => 'required|trim|matches[password]',
			],
		];

		$this->form_validation->set_rules($validasi);

		if ($this->form_validation->run()) {
			$user = [
				'nama' => $this->_secure('nama'),
				'email' => $this->_secure('email'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'image' => 'undraw_profile.svg',
				'role_id' => 2,
				'is_active' => 1,
			];
			$this->db->insert('user', $user);

			$marketing = [
				'id_manager' => $this->db->insert_id(),
				'nama' => $this->_secure('nama'),
				'no_hp' => $this->_secure('telp'),
			];
			$this->db->insert('marketing', $marketing);

			notify('success', 'Anda telah terdaftar, silahkan login');
			redirect('auth/login');
		} else {
			$this->load->view('auth/register');
		}
	}

	public function login()
	{
		$validasi = [
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|trim',
				'errors' => array(
					'required' => 'Password wajib diisi',
				),
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|trim|valid_email',
				'errors' => array(
					'valid_email' => 'Email tidak valid',
					'required' => 'Email wajib diisi',
				),
			],
		];

		$this->form_validation->set_rules($validasi);

		if ($this->form_validation->run()) {
			$email = $this->_secure('email');
			$password = $this->_secure('password');
			$user = $this->db->get_where('user', ['email' => $email])->row_array();
			$this->_auth($user, $password);
		} else {
			$this->load->view('auth/login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('user');
		notify('success', 'Logout berhasil');
		redirect('auth/login');
	}

	private function _secure($field)
	{
		return htmlspecialchars($this->input->post($field, true));
	}

	private function _auth($user, $password)
	{
		if ($user) {
			if ($user['is_active']) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'user' => [
							'email' => $user['email'],
							'role_id' => $user['role_id'],
						]
					];
					$this->session->set_userdata($data);
					redirect(base_url());
				} else {
					notify('danger', 'Password salah');
					redirect('auth/login');
				}
			} else {
				notify('danger', 'Email belum diaktivasi');
				redirect('auth/login');
			}
		} else {
			notify('danger', 'Email belum terdaftar');
			redirect('auth/login');
		}
	}
}
