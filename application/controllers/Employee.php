<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Absensi_model');
        $this->load->model('m_model');
        $this->load->library('upload');
        $this->load->library('form_validation');
    }

    public function upload_img($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/siswa/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['fle_name'] = $kode;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($value)) {
            return [false, ''];
        } else {
            $fn = $this->upload->data();
            $nama = $fn['file_name'];
            return [true, $nama];
        }
    }

    public function upload_image_karyawan($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/karyawan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 30000;
        $config['file_name'] = $kode;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($value)) {
            return [false, ''];
        } else {
            $fn = $this->upload->data();
            $nama = $fn['file_name'];
            return [true, $nama];
        }
    }

    public function dashboard()
    {
        $this->load->model('Absensi_model');
        $data['absensi'] = $this->Absensi_model->getAbsensi();
        $this->load->view('employee/dashboard', $data);
        $data['absensi'] = $this->Absensi_model->getAbsensi();
        $data['jumlah_masuk'] = $this->Absensi_model
            ->get_data('absensi')
            ->num_rows();
    }

    public function tambah_absen()
    {
        $this->load->view('employee/tambah_absen');
    }
    public function history()
    {
        $this->load->model('Absensi_model');
        $data['absensi'] = $this->Absensi_model->getAbsensi();
        $this->load->view('employee/history', $data);
    }

    public function save_absensi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $current_datetime = date('Y-m-d H:i:s');
        $id_karyawan = $this->session->userdata('id');

        $data = [
            'id_karyawan' => $id_karyawan,
            'kegiatan' => $this->input->post('kegiatan'),
            'date' => $current_datetime,
            'jam_masuk' => $current_datetime,
            'jam_pulang' => '00:00:00',
        ];

        $this->load->model('Absensi_model');
        $this->Absensi_model->createAbsensi($data);

        redirect('employee/history');
    }

    public function update_absen($id)
    {
        $data['absensi'] = $this->m_model
            ->get_by_id('absensi', 'id', $id)
            ->result();
        $this->load->view('employee/update_absen', $data);
    }

    public function aksi_update_absen()
    {
        $id_karyawan = $this->session->userdata('id');
        $data = [
            'kegiatan' => $this->input->post('kegiatan'),
        ];
        $eksekusi = $this->m_model->update('absensi', $data, [
            'id' => $this->input->post('id'),
        ]);
        if ($eksekusi) {
            $this->session->set_flashdata(
                'berhasil_update',
                'Berhasil mengubah kegiatan'
            );
            redirect(base_url('employee/history'));
        } else {
            redirect(
                base_url('employee/update_absen' . $this->input->post('id'))
            );
        }
    }

    public function profil()
    {
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $data['user'] = $this->User_model->getUserById($user_id);

            $this->load->view('employee/profil', $data);
        } else {
            redirect('auth/login');
        }
    }

    public function izin()
    {
        $this->load->view('employee/izin');
    }

    public function simpan_izin()
    {
        $keterangan_izin = $this->input->post('keterangan');

        $this->load->model('Izin_model');

        $data = [
            'id_karyawan' => $id_karyawan,
            'kegiatan' => '-',
            'status' => 'true',
            'keterangan_izin' => $this->input->post('keterangan_izin'),
            'jam_masuk' => '00:00:00', // Mengosongkan jam_masuk
            'jam_pulang' => '00:00:00', // Mengosongkan jam_pulang
        ];

        $this->Izin_model->simpanIzin($data);

        redirect('employee/history');
    }

    public function akun()
    {
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $data['user'] = $this->User_model->getUserById($user_id);

            $this->load->view('employee/akun', $data);
        } else {
            redirect('auth/login');
        }
    }

    public function aksi_ubah_akun()
    {
        $foto = $this->upload_image_karyawan('foto');
        if ($foto[0] == false) {
            $password_baru = $this->input->post('password_baru');
            $konfirmasi_password = $this->input->post('konfirmasi_password');
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $data = [
                'foto' => 'User.png',
                'email' => $email,
                'username' => $username,
            ];
            if (!empty($password_baru)) {
                if ($password_baru === $konfirmasi_password) {
                    $data['password'] = md5($password_baru);
                } else {
                    $this->session->set_flashdata(
                        'message',
                        'Password baru dan Konfirmasi password harus sama'
                    );
                    redirect(base_url('employee/akun'));
                }
            }
            $this->session->set_userdata($data);
            $update_result = $this->m_model->update('user', $data, [
                'id' => $this->session->userdata('id'),
            ]);

            if ($update_result) {
                redirect(base_url('employee/akun'));
            } else {
                redirect(base_url('employee/akun'));
            }
        } else {
            $password_baru = $this->input->post('password_baru');
            $konfirmasi_password = $this->input->post('konfirmasi_password');
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $data = [
                'foto' => $foto[1],
                'email' => $email,
                'username' => $username,
            ];
            if (!empty($password_baru)) {
                if ($password_baru === $konfirmasi_password) {
                    $data['password'] = md5($password_baru);
                } else {
                    $this->session->set_flashdata(
                        'message',
                        'Password baru dan Konfirmasi password harus sama'
                    );
                    redirect(base_url('admin/akun'));
                }
            }
            $this->session->set_userdata($data);
            $update_result = $this->m_model->update('user', $data, [
                'id' => $this->session->userdata('id'),
            ]);

            if ($update_result) {
                redirect(base_url('employee/akun'));
            } else {
                redirect(base_url('employee/akun'));
            }
        }
    }
}
