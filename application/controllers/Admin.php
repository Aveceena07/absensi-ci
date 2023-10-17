<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('admin_model');
        $this->load->helper('admin_helper');
        $this->load->library('upload');
        $this->load->model('m_model');
        $this->load->library('form_validation');
    }

    public function dashboard()
    {
        $id_admin = $this->session->userdata('id');
        $data['absensi'] = $this->m_model->get_data('absensi')->result();
        $data['user'] = $this->m_model->get_data('user')->num_rows();
        $data['karyawan'] = $this->m_model->get_karyawan_rows();
        $data['absensi_num'] = $this->m_model->get_absensi_count();
        $this->load->view('admin/dashboard', $data);
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

    public function upload_image_admin($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/admin/';
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

    public function export_mingguan()
    {
        $tanggal_akhir = date('Y-m-d');
        $tanggal_awal = date(
            'Y-m-d',
            strtotime('-7 days', strtotime($tanggal_akhir))
        );
        $tanggal_awal = date('W', strtotime($tanggal_awal));
        $tanggal_akhir = date('W', strtotime($tanggal_akhir));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($tanggal_awal && $tanggal_akhir)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' =>
                        \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                    'vertical' =>
                        \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => [
                        'borderstyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $style_row = [
                'alignment' => [
                    'vertical' =>
                        \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => [
                        'borderstyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                ],
            ];

            // set judul
            $sheet->setCellValue('A1', 'REKAP DATA MINGGUAN');
            $sheet->mergeCells('A1:E1');
            $sheet
                ->getStyle('A1')
                ->getFont()
                ->setBold(true);
            // set thead
            $sheet->setCellValue('A3', 'NO');
            $sheet->setCellValue('B3', 'NAMA KARYAWAN');
            $sheet->setCellValue('C3', 'KEGIATAN');
            $sheet->setCellValue('D3', 'DATE');
            $sheet->setCellValue('E3', 'JAM MASUK');
            $sheet->setCellValue('F3', 'JAM PULANG');
            $sheet->setCellValue('G3', 'KETERANGAN IZIN');

            // mengaplikasikan style thead
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);

            // get dari database
            $data_mingguan = $this->m_model->getAbsensiLast7Days(
                $tanggal_awal,
                $tanggal_akhir
            );

            $no = 1;
            $numrow = 4;
            foreach ($data_mingguan as $data) {
                $sheet->setCellValue('A' . $numrow, $data['id']);
                $sheet->setCellValue(
                    'B' . $numrow,
                    $data['nama_depan'] . ' ' . $data['nama_belakang']
                );
                $sheet->setCellValue('C' . $numrow, $data['kegiatan']);
                $sheet->setCellValue('D' . $numrow, $data['date']);
                $sheet->setCellValue('E' . $numrow, $data['jam_masuk']);
                $sheet->setCellValue('F' . $numrow, $data['jam_pulang']);
                $sheet->setCellValue('G' . $numrow, $data['keterangan_izin']);

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

                $no++;
                $numrow++;
            }

            // set panjang column
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);

            $sheet->getDefaultRowDimension()->setRowHeight(-1);

            $sheet
                ->getPageSetup()
                ->setOrientation(
                    \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
                );

            // set nama file saat di export
            $sheet->setTitle('LAPORAN REKAP DATA MINGGUAN');
            header(
                'Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet'
            );
            header(
                'Content-Disposition: attachment; filename="REKAP_MINGGUAN.xlsx"'
            );
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }
    }

    public function export_harian()
    {
        $date = date('Y-m-d');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($date)) {
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' =>
                        \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                    'vertical' =>
                        \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => [
                        'borderstyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $style_row = [
                'alignment' => [
                    'vertical' =>
                        \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => [
                        'borderstyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                    ],
                ],
            ];

            // set judul
            $sheet->setCellValue('A1', 'REKAP DATA HARIAN');
            $sheet->mergeCells('A1:E1');
            $sheet
                ->getStyle('A1')
                ->getFont()
                ->setBold(true);
            // set thead
            $sheet->setCellValue('A3', 'ID');
            $sheet->setCellValue('B3', 'NAMA KARYAWAN');
            $sheet->setCellValue('C3', 'KEGIATAN');
            $sheet->setCellValue('D3', 'DATE');
            $sheet->setCellValue('E3', 'JAM MASUK');
            $sheet->setCellValue('F3', 'JAM PULANG');
            $sheet->setCellValue('G3', 'KETERANGAN IZIN');

            // mengaplikasikan style thead
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);

            // get dari database
            $data_harian = $this->m_model->getHarianData($date);

            $no = 1;
            $numrow = 4;
            foreach ($data_harian as $data) {
                $sheet->setCellValue('A' . $numrow, $data->id);
                $sheet->setCellValue(
                    'B' . $numrow,
                    $data->nama_depan . ' ' . $data->nama_belakang
                );
                $sheet->setCellValue('C' . $numrow, $data->kegiatan);
                $sheet->setCellValue('D' . $numrow, $data->date);
                $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
                $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
                $sheet->setCellValue('G' . $numrow, $data->keterangan_izin);

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

                $no++;
                $numrow++;
            }

            // set panjang column
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);

            $sheet->getDefaultRowDimension()->setRowHeight(-1);

            $sheet
                ->getPageSetup()
                ->setOrientation(
                    \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
                );

            // set nama file saat di export
            $sheet->setTitle('LAPORAN REKAP DATA HARIAN');
            header(
                'Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet'
            );
            header(
                'Content-Disposition: attachment; filename="REKAP_HARIAN.xlsx"'
            );
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }
    }

    public function export_karyawan()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderstyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
            ],
        ];

        $style_row = [
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderstyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
            ],
        ];

        // set judul
        $sheet->setCellValue('A1', 'DATA ABSESNI KARYAWAN');
        $sheet->mergeCells('A1:E1');
        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true);
        // set thead
        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'NAMA KARYAWAN');
        $sheet->setCellValue('C3', 'KEGIATAN');
        $sheet->setCellValue('D3', 'TANGGAL');
        $sheet->setCellValue('E3', 'JAM MASUK');
        $sheet->setCellValue('F3', 'JAM PULANG');
        $sheet->setCellValue('G3', 'STATUS');

        // mengaplikasikan style thead
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);

        // get dari database
        $data_siswa = $this->admin_model->getExportKaryawan();

        $no = 1;
        $numrow = 4;
        foreach ($data_siswa as $data) {
            $sheet->setCellValue('A' . $numrow, $data->id);
            $sheet->setCellValue('B' . $numrow, $data->username);
            $sheet->setCellValue('C' . $numrow, $data->kegiatan);
            $sheet->setCellValue('D' . $numrow, $data->date);
            $sheet->setCellValue('E' . $numrow, $data->jam_masuk);
            $sheet->setCellValue('F' . $numrow, $data->jam_pulang);
            $sheet->setCellValue('G' . $numrow, $data->status);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        // set panjang column
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(25);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );

        // set nama file saat di export
        $sheet->setTitle('LAPORAN DATA PEMBAYARAN');
        header(
            'Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename="ABSEN KARYAWAN.xlsx"'
        );
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function export_bulanan()
    {
        $bulan = $this->input->post('bulan');
        require_once FCPATH . 'vendor/autoload.php';
        // date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $style_row = [
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A1', "REKAP DATA BULANAN ($date)");
        $sheet->mergeCells('A1:G1');
        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true);

        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA KARYAWAN');
        $sheet->setCellValue('C3', 'DATE');
        $sheet->setCellValue('D3', 'JAM MASUK');
        $sheet->setCellValue('E3', 'JAM PULANG');
        $sheet->setCellValue('F3', 'KETERANGAN IZIN');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);

        // $where = ['MONTH(date)' => $date];
        $absensi = $this->m_model->getAbsensiBulan($bulan);

        $no = 1;
        $numrow = 4;

        foreach ($absensi as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue(
                'B' . $numrow,
                $data->nama_depan . ' ' . $data->nama_belakang
            );
            $sheet->setCellValue('C' . $numrow, $data->date);
            $sheet->setCellValue('D' . $numrow, $data->jam_masuk);
            $sheet->setCellValue('E' . $numrow, $data->jam_pulang);
            $sheet->setCellValue('F' . $numrow, $data->keterangan_izin);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);

        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );

        $sheet->setTitle('REKAP BULANAN');

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename="REKAP_BULANAN.xlsx"'
        );
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function export_daftar_karyawan()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderstyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
            ],
        ];

        $style_row = [
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderstyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
                ],
            ],
        ];

        // set judul
        $sheet->setCellValue('A1', 'DATA DAFTAR KARYAWAN');
        $sheet->mergeCells('A1:E1');
        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true);
        // set thead
        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'NAMA KARYAWAN');
        $sheet->setCellValue('C3', 'EMAIL');

        // mengaplikasikan style thead
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);

        // get dari database
        $data_karyawan = $this->User_model->getAllKaryawan(); // Ganti $data_siswa menjadi $data_karyawan

        $no = 1;
        $numrow = 4;
        foreach ($data_karyawan as $data) {
            $sheet->setCellValue('A' . $numrow, $data->id);
            $sheet->setCellValue('B' . $numrow, $data->username);
            $sheet->setCellValue('C' . $numrow, $data->email);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        // set panjang column
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );

        // set nama file saat di export
        $sheet->setTitle('LAPORAN DATA PEMBAYARAN');
        header(
            'Content-Type: aplication/vnd.openxmlformants-officedocument.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename="DAFTAR-KARYAWAN.xlsx"'
        );
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function profil()
    {
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $data['user'] = $this->User_model->getUserById($user_id);

            $this->load->view('admin/profil', $data);
        } else {
            redirect('auth/register');
        }
    }

    public function akun()
    {
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $data['user'] = $this->User_model->getUserById($user_id);

            $this->load->view('admin/akun', $data);
        } else {
            redirect('auth/login');
        }
    }

    public function aksi_ubah_akun()
    {
        $foto = $this->upload_image_admin('foto');
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
                    redirect(base_url('admin/profil'));
                }
            }
            $this->session->set_userdata($data);
            $update_result = $this->m_model->update('user', $data, [
                'id' => $this->session->userdata('id'),
            ]);

            if ($update_result) {
                redirect(base_url('admin/profil'));
            } else {
                redirect(base_url('admin/profil'));
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
                    redirect(base_url('admin/profil'));
                }
            }
            $this->session->set_userdata($data);
            $update_result = $this->m_model->update('user', $data, [
                'id' => $this->session->userdata('id'),
            ]);

            if ($update_result) {
                redirect(base_url('admin/profil'));
            } else {
                redirect(base_url('admin/profil'));
            }
        }
    }

    public function history_absen()
    {
        $data['absensi'] = $this->m_model->get_data('absensi')->result();
        $this->load->view('admin/history_absen', $data);
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
