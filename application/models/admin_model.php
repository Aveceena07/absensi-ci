<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getKaryawan()
    {
        $query = $this->db->get('absensi');
        return $query->result_array();
    }

    public function getRekapHarian($tanggal)
    {
        $this->db->select(
            'absensi.id, absensi.date, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.status'
        );
        $this->db->from('absensi');
        $this->db->where('absensi.date', $tanggal); // Menyaring data berdasarkan tanggal
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAbsensiLast7Days()
    {
        $this->load->database();
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));
        $query = $this->db
            ->select(
                'date, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status, COUNT(*) AS total_absences'
            )
            ->from('absensi')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->group_by(
                'date, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status'
            )
            ->get();
        return $query->result_array();
    }

    public function getRekapBulanan($bulan)
    {
        $this->db->select('MONTH(date) as bulan, COUNT(*) as total_absensi');
        $this->db->from('absensi');
        $this->db->where('MONTH(date)', $bulan); // Menyaring data berdasarkan bulan
        $this->db->group_by('bulan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRekapHarianByBulan($bulan)
    {
        $this->db->select(
            'absensi.id, absensi.date, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.status'
        );
        $this->db->from('absensi');
        $this->db->where('MONTH(absensi.date)', $bulan);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getExportKaryawan()
    {
        $this->db->select(
            'absensi.id, user.username, absensi.kegiatan, absensi.tanggal, absensi.jam_masuk, absensi.jam_pulang, absensi.status'
        );
        $this->db->from('absensi');
        $this->db->join('user', 'user.id = absensi.id_karyawan', 'left');
        $query = $this->db->get();

        return $query->result();
    }

    public function exportDataRekapHarian($tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('tanggal, COUNT(*) as total_absensi');
        $this->db->from('absensi');
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $this->db->group_by('tanggal');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function exportDataRekapMingguan()
    {
        $this->db->select('WEEK(tanggal) as minggu, COUNT(*) as total_absensi');
        $this->db->from('absensi');
        $this->db->group_by('minggu');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function exportDataRekapBulanan()
    {
        $this->db->select('MONTH(tanggal) as bulan, COUNT(*) as total_absensi');
        $this->db->from('absensi');
        $this->db->group_by('bulan');
        $query = $this->db->get();
        return $query->result_array();
    }
}