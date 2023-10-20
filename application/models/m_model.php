<?php

class M_model extends CI_Model
{
    function get_data($table)
    {
        return $this->db->get($table);
    }

    function getwhere($table, $data)
    {
        return $this->db->get_where($table, $data);
    }

    public function delete($table, $field, $id)
    {
        $data = $this->db->delete($table, [$field => $id]);
        return $data;
    }

    public function cek_izin($id_karyawan, $tanggal)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $this->db->where('status', 'true');
        $query = $this->db->get('absensi');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cek_absen($id_karyawan, $tanggal)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $query = $this->db->get('absensi');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_absensi_count()
    {
        return $this->db->count_all_results('absensi');
    }

    public function get_karyawan_rows()
    {
        return $this->db->get_where('user', ['role' => 'karyawan'])->num_rows();
    }

    public function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function get_by_id($table, $id_column, $id)
    {
        $data = $this->db->where($id_column, $id)->get($table);
        return $data;
    }

    public function getBulanan($bulan)
    {
        $this->db->select('absensi.*, user.username');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_karyawan = user.id', 'left');
        $this->db->where("DATE_FORMAT(date, '%m') = ", $bulan);
        $query = $this->db->get();
        return $query->result();
    }

    public function getRekapPerBulan($bulan)
    {
        $this->db->select(
            'MONTH(date) as bulan, COUNT(*) as total_absensi, user.username'
        );
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_karyawan = user.id', 'left');
        $this->db->where('MONTH(date)', $bulan);
        $this->db->group_by('bulan');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRekapHarianByBulan($bulan)
    {
        $this->db->select('absensi.*, user.username');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_karyawan = user.id', 'left');
        $this->db->where('MONTH(absensi.date)', $bulan);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getHarianData($date)
    {
        $this->db->select('absensi.*, user.nama_depan, user.nama_belakang');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_karyawan = user.id', 'left');
        $this->db->where('date', $date);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_rekap_bulanan($date)
    {
        $this->db->from('absensi');
        $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
        $query = $this->db->get();
        return $query->result();
    }

    function get_izin($table, $id_karyawan)
    {
        return $this->db
            ->where('id_karyawan', $id_karyawan)
            ->where('kegiatan', '-')
            ->get($table);
    }

    function get_absen($table, $id_karyawan)
    {
        return $this->db
            ->where('id_karyawan', $id_karyawan)
            ->where('keterangan_izin', 'masuk')
            ->get($table);
    }

    public function update($table, $data, $where)
    {
        $data = $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function ubah_data($table, $data, $where)
    {
        $data = $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }
    function get_absensi_by_karyawan($id_karyawan)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        return $this->db->get('absensi')->result();
    }

    public function cek($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    public function getAbsensiLast7Days()
    {
        $this->load->database();
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));
        $query = $this->db
            ->select(
                'absensi.*,user.nama_depan, user.nama_belakang, COUNT(*) AS total_absences'
            )
            ->from('absensi')
            ->join('user', 'absensi.id_karyawan = user.id', 'left')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->group_by(
                'kegiatan ,date , jam_masuk, jam_pulang, keterangan_izin, status'
            )
            ->get();
        return $query->result_array();
    }

    public function get_bulanan($date)
    {
        $this->db->from('absensi');
        $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_izin_count($id_karyawan)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('status', 'izin');
        $this->db->from('absensi');
        return $this->db->count_all_results();
    }

    public function getAbsensiBulan($bulan)
    {
        $this->db->select('absensi.*,user.nama_depan, user.nama_belakang');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_karyawan = user.id', 'left');
        $this->db->where("DATE_FORMAT(date, '%m') =", $bulan);
        $query = $this->db->get();
        return $query->result();
    }
}

?>