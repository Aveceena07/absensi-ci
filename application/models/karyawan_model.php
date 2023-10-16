<?php
class Karyawan_model extends CI_Model
{
    public function setAbsensiPulang($absen_id)
    {
        $data = [
            'jam_pulang' => date('H:i:s'),
            'status' => 'DONE',
        ];

        $this->db->where('id', $absen_id);
        $this->db->update('absensi', $data);
    }

    public function batalPulang($absen_id)
    {
        $data = [
            'jam_pulang' => null,
            'status' => 'NOT',
        ];

        $this->db->where('id', $absen_id);
        $this->db->update('absensi', $data);
    }
}

?>