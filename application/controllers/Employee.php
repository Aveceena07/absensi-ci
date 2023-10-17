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
        $id_karyawan = $this->session->userdata('id');
        $data['absensi'] = $this->m_model->get_absensi_by_karyawan(
            $id_karyawan
        );
        $data['absensi_count'] = count($data['absensi']);
        $data['total_absen'] = $this->m_model
            ->get_absen('absensi', $this->session->userdata('id'))
            ->num_rows();
        $data['total_izin'] = $this->m_model
            ->get_izin('absensi', $this->session->userdata('id'))
            ->num_rows();

        $this->load->view('employee/dashboard', $data);
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
        // Atur zona waktu ke Asia/Jakarta (WIB)
        date_default_timezone_set('Asia/Jakarta');

        $id_karyawan = $this->session->userdata('id');
        $tanggal_sekarang = date('Y-m-d'); // Mendapatkan tanggal hari ini
        $jam_masuk = date('H:i:s'); // Mendapatkan jam saat ini di WIB

        // Cek apakah sudah melakukan absen hari ini
        $is_already_absent = $this->m_model->cek_absen(
            $id_karyawan,
            $tanggal_sekarang
        );

        // Cek apakah sudah melakukan izin hari ini
        $is_already_izin = $this->m_model->cek_izin(
            $id_karyawan,
            $tanggal_sekarang
        );

        if ($is_already_absent) {
            $this->session->set_flashdata(
                'gagal_absen',
                'Anda sudah melakukan absen hari ini.'
            );
        } elseif ($is_already_izin) {
            $this->session->set_flashdata(
                'gagal_absen',
                'Anda sudah mengajukan izin hari ini.'
            );
        } else {
            $keterangan_izin = !empty($row['keterangan_izin']) ?: 'masuk';
            $data = [
                'id_karyawan' => $id_karyawan,
                'kegiatan' => $this->input->post('kegiatan'),
                'status' => 'false',
                'keterangan_izin' => 'masuk',
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => '00:00:00',
                'date' => $tanggal_sekarang,
            ];
            $this->m_model->tambah_data('absensi', $data);
            $this->session->set_flashdata('berhasil_absen', 'Berhasil Absen.');
        }

        redirect(base_url('employee/history'));
    }

    public function aksi_pulang($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $waktu_sekarang = date('Y-m-d H:i:s');
        $data = [
            'jam_pulang' => $waktu_sekarang,
            'status' => 'true',
        ];
        $this->m_model->update('absensi', $data, ['id' => $id]);
        redirect(base_url('employee/history'));
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
        $id = $this->input->post('id'); // Dapatkan ID absensi yang akan diubah
        $data = [
            'kegiatan' => $this->input->post('kegiatan'), // Ambil data kegiatan dari form
        ];

        // Panggil fungsi untuk mengupdate data absensi berdasarkan ID
        $eksekusi = $this->m_model->update('absensi', $data, ['id' => $id]);

        if ($eksekusi) {
            $this->session->set_flashdata(
                'berhasil_update',
                'Berhasil mengubah kegiatan.'
            );
            redirect(base_url('employee/history'));
        } else {
            $this->session->set_flashdata(
                'gagal_update',
                'Gagal mengubah kegiatan.'
            );
            redirect(base_url('employee/history'));
        }
    }

    public function profil()
    {
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $data['user'] = $this->User_model->getUserById($user_id);

            $this->load->view('employee/profil', $data);
        } else {
            redirect('auth/register');
        }
    }

    public function izin()
    {
        $this->load->view('employee/izin');
    }

    public function simpan_izin()
    {
        $id_karyawan = $this->session->userdata('id');
        $tanggal_sekarang = date('Y-m-d'); // Mendapatkan tanggal hari ini
        $keterangan_izin = $this->input->post('keterangan');

        $data = [
            'id_karyawan' => $id_karyawan,
            'status' => 'true',
            'keterangan_izin' => 'sakit',
            'date' => $tanggal_sekarang,
            'jam_masuk' => '-', // Mengosongkan jam_masuk
            'jam_pulang' => '-', // Mengosongkan jam_pulang
        ];

        $this->m_model->tambah_data('absensi', $data);

        redirect('employee/history');
    }

    public function aksi_update_izin()
    {
        $id_karyawan = $this->session->userdata('id');
        $data = [
            'keterangan_izin' => $this->input->post('keterangan_izin'),
        ];
        $eksekusi = $this->m_model->update('absensi', $data, [
            'id' => $this->input->post('id'),
        ]);
        if ($eksekusi) {
            $this->session->set_flashdata(
                'berhasil_update_izin',
                'Berhasil mengubah keterangan'
            );
            redirect(base_url('employee/history'));
        } else {
            redirect(
                base_url('employee/update_izin/' . $this->input->post('id'))
            );
        }
    }

    public function update_izin($id)
    {
        $data['absensi'] = $this->m_model
            ->get_by_id('absensi', 'id', $id)
            ->result();
        $this->load->view('employee/update_izin', $data);
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

    public function hapus($id)
    {
        $this->m_model->delete('absensi', 'id', $id);
        $this->session->set_flashdata(
            'berhasil_menghapus',
            'Data berhasil dihapus.'
        );
        redirect(base_url('employee/history'));
    }
}
