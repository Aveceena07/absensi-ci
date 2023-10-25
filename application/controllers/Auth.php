<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('absensi_model');
        $this->load->model('m_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $this->load->view('auth/login');
    }

    public function register()
    {
        $this->load->view('auth/register');
    }

    public function register_admin()
    {
        $this->load->view('auth/register_admin');
    }

    public function aksi_register()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email|is_unique[User.email]'
        );
        $this->form_validation->set_rules(
            'nama_depan',
            'Nama Depan',
            'required'
        );
        $this->form_validation->set_rules(
            'nama_belakang',
            'Nama Belakang',
            'required'
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|min_length[8]'
        );

        if ($this->form_validation->run() === false) {
            // Tampilkan SweetAlert jika validasi panjang kata sandi gagal
            $this->session->set_flashdata('password_length_error', true);
            $this->load->view('auth/register');
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'nama_depan' => $this->input->post('nama_depan'),
                'nama_belakang' => $this->input->post('nama_belakang'),
                'password' => md5($this->input->post('password')),
                'role' => 'karyawan',
            ];

            if ($this->input->post('admin_code') == 'admin_secret_code') {
                $data['role'] = 'admin';
            }

            $data['foto'] = 'User.png';

            $this->User_model->registerUser($data);

            $this->session->set_flashdata('success_register', true);

            redirect('home');
        }
    }

    public function aksi_login()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $data = ['email' => $email];
        $query = $this->m_model->getwhere('user', $data);
        $result = $query->row_array();

        if (!empty($result) && md5($password) === $result['password']) {
            $data = [
                'logged_in' => true,
                'email' => $result['email'],
                'username' => $result['username'],
                'role' => $result['role'],
                'id' => $result['id'],
            ];
            $this->session->set_userdata($data);
            if ($this->session->userdata('role') == 'admin') {
                redirect(base_url() . 'admin/dashboard');
            } elseif ($this->session->userdata('role') == 'karyawan') {
                redirect(base_url() . 'employee/dashboard');
            } else {
                redirect(base_url() . 'home');
            }
        } else {
            $this->session->set_flashdata('login_error', 'Password Salah');
            redirect(base_url() . 'home');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('home'));
    }
}
?>
