<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('admin_model');
        $this->load->helper('admin_helper');
        $this->load->model('m_model');
        $this->load->library('form_validation');
    }

    public function rekap_minggu()
    {
        $data['absensi'] = $this->admin_model->getAbsensiLast7Days();
        $this->load->view('admin/rekap_minggu', $data);
    }

    public function daftar_karyawan()
    {
        $data['absensi'] = $this->User_model->getAllKaryawan();
        $this->load->view('admin/daftar_karyawan', $data);
    }

    public function rekap_bulanan()
    {
        $bulan = $this->input->get('bulan');
        $data['rekap_bulanan'] = $this->admin_model->getRekapBulanan($bulan);
        $data['rekap_harian'] = $this->admin_model->getRekapHarianByBulan(
            $bulan
        );
        $this->load->view('admin/rekap_bulanan', $data);
    }

    public function rekap_harian()
    {
        $tanggal = $this->input->get('tanggal'); // Ambil tanggal dari parameter GET
        $data['rekap_harian'] = $this->admin_model->getRekapHarian($tanggal);
        $this->load->view('admin/rekap_harian', $data);
    }
}