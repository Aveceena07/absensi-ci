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
        $this->load->library('form_validation');
    }

    public function dashboard()
    {
        $this->load->view('employee/dashboard');
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

        $data = [
            'kegiatan' => $this->input->post('kegiatan'),
            'date' => $current_datetime,
            'jam_masuk' => $current_datetime,
            'jam_pulang' => $current_datetime,
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
            'id_karyawan' => $id_karyawan,
            'kegiatan' => $this->input->post('kegiatan'),
        ];
        $eksekusi = $this->m_model->update_data('absensi', $data, [
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
        $this->load->view('employee/profil');
    }

    public function izin()
    {
        $this->load->view('employee/izin');
    }

    public function simpan_izin()
    {
        // Tangkap data yang dikirimkan melalui POST
        $keterangan_izin = $this->input->post('keterangan');

        // Load model yang diperlukan untuk menyimpan data izin
        $this->load->model('Izin_model'); // Gantilah dengan model yang sesuai

        // Siapkan data izin yang akan disimpan
        $data = [
            'keterangan_izin' => $keterangan_izin,
            // Kolom lainnya tidak perlu diisi atau dapat diisi dengan nilai default
        ];

        // Panggil model untuk menyimpan data izin
        $this->Izin_model->simpanIzin($data);

        // Setelah selesai, Anda bisa mengarahkan pengguna kembali ke halaman lain, misalnya halaman "history" atau "profil."
        redirect('employee/history'); // Gantilah dengan halaman tujuan yang sesuai
    }
}