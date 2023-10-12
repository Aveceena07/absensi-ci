<?php
class Izin_model extends CI_Model
{
    public function simpanIzin($data)
    {
        $this->db->insert('absensi', $data); // Gantilah 'izin' dengan nama tabel yang sesuai
    }
}
?>
