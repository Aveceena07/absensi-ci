<?php

class Absensi_model extends CI_Model
{
    public function createAbsensi($data)
    {
        // Menambahkan data absensi baru ke database
        $this->db->insert('absensi', $data);
    }

    public function getAbsensi()
    {
        // Mengambil data absensi dari tabel 'absensi'
        $query = $this->db->get('absensi');

        // Mengembalikan hasil query dalam bentuk array
        return $query->result_array();
    }

    public function updateAbsensi($id, $data)
    {
        // Mengubah data absensi berdasarkan ID
        $this->db->where('id', $id);
        $this->db->update('absensi', $data);
    }

    public function deleteAbsensi($id)
    {
        // Menghapus data absensi berdasarkan ID
        $this->db->where('id', $id);
        $this->db->delete('absensi');
    }
}

?>