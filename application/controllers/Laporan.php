<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Laporan'));
    }

    public function index()
    {
        $user = $this->db->get('tb_permohonan')->result();
        $data = [
            'title' => "Laporan",
            'titlePage' => 'Laporan',
            'data' => $user
        ];
		$this->load->view('body/header', $data);
		$this->load->view('body/laporan/index',$data);
		$this->load->view('body/footer');
    }
    function get_list_laporan()
    {
        $list = $this->M_Laporan->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $field) {
            $no++;

            if ($field->status_permohonan === 'Waiting') {
                $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
                <a href="'.'detail/'.$field->unik.'" class="badge bg-primary invisible"><i class="bx bx-edit"></i></a>
                ';
            }else if($field->status_permohonan == 'Approved'){
                $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
            }else if($field->status_permohonan == 'Done'){
                $status = '<span class="badge bg-success"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
            }else{
                $status = '';
            }

            if ($field->no_permohonan > 0) {
               $permohonan = '<span class="badge bg-primary">'.$field->no_permohonan.'</span>';
            }else{
               $permohonan='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';
            }

            if($field->status_permohonan == 'Approved'){
                $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
            }else if($field->status_permohonan == 'Rejected'){
                $status_admin = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
            }else{
                $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
            }
            
            if($field->status_permohonan_atasan == 'Approved'){
                $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_atasan .'</span><br>'.$field->tgl_status_admin;
            }else if($field->status_permohonan_atasan == 'Rejected'){
                $status_atasan ='<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. $field->nama_atasan .'</span>';
            }else if($field->status_permohonan == 'Rejected'){
                $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. $field->nama_atasan . ' </span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
            }else{
                $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';
            }
            
            $row = array();
            
			$row[] = $no;
			$row[] = $field->nama_pemohon;
			$row[] = $permohonan;
			$row[] = $field->tgl_permohonan;
            if($this->session->userdata('filterPermohonan') == 'data_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
                $row[] = $status_admin;
                $row[] = $status_atasan;
            }
            if ($field->status_permohonan_atasan == 'Approved') {
                $row[] = '<a href="" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
                <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3>Upload File bukti bayar</h3>
                      </div>
                      <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                        <input type="hidden" name="unik" value="'.$field->unik.'">
                        <input type="hidden" name="status" value="upload_file_bayar">
                        <div class="col-12">
                          <label class="form-label w-100" for="modalAddCard">File</label>
                            <input name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
                        </div>
                        
                        <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                          <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
                ';
            }else{
                $row[] = '';
            }
			$row[] = $status;

            
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->M_Laporan->count_all(),
            "recordsFiltered" => $this->M_Laporan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    function get()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->session->userdata('filterTahun');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'PERMOHONAN APPROVED');
        $sheet->setCellValue('A2', 'Nama Pemohonan')->getDefaultColumnDimension()->setWidth(20);
        $sheet->setCellValue('B2', 'Nomor Pemohonan');
        $sheet->setCellValue('C2', 'Tanggal Pemohonan');
        $sheet->setCellValue('D2', 'Tahun');
        $sheet->setCellValue('E2', 'Nominal');
        
        $sheet->setCellValue('G1', 'DETAIL PERMOHONAN APPROVED');
        $sheet->setCellValue('G2', 'Isi Pemohonan')->getDefaultColumnDimension()->setWidth(20);
        $sheet->setCellValue('H2', 'No Pemohon');
        $sheet->setCellValue('I2', 'Tanggal');
        $sheet->setCellValue('J2', 'Nominal');
        //detail permohonan
        $get_detail = $this->db->query("SELECT * from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='$bulan'")->result();
        $column2= 3;
        $total_nominal2 = 0;
        foreach ($get_detail as $x) {
            $sheet->setCellValue('G'.$column2, $x->isi_permohonan);
            $sheet->setCellValue('H'.$column2, $x->no_permohonan);
            $sheet->setCellValue('I'.$column2, $x->date_created);
            $sheet->setCellValue('J'.$column2, 'Rp.'.number_format($x->nominal,0,'.','.'));
            $column2++;
            $total_nominal2 += $x->nominal;
        }
        $sheet->setCellValue('I'.$column2, 'Total Nominal');
        $sheet->setCellValue('J'.$column2, 'Rp.'.number_format($total_nominal2,0,'.','.'));

        //permohonan
        $get = $this->db->query("SELECT *,SUM(b.nominal) as nominal_detail from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='$bulan' GROUP BY a.unik ")->result();
        $column = 3;
        $total_nominal = 0;
        foreach ($get as $x) {
            $sheet->setCellValue('A'.$column, $x->nama_pemohon);
            $sheet->setCellValue('B'.$column, $x->no_permohonan);
            $sheet->setCellValue('C'.$column, $x->tgl_permohonan);
            $sheet->setCellValue('D'.$column, $x->tahun);
            $sheet->setCellValue('E'.$column, 'Rp.'.number_format($x->nominal_detail,0,'.','.'));
            $column++;
            $total_nominal += $x->nominal_detail;
        }
        $sheet->setCellValue('D'.$column, 'Total Nominal');
        $sheet->setCellValue('E'.$column, 'Rp.'.number_format($total_nominal,0,'.','.'));

        //permohonan Rejected
        $sheet->setCellValue('L1', 'PERMOHONAN REJECTED');
        $sheet->setCellValue('L2', 'Nama Pemohonan')->getDefaultColumnDimension()->setWidth(20);
        $sheet->setCellValue('M2', 'Alasan Rejected');
        $sheet->setCellValue('N2', 'Tanggal Pemohonan');
        $sheet->setCellValue('O2', 'Tahun');
        $sheet->setCellValue('P2', 'Nominal');
        $get_rejected = $this->db->query("SELECT *,SUM(b.nominal) as nominal_detail from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Rejected' AND DATE_FORMAT(a.tgl_permohonan,'%m')='$bulan' GROUP BY a.unik ")->result();
        $column_rejected = 3;
        $total_nominal_rejected = 0;
        foreach ($get_rejected as $x) {
            $sheet->setCellValue('L'.$column_rejected, $x->nama_pemohon);
            $sheet->setCellValue('M'.$column_rejected, $x->note_status_permohonan);
            $sheet->setCellValue('N'.$column_rejected, $x->tgl_permohonan);
            $sheet->setCellValue('O'.$column_rejected, $x->tahun);
            $sheet->setCellValue('P'.$column_rejected, 'Rp.'.number_format($x->nominal_detail,0,'.','.'));
            $column_rejected++;
            $total_nominal_rejected += $x->nominal_detail;
        }
        $sheet->setCellValue('O'.$column_rejected, 'Total Nominal');
        $sheet->setCellValue('P'.$column_rejected, 'Rp.'.number_format($total_nominal_rejected,0,'.','.'));

         //permohonan detail Rejected
         $sheet->setCellValue('R1', 'PERMOHONAN DETAIL REJECTED');
         $sheet->setCellValue('R2', 'Nama Pemohonan')->getDefaultColumnDimension()->setWidth(20);
         $sheet->setCellValue('S2', 'Tanggal Pemohonan');
         $sheet->setCellValue('T2', 'Tahun');
         $sheet->setCellValue('U2', 'Nominal');
         $get_rejected2 = $this->db->query("SELECT * from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Rejected' AND DATE_FORMAT(a.tgl_permohonan,'%m')='$bulan' ")->result();
         $column_rejected2 = 3;
         $total_nominal_rejected2 = 0;
         foreach ($get_rejected2 as $x) {
             $sheet->setCellValue('R'.$column_rejected2, $x->nama_pemohon);
             $sheet->setCellValue('S'.$column_rejected2, $x->tgl_permohonan);
             $sheet->setCellValue('T'.$column_rejected2, $x->tahun);
             $sheet->setCellValue('U'.$column_rejected2, 'Rp.'.number_format($x->nominal,0,'.','.'));
             $column_rejected2++;
             $total_nominal_rejected2 += $x->nominal;
         }
         $sheet->setCellValue('T'.$column_rejected2, 'Total Nominal');
         $sheet->setCellValue('U'.$column_rejected2, 'Rp.'.number_format($total_nominal_rejected2,0,'.','.'));

        $filename = 'Report_'.$bulan.'_'.$tahun.'.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save('upload/'.$filename);
        $this->load->helper('download');
        // read file contents
        $data = file_get_contents(base_url('upload/'.$filename));
        force_download($filename, $data);
        unlink('upload/'.$filename);
        redirect('dashboard');
    }
    function filter()
    {
        if ($this->input->post('tahun')) {
            $this->session->set_userdata('filterTahun',$this->input->post('tahun'));
            redirect('dashboard');
        }
    }
    
}