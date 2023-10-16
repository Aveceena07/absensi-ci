<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Absensi_model');
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
            'required|min_length[6]'
        );

        if ($this->form_validation->run() === false) {
            $this->load->view('auth/register');
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'nama_depan' => $this->input->post('nama_depan'),
                'nama_belakang' => $this->input->post('nama_belakang'),
                'password' => password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                ),
                'role' => 'karyawan',
            ];

            if ($this->input->post('admin_code') == 'admin_secret_code') {
                $data['role'] = 'admin';
            }

            $this->User_model->registerUser($data);

            redirect('auth');
        }
    }

    public function aksi_login()
    {
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email'
        );
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === false) {
            $this->load->view('auth');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->getUserByEmail($email);

            if (!$user) {
                $data['error'] = 'Email or password is incorrect';
                $this->load->view('auth', $data);
            } else {
                if (password_verify($password, $user->password)) {
                    $this->session->set_userdata('id', $user->id);

                    if ($user->role == 'admin') {
                        redirect('admin/admin');
                    } elseif ($user->role == 'karyawan') {
                        redirect('employee/dashboard');
                    }
                } else {
                    $data['error'] = 'Email or password is incorrect';
                    $this->load->view('auth', $data);
                }
            }
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
?>