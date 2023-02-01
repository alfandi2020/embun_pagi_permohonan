<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan extends CI_Controller {
    var $id_ririn = '12';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Permohonan'));
        date_default_timezone_set("Asia/Jakarta");
        $this->load->library('Api_Whatsapp');

    }
    public function index()
	{
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "Tambah Permohonan",
            'titlePage' => 'Tambah Permohonan'
        ];
        $set_unik = time() . rand(111, 999);
        $this->session->set_userdata('setUnik', $set_unik);
        $this->session->set_userdata('filterPermohonan','permohonan_baru');
		$this->load->view('body/header', $data);
		$this->load->view('body/permohonan');
		$this->load->view('body/footer');
	}
    function track()
    {
        $sekolah = $this->session->userdata('filterSekolah');
        if ($sekolah) {
            $this->db->where('tujuan_sekolah',$sekolah);
        }
        $this->db->order_by('tgl_permohonan','desc');
        $track = $this->db->get('tb_permohonan')->result();
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "Tracking Permohonan",
            'titlePage' => 'Tracking Permohonan',
            'track' => $track
        ];
        // $this->session->set_userdata('filterPermohonan','permohonan_baru');
		$this->load->view('body/header', $data);
		$this->load->view('body/tracking');
		$this->load->view('body/footer');
    }
    function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tahun
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tanggal

        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
    function remove_special($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
     }

    public function filter(){
        if($this->uri->segment(3)){
            $filter = $this->uri->segment(3);
            $this->session->set_userdata('filterPermohonan', $filter);
            redirect('permohonan/list2');
        }
    }
    public function filter_sekolah(){
            $filter = $this->input->post('sekolah');
            $this->session->set_userdata('filterSekolah', $filter);
            redirect('permohonan/list2');
    }
    public function filter_sekolah2(){
            $filter = $this->input->post('sekolah');
            $this->session->set_userdata('filterSekolah', $filter);
            redirect('permohonan/track');
    }
    function reset_sekolah()
    {
        $this->session->unset_userdata('filterSekolah');
        redirect('permohonan/list2');
    }
    function reset_sekolah2()
    {
        $this->session->unset_userdata('filterSekolah');
        redirect('permohonan/list2');
    }
    public function submit()
    {
        $row = $this->input->post('row');
        if (count($row) > 1) {
            $set_unik = $this->session->userdata('setUnik');
            $id_user = $this->session->userdata('id_user');
            $nama = $this->input->post('nama');
            $data = [
                'unik' => $set_unik,
                'id_user' => $id_user,
                'nama_pemohon' => strtoupper($nama),
                'tujuan_sekolah' => $this->input->post('tujuan_sekolah'),
                'tgl_permohonan' => date('Y-m-d H:i:s'),
                'tahun' => date('Y'),
                // 'id_admin' => $this->input->post('admin'),
                'status_permohonan' => 'Waiting'
            ];
            $this->db->insert('tb_permohonan',$data);

            if (count($row) >= 3) {
                $pisah = "\n===================\n";
            }else{
                $pisah = "\n";
            }

            $isi_permohonan_x = array();
            for ($i=1; $i <count($row); $i++) {
                    $target_dir = "upload/file/";
                    $file = $_FILES['att'.$i]['name'];
                    $path = pathinfo($file);
                    $filename = $set_unik.'_'. $i . '_'.$path['filename'];
                    $ext = $path['extension'];
                    $temp_name = $_FILES['att'.$i]['tmp_name'];
                    $path_filename_ext = $target_dir.$filename.".".$ext;
                    move_uploaded_file($temp_name,$path_filename_ext);
                    $url_link =  "http://localhost/embun_pagi_pengajuan/upload/file/" . $set_unik.'_' . $i . '_'.$_FILES['att'.$i]['name'];
                    $isi_permohonan_x[] = "Isi permohonan : *".$this->input->post('isi'.$i)."*\nNominal : *" . $this->input->post('nominal'.$i). "*\nLink file : $url_link $pisah";
                    $detail = [
                        "unik" => $set_unik,
                        "isi_permohonan" => $this->input->post('isi'.$i),
                        "nominal" => substr($this->remove_special($this->input->post('nominal'.$i)),2),
                        "file" => $set_unik.'_' . $i . '_'.$_FILES['att'.$i]['name']
                    ];
                    $this->db->insert('tb_permohonan_detail',$detail);
            }
             //send notif
            //  'http://localhost/embun_pagi_pengajuan/permohonan/status/1673876843588/Approved/confirm_admin';
            // $approve = "http://localhost/embun_pagi_pengajuan/approve/status/".$set_unik."/Approved/confirm_admin";
            $msg = "*[Notifkasi Permohonan Baru]*\n\nPermohonan baru dari : *$nama*\nTanggal : ". $this->tgl_indo(date('Y-m-d')).' '. date('H:i:s')."\n\n*[List Permohonan]*\n". implode('',$isi_permohonan_x)."\nSilahkan cek di https://pengeluaran.embunpagi.sch.id/";
            $get_userr = $this->db->query("SELECT * FROM users where id='$id_user'")->row_array();
            $get_admin_filter = $this->db->query("SELECT * FROM users where id='24'")->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_userr['telp']);//send to user
            $this->session->set_flashdata('msg','berhasil_x');
        }else{
            $this->session->set_flashdata('msg','not_item');
            redirect('permohonan');
        }
        $this->session->unset_userdata('setUnik');
        redirect('permohonan');
    }
    function list2()
    {
        // $level = $this->session->userdata('level');
        // if ($level == 2) {
        //     $filter = 'waiting';
        //     $this->session->set_userdata('filterPermohonan', $filter);
        // }
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "List Permohonan",
            'titlePage' => 'List Permohonan',
            // 'data' => $this->db->get('tb_permohonan')->result()
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/list',$data);
		$this->load->view('body/footer');
    }
    function tes_api()
    {
        $this->api_whatsapp->wa_notif('adawdwa','083897943785');
    }
    function get_list_permohonan()
    {
        $id_ririn = '12';
        $id_tata = '13';
        $id_ivo = '20';

        $list = $this->M_Permohonan->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        $level = $this->session->userdata('level');
        foreach ($list as $field) {
            $no++;

            $tb_atasan = $this->db->get_where('tb_atasan',['unik' => $field->unik])->result();
            $nama_atasan_app = array();
            $id_atasan = array();
            foreach ($tb_atasan as $x) {
                $nama_atasan_app[] = $x->nama;
                $id_atasan[] = $x->id_user;
            }
            if (strpos($field->check_admin_approval,$id_ririn) == false  && $this->session->userdata('id_user') == $id_ririn ) { //ririn,tata,ivo check admin approval
                if ($field->status_permohonan === 'Waiting') {
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
                    <a href="'.'detail/'.$field->unik.'" class="badge bg-primary invisible"><i class="bx bx-edit"></i></a>
                    ';
                }else if($field->status_permohonan == 'Approved'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                }else if($field->status_permohonan == 'Done'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                    // $status = '<span class="badge bg-success"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
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
                    $status_admin = '<button type="button" id="'.$field->unik.'" class="btn btn-danger status_admin"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                }else{
                    // $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                    $status_admin ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';

                }
                // $xxx = array();
                // $ex_user = explode(',',$field->nama_atasan);
                // foreach ($ex_user as $x) {
                //    $user_atasan = $this->db->get_where('users',['id' => $x])->row();
                //    $xxx[] = isset($user_atasan->nama) ? $user_atasan->nama : '';
                // }
                // $atasan1 = isset($xxx[0]) ? $xxx[0] :'';
                // $atasan2 = isset($xxx[1]) ? $xxx[1] :'';
                // $atasan3 = isset($xxx[2]) ? $xxx[2] :'';


                // if($field->status_permohonan_atasan == 'Approved'){
                if(count($nama_atasan_app) == 3){
                    $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '.implode(',',$nama_atasan_app).'</span><br>'.$field->tgl_status_admin;
                }else if($field->status_permohonan_atasan == 'Rejected'){
                    $status_atasan ='<button type="button" id="'.$field->unik.'" class="btn btn-danger status_atasan"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) .'</button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
                }else if($field->status_permohonan == 'Rejected'){
                    $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) . ' </span><br>';
                }else{
                    $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i> '.implode(',',$nama_atasan_app).'</span>';
                }

                $row = array();

                $row[] = $no;
                $row[] = $field->nama_pemohon ;
                $row[] = $permohonan ;
                $row[] = $field->tgl_permohonan;
                if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
                    $row[] = $status_admin;
                    $row[] = $status_atasan;
                }
                $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$field->unik'")->row_array();
                if ($total_permohonan['total'] == 3 && $field->status_permohonan != 'Done' && $level == 2) {
                    $row[] = '<a href="" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
                    <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Upload File bukti Transfer</h3>
                        </div>
                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                            <input type="hidden" name="unik" value="'.$field->unik.'">
                            <input type="hidden" name="status" value="upload_bukti_transfer">
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
                    if ($field->status_permohonan == 'Done') {
                        $color_upload = $field->bukti_bayar_user ? 'success' : 'warning' ;
                        $role_user = $this->session->userdata('level') == '3' ? '' : 'disabled';
                        $row[] = '<a href="" class="badge bg-'.$color_upload.'" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
                        <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3>Upload bukti pembayaran</h3>
                                        </div>
                                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                                            <input type="hidden" name="unik" value="'.$field->unik.'">
                                            <input type="hidden" name="status" value="upload_bukti_bayar">
                                            <div class="col-12">
                                                <label class="form-label w-100" for="modalAddCard">File bukti bayar</label>
                                                <input '.$role_user.' name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <label class="form-label w-100" for="modalAddCard">Sisa dana</label>
                                                    <span class="input-group-text">Rp.</span>
                                                    <input '.$role_user.' name="sisa_dana" id="input1" class="form-control" type="text" aria-describedby="modalAddCard2"  onkeyup="handle()"/>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                            <button '.$role_user.' type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                                            <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="col-12 ">
                                            <label class="form-label w-100" for="modalAddCard">File bukti Bayar :</label>
                                            <a download href="'.base_url().'upload/bukti_bayar/'.$field->bukti_bayar_user.'">'.$field->bukti_bayar_user.'</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }else{
                        $row[] = '';
                    }
                }
                $row[] = $status;
                $data[] = $row;

            }else if(strpos($field->check_admin_approval,$id_ririn) !== false  && $this->session->userdata('id_user') == $id_tata ) {
                if ($field->status_permohonan === 'Waiting') {
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
                    <a href="'.'detail/'.$field->unik.'" class="badge bg-primary invisible"><i class="bx bx-edit"></i></a>
                    ';
                }else if($field->status_permohonan == 'Approved'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                }else if($field->status_permohonan == 'Done'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                    // $status = '<span class="badge bg-success"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
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
                    $status_admin = '<button type="button" id="'.$field->unik.'" class="btn btn-danger status_admin"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                }else{
                    // $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                    $status_admin ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';

                }
                // $xxx = array();
                // $ex_user = explode(',',$field->nama_atasan);
                // foreach ($ex_user as $x) {
                //    $user_atasan = $this->db->get_where('users',['id' => $x])->row();
                //    $xxx[] = isset($user_atasan->nama) ? $user_atasan->nama : '';
                // }
                // $atasan1 = isset($xxx[0]) ? $xxx[0] :'';
                // $atasan2 = isset($xxx[1]) ? $xxx[1] :'';
                // $atasan3 = isset($xxx[2]) ? $xxx[2] :'';


                // if($field->status_permohonan_atasan == 'Approved'){
                if(count($nama_atasan_app) == 3){
                    $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '.implode(',',$nama_atasan_app).'</span><br>'.$field->tgl_status_admin;
                }else if($field->status_permohonan_atasan == 'Rejected'){
                    $status_atasan ='<button type="button" id="'.$field->unik.'" class="btn btn-danger status_atasan"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) .'</button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
                }else if($field->status_permohonan == 'Rejected'){
                    $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) . ' </span><br>';
                }else{
                    $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i> '.implode(',',$nama_atasan_app).'</span>';
                }

                $row = array();

                $row[] = $no;
                $row[] = $field->nama_pemohon ;
                $row[] = $permohonan ;
                $row[] = $field->tgl_permohonan;
                if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
                    $row[] = $status_admin;
                    $row[] = $status_atasan;
                }
                $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$field->unik'")->row_array();
                if ($total_permohonan['total'] == 3 && $field->status_permohonan != 'Done' && $level == 2) {
                    $row[] = '<a href="" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
                    <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Upload File bukti Transfer</h3>
                        </div>
                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                            <input type="hidden" name="unik" value="'.$field->unik.'">
                            <input type="hidden" name="status" value="upload_bukti_transfer">
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
                    if ($field->status_permohonan == 'Done') {
                        $color_upload = $field->bukti_bayar_user ? 'success' : 'warning' ;
                        $role_user = $this->session->userdata('level') == '3' ? '' : 'disabled';
                        $row[] = '<a href="" class="badge bg-'.$color_upload.'" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
                        <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3>Upload bukti pembayaran</h3>
                                        </div>
                                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                                            <input type="hidden" name="unik" value="'.$field->unik.'">
                                            <input type="hidden" name="status" value="upload_bukti_bayar">
                                            <div class="col-12">
                                                <label class="form-label w-100" for="modalAddCard">File bukti bayar</label>
                                                <input '.$role_user.' name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <label class="form-label w-100" for="modalAddCard">Sisa dana</label>
                                                    <span class="input-group-text">Rp.</span>
                                                    <input '.$role_user.' name="sisa_dana" id="input1" class="form-control" type="text" aria-describedby="modalAddCard2"  onkeyup="handle()"/>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                            <button '.$role_user.' type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                                            <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="col-12 ">
                                            <label class="form-label w-100" for="modalAddCard">File bukti Bayar :</label>
                                            <a download href="'.base_url().'upload/bukti_bayar/'.$field->bukti_bayar_user.'">'.$field->bukti_bayar_user.'</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }else{
                        $row[] = '';
                    }
                }
                $row[] = $status;
                $data[] = $row;
            }elseif (strpos($field->check_admin_approval,$id_tata) !== false  && $this->session->userdata('id_user') == $id_ivo) {
                if ($field->status_permohonan === 'Waiting') {
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
                    <a href="'.'detail/'.$field->unik.'" class="badge bg-primary invisible"><i class="bx bx-edit"></i></a>
                    ';
                }else if($field->status_permohonan == 'Approved'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                }else if($field->status_permohonan == 'Done'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                    // $status = '<span class="badge bg-success"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
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
                    $status_admin = '<button type="button" id="'.$field->unik.'" class="btn btn-danger status_admin"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                }else{
                    // $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                    $status_admin ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';

                }
                // $xxx = array();
                // $ex_user = explode(',',$field->nama_atasan);
                // foreach ($ex_user as $x) {
                //    $user_atasan = $this->db->get_where('users',['id' => $x])->row();
                //    $xxx[] = isset($user_atasan->nama) ? $user_atasan->nama : '';
                // }
                // $atasan1 = isset($xxx[0]) ? $xxx[0] :'';
                // $atasan2 = isset($xxx[1]) ? $xxx[1] :'';
                // $atasan3 = isset($xxx[2]) ? $xxx[2] :'';


                // if($field->status_permohonan_atasan == 'Approved'){
                if(count($nama_atasan_app) == 3){
                    $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '.implode(',',$nama_atasan_app).'</span><br>'.$field->tgl_status_admin;
                }else if($field->status_permohonan_atasan == 'Rejected'){
                    $status_atasan ='<button type="button" id="'.$field->unik.'" class="btn btn-danger status_atasan"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) .'</button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
                }else if($field->status_permohonan == 'Rejected'){
                    $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) . ' </span><br>';
                }else{
                    $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i> '.implode(',',$nama_atasan_app).'</span>';
                }

                $row = array();

                $row[] = $no;
                $row[] = $field->nama_pemohon ;
                $row[] = $permohonan ;
                $row[] = $field->tgl_permohonan;
                if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
                    $row[] = $status_admin;
                    $row[] = $status_atasan;
                }
                $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$field->unik'")->row_array();
                if ($total_permohonan['total'] == 3 && $field->status_permohonan != 'Done' && $level == 2) {
                    $row[] = '<a href="" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
                    <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Upload File bukti Transfer</h3>
                        </div>
                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                            <input type="hidden" name="unik" value="'.$field->unik.'">
                            <input type="hidden" name="status" value="upload_bukti_transfer">
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
                    if ($field->status_permohonan == 'Done') {
                        $color_upload = $field->bukti_bayar_user ? 'success' : 'warning' ;
                        $role_user = $this->session->userdata('level') == '3' ? '' : 'disabled';
                        $row[] = '<a href="" class="badge bg-'.$color_upload.'" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
                        <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3>Upload bukti pembayaran</h3>
                                        </div>
                                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                                            <input type="hidden" name="unik" value="'.$field->unik.'">
                                            <input type="hidden" name="status" value="upload_bukti_bayar">
                                            <div class="col-12">
                                                <label class="form-label w-100" for="modalAddCard">File bukti bayar</label>
                                                <input '.$role_user.' name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <label class="form-label w-100" for="modalAddCard">Sisa dana</label>
                                                    <span class="input-group-text">Rp.</span>
                                                    <input '.$role_user.' name="sisa_dana" id="input1" class="form-control" type="text" aria-describedby="modalAddCard2"  onkeyup="handle()"/>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                            <button '.$role_user.' type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                                            <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="col-12 ">
                                            <label class="form-label w-100" for="modalAddCard">File bukti Bayar :</label>
                                            <a download href="'.base_url().'upload/bukti_bayar/'.$field->bukti_bayar_user.'">'.$field->bukti_bayar_user.'</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }else{
                        $row[] = '';
                    }
                }
                $row[] = $status;
                $data[] = $row;
            }else if($this->session->userdata('level') == '2'){ //filter
                if ($field->status_permohonan === 'Waiting') {
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
                    <a href="'.'detail/'.$field->unik.'" class="badge bg-primary invisible"><i class="bx bx-edit"></i></a>
                    ';
                }else if($field->status_permohonan == 'Approved'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                }else if($field->status_permohonan == 'Done'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                    // $status = '<span class="badge bg-success"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
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
                    $status_admin = '<button type="button" id="'.$field->unik.'" class="btn btn-danger status_admin"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                }else{
                    // $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                    $status_admin ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';

                }


                // if($field->status_permohonan_atasan == 'Approved'){
                if(count($nama_atasan_app) == 3){
                    $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '.implode(',',$nama_atasan_app).'</span><br>'.$field->tgl_status_admin;
                }else if($field->status_permohonan_atasan == 'Rejected'){
                    $status_atasan ='<button type="button" id="'.$field->unik.'" class="btn btn-danger status_atasan"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) .'</button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
                }else if($field->status_permohonan == 'Rejected'){
                    $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) . ' </span><br>';
                }else{
                    $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i> '.implode(',',$nama_atasan_app).'</span>';
                }

                $row = array();

                $row[] = $no;
                $row[] = $field->nama_pemohon ;
                $row[] = $permohonan ;
                $row[] = $field->tgl_permohonan;
                if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
                    $row[] = $status_admin;
                    $row[] = $status_atasan;
                }
                $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$field->unik'")->row_array();
                if ($total_permohonan['total'] == 3 && $field->status_permohonan != 'Done' && $level == 2) {
                    $row[] = '<a href="" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i> <b>Bukti Transfer</b></a>
                    <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Upload File bukti Transfer</h3>
                        </div>
                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                            <input type="hidden" name="unik" value="'.$field->unik.'">
                            <input type="hidden" name="status" value="upload_bukti_transfer">
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
                    if ($field->status_permohonan == 'Done') {
                       if ($field->bukti_bayar_user == true) {
                        $row[] = '<span class="badge bg-success"><i class="bx bx-time-five"></i> Selesai</span>';
                       }else{
                            // $color_upload = $field->bukti_bayar_user ? 'success' : 'warning' ;
                            $role_user = $this->session->userdata('level') == '3' ? '' : 'disabled';
                            $row[] = '<a href="" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i> <b>Bukti Pembayaran</b></a>
                                <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                        <div class="modal-content p-3 p-md-5">
                                            <div class="modal-body">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                <div class="text-center mb-4">
                                                    <h3>Upload bukti pembayaran</h3>
                                                </div>
                                                <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                                                    <input type="hidden" name="unik" value="'.$field->unik.'">
                                                    <input type="hidden" name="status" value="upload_bukti_bayar">
                                                    <div class="col-12">
                                                        <label class="form-label w-100" for="modalAddCard">File bukti bayar</label>
                                                        <input '.$role_user.' name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <label class="form-label w-100" for="modalAddCard">Sisa dana</label>
                                                            <span class="input-group-text">Rp.</span>
                                                            <input '.$role_user.' name="sisa_dana" id="input1" class="form-control" type="text" aria-describedby="modalAddCard2"  onkeyup="handle()"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                    <button '.$role_user.' type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                                                    <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                    </div>
                                                </form>
                                                <hr>
                                                <div class="col-12 ">
                                                    <label class="form-label w-100" for="modalAddCard">File bukti Transfer :</label>
                                                    <a class="btn btn-primary" download href="'.base_url().'upload/bukti_transfer/'.$field->file_bukti_transfer.'">'.$field->file_bukti_transfer.'</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                       }
                    }else{
                        $row[] = '';
                    }
                }
                $row[] = $status;
                $data[] = $row;
            }elseif ($this->session->userdata('level') == '3') { //user
                if ($field->status_permohonan === 'Waiting') {
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
                    <a href="'.'detail/'.$field->unik.'" class="badge bg-primary invisible"><i class="bx bx-edit"></i></a>
                    ';
                }else if($field->status_permohonan == 'Approved'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                }else if($field->status_permohonan == 'Done'){
                    $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
                    // $status = '<span class="badge bg-success"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
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
                    $status_admin = '<button type="button" id="'.$field->unik.'" class="btn btn-danger status_admin"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                }else if($field->status_permohonan == 'Done'){
                    $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                }else{
                    // $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                    $status_admin ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';
                }


                // if($field->status_permohonan_atasan == 'Approved'){
                if(count($nama_atasan_app) == 3){
                    $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '.implode(',',$nama_atasan_app).'</span><br>'.$field->tgl_status_admin;
                }else if($field->status_permohonan_atasan == 'Rejected'){
                    $status_atasan ='<button type="button" id="'.$field->unik.'" class="btn btn-danger status_atasan"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) .'</button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
                }else if($field->status_permohonan == 'Rejected'){
                    $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) . ' </span><br>';
                }else{
                    $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i> '.implode(',',$nama_atasan_app).'</span>';
                }

                $row = array();

                $row[] = $no;
                $row[] = $field->nama_pemohon ;
                $row[] = $permohonan ;
                $row[] = $field->tgl_permohonan;
                if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
                    $row[] = $status_admin;
                    $row[] = $status_atasan;
                }
                $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$field->unik'")->row_array();
                if ($total_permohonan['total'] == 3 && $field->status_permohonan != 'Done' && $level == 2) {
                    $row[] = '<a href="" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i> <b>Bukti Transfer</b></a>
                    <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Upload File bukti Transfer</h3>
                        </div>
                        <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                            <input type="hidden" name="unik" value="'.$field->unik.'">
                            <input type="hidden" name="status" value="upload_bukti_transfer">
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
                    if ($field->status_permohonan == 'Done') {
                        if ($field->bukti_bayar_user == true) {
                            $row[] = '<span class="badge bg-success"><i class="bx bx-time-five"></i> Selesai</span>';
                        }else{
                                // $color_upload = $field->bukti_bayar_user ? 'success' : 'warning' ;
                            $role_user = $this->session->userdata('level') == '3' ? '' : 'disabled';
                            if ($field->sisa_dana == true) {
                                $sisa_dana = '<div class="col-12 ">
                                <h6>Sisa Dana : <b>Rp.'.number_format($field->sisa_dana,0,'.',',').'</b></h6>
                                </div>';
                            $bukti_bayar = ' <div class="col-12 ">
                                <h6>File bukti Bayar :</h6>
                                <a class="btn btn-warning" download href="'.base_url().'upload/bukti_bayar/'.$field->bukti_bayar_user.'">'.$field->bukti_bayar_user.' <i class="bx bx-download"></i></a>
                                </div>';
                            }else{
                                $bukti_bayar = '';
                                $sisa_dana = '';
                            }
                            $row[] = '<a href="" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i> <b>Bukti Pembayaran</b></a>
                            <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                                    <div class="modal-content p-3 p-md-5">
                                        <div class="modal-body">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="text-center mb-4">
                                                <h3>Upload bukti pembayaran</h3>
                                            </div>
                                            <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
                                                <input type="hidden" name="unik" value="'.$field->unik.'">
                                                <input type="hidden" name="status" value="upload_bukti_bayar">
                                                <div class="col-12">
                                                    <label class="form-label w-100" for="modalAddCard">File bukti bayar</label>
                                                    <input '.$role_user.' name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
                                                </div>
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <label class="form-label w-100" for="modalAddCard">Sisa dana</label>
                                                        <span class="input-group-text">Rp.</span>
                                                        <input '.$role_user.' name="sisa_dana" id="input1" class="form-control" type="text" aria-describedby="modalAddCard2"  onkeyup="handle()"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center">
                                                <button '.$role_user.' type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
                                                <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                </div>
                                            </form>
                                            <hr>
                                            <div class="col-12 ">
                                                <h6>File bukti Transfer : </h6>
                                                <a class="btn btn-primary" download href="'.base_url().'upload/bukti_transfer/'.$field->file_bukti_transfer.'">'.$field->file_bukti_transfer.' <i class="bx bx-download"></i></a><br>
                                                '.$field->tgl_transfer.'
                                            </div> <br>
                                           '.$bukti_bayar.'
                                            <br>
                                        '.$sisa_dana.'
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    }else{
                        if ($total_permohonan['total'] == 3) {
                            $row[] = '<span class="badge bg-warning"><i class="bx bx-time-five"></i> Menunggu Di Transfer</span>';
                        }else{
                            $row[] = '<span class="badge bg-dark"><i class="bx bx-time-five"></i> Menunggu Di Approve</span>';
                        }
                    }
                }
                $row[] = $status;
                $data[] = $row;
            }

            // else{
            //     if ($field->status_permohonan === 'Waiting') {
            //         $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
            //         <a href="'.'detail/'.$field->unik.'" class="badge bg-primary invisible"><i class="bx bx-edit"></i></a>
            //         ';
            //     }else if($field->status_permohonan == 'Approved'){
            //         $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
            //     }else if($field->status_permohonan == 'Done'){
            //         $status = '<a href="'.'detail/'.$field->unik.'" class="badge bg-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
            //         // $status = '<span class="badge bg-success"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
            //     }else{
            //         $status = '';
            //     }

            //     if ($field->no_permohonan > 0) {
            //     $permohonan = '<span class="badge bg-primary">'.$field->no_permohonan.'</span>';
            //     }else{
            //     $permohonan='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';
            //     }

            //     if($field->status_permohonan == 'Approved'){
            //         $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
            //     }else if($field->status_permohonan == 'Rejected'){
            //         $status_admin = '<button type="button" id="'.$field->unik.'" class="btn btn-danger status_admin"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
            //     }else{
            //         // $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
            //         $status_admin ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';

            //     }
            //     // $xxx = array();
            //     // $ex_user = explode(',',$field->nama_atasan);
            //     // foreach ($ex_user as $x) {
            //     //    $user_atasan = $this->db->get_where('users',['id' => $x])->row();
            //     //    $xxx[] = isset($user_atasan->nama) ? $user_atasan->nama : '';
            //     // }
            //     // $atasan1 = isset($xxx[0]) ? $xxx[0] :'';
            //     // $atasan2 = isset($xxx[1]) ? $xxx[1] :'';
            //     // $atasan3 = isset($xxx[2]) ? $xxx[2] :'';


            //     // if($field->status_permohonan_atasan == 'Approved'){
            //     if(count($nama_atasan_app) == 3){
            //         $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '.implode(',',$nama_atasan_app).'</span><br>'.$field->tgl_status_admin;
            //     }else if($field->status_permohonan_atasan == 'Rejected'){
            //         $status_atasan ='<button type="button" id="'.$field->unik.'" class="btn btn-danger status_atasan"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) .'</button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
            //     }else if($field->status_permohonan == 'Rejected'){
            //         $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. implode(',',$nama_atasan_app) . ' </span><br>';
            //     }else{
            //         $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i> '.implode(',',$nama_atasan_app).'</span>';
            //     }

            //     $row = array();

            //     $row[] = $no;
            //     $row[] = $field->nama_pemohon ;
            //     $row[] = $permohonan ;
            //     $row[] = $field->tgl_permohonan;
            //     if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
            //         $row[] = $status_admin;
            //         $row[] = $status_atasan;
            //     }
            //     $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$field->unik'")->row_array();
            //     if ($total_permohonan['total'] == 3 && $field->status_permohonan != 'Done' && $level == 2) {
            //         $row[] = '<a href="" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
            //         <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
            //         <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
            //         <div class="modal-content p-3 p-md-5">
            //             <div class="modal-body">
            //             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            //             <div class="text-center mb-4">
            //                 <h3>Upload File bukti Transfer</h3>
            //             </div>
            //             <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
            //                 <input type="hidden" name="unik" value="'.$field->unik.'">
            //                 <input type="hidden" name="status" value="upload_bukti_transfer">
            //                 <div class="col-12">
            //                 <label class="form-label w-100" for="modalAddCard">File</label>
            //                     <input name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
            //                 </div>

            //                 <div class="col-12 text-center">
            //                 <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
            //                 <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            //                 </div>
            //             </form>
            //             </div>
            //         </div>
            //         </div>
            //     </div>
            //         ';
            //     }else{
            //         if ($field->status_permohonan == 'Done') {
            //             $color_upload = $field->bukti_bayar_user ? 'success' : 'warning' ;
            //             $role_user = $this->session->userdata('level') == '3' ? '' : 'disabled';
            //             $row[] = '<a href="" class="badge bg-'.$color_upload.'" data-bs-toggle="modal" data-bs-target="#modalFile'.$field->unik.'" ><i class="bx bx-file"></i></a>
            //             <div class="modal fade" id="modalFile'.$field->unik.'" tabindex="-1" aria-hidden="true">
            //                 <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
            //                     <div class="modal-content p-3 p-md-5">
            //                         <div class="modal-body">
            //                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            //                             <div class="text-center mb-4">
            //                                 <h3>Upload bukti pembayaran</h3>
            //                             </div>
            //                             <form action="status" method="POST" class="row g-3" enctype="multipart/form-data">
            //                                 <input type="hidden" name="unik" value="'.$field->unik.'">
            //                                 <input type="hidden" name="status" value="upload_bukti_bayar">
            //                                 <div class="col-12">
            //                                     <label class="form-label w-100" for="modalAddCard">File bukti bayar</label>
            //                                     <input '.$role_user.' name="file_bayar" class="form-control" type="file" aria-describedby="modalAddCard2" />
            //                                 </div>
            //                                 <div class="col-12">
            //                                     <div class="input-group">
            //                                         <label class="form-label w-100" for="modalAddCard">Sisa dana</label>
            //                                         <span class="input-group-text">Rp.</span>
            //                                         <input '.$role_user.' name="sisa_dana" id="input1" class="form-control" type="text" aria-describedby="modalAddCard2"  onkeyup="handle()"/>
            //                                     </div>
            //                                 </div>
            //                                 <div class="col-12 text-center">
            //                                 <button '.$role_user.' type="submit" class="btn btn-primary me-sm-3 me-1 mt-3">Submit</button>
            //                                 <button type="reset" class="btn btn-label-secondary btn-reset mt-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            //                                 </div>
            //                             </form>
            //                             <hr>
            //                             <div class="col-12 ">
            //                                 <label class="form-label w-100" for="modalAddCard">File bukti Bayar :</label>
            //                                 <a download href="'.base_url().'upload/bukti_bayar/'.$field->bukti_bayar_user.'">'.$field->bukti_bayar_user.'</a>
            //                             </div>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>
            //             ';
            //         }else{
            //             $row[] = '';
            //         }
            //     }
            //     $row[] = $status;
            //     $data[] = $row;
            // }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->M_Permohonan->count_all(),
            "recordsFiltered" => $this->M_Permohonan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    function strpos_arr($haystack, $needle) {
        if( !is_array($needle) ) $needle = array($needle);
        $min = false;
        foreach($needle as $what)
            if( ($pos = strpos($haystack, $what)) !== false && ($min == false || $pos < $min) )
                $min = $pos;
        return $min;
    }

    function get_list_tarcking()
    {
        $list = $this->db->get('tb_permohonan')->result();
        $data = array();
        $no = $this->input->post('start');
        $level = $this->session->userdata('level');
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
                $status_admin = '<button type="button" id="'.$field->unik.'" class="btn btn-danger status_admin"> <i class="bx bx-x-circle"></i> '. $field->nama_admin . ' </button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
            }else{
                // $status_admin ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_admin));
                $status_admin ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i></span>';

            }
            $xxx = array();
            $ex_user = explode(',',$field->nama_atasan);
            foreach ($ex_user as $x) {
               $user_atasan = $this->db->get_where('users',['id' => $x])->row();
               $xxx[] = isset($user_atasan->nama) ? $user_atasan->nama : '';
            }
            $atasan1 = isset($xxx[0]) ? $xxx[0] :'';
            $atasan2 = isset($xxx[1]) ? $xxx[1] :'';
            $atasan3 = isset($xxx[2]) ? $xxx[2] :'';

            $tb_atasan = $this->db->get_where('tb_atasan',['unik' => $field->unik])->result();
            $nama_atasan_app = array();
            foreach ($tb_atasan as $x) {
                $nama_atasan_app[] = $x->nama;
            }
            // if($field->status_permohonan_atasan == 'Approved'){
            if(count($nama_atasan_app) == 3){
                $status_atasan ='<span class="badge bg-primary"> <i class="bx bx-check"></i> '.implode(',',$nama_atasan_app).'</span><br>'.$field->tgl_status_admin;
            }else if($field->status_permohonan_atasan == 'Rejected'){
                $status_atasan ='<button type="button" id="'.$field->unik.'" class="btn btn-danger status_atasan"> <i class="bx bx-x-circle"></i> '. $field->nama_atasan .'</button><br>'.date('Y M d H:i:s',strtotime($field->tgl_status_atasan));
            }else if($field->status_permohonan == 'Rejected'){
                $status_atasan = '<span class="badge bg-danger"> <i class="bx bx-x-circle"></i> '. $field->nama_atasan . ' </span><br>';
            }else{
                $status_atasan ='<span class="badge bg-warning"> <i class="bx bx-time-five"></i> '.implode(',',$nama_atasan_app).'</span>';
            }

            $row = array();

			$row[] = $no;
			$row[] = $field->nama_pemohon;
			$row[] = $permohonan;
			$row[] = $field->tgl_permohonan;
            if($this->session->userdata('filterPermohonan') == 'permohonan_baru' || $this->session->userdata('filterPermohonan') == 'data_lama'){
                $row[] = $status_admin;
                $row[] = $status_atasan;
            }
            $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$field->unik'")->row_array();
            if ($total_permohonan['total'] == 3 && $field->status_permohonan != 'Done' && $level == 2) {
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
            "recordsTotal" => $this->M_Permohonan->count_all(),
            "recordsFiltered" => $this->M_Permohonan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    function detail()
    {
        $unik = $this->uri->segment(3);
        $this->db->select('*,b.file as file_detail');
        $this->db->where('a.unik',$unik);
        $this->db->join('tb_permohonan as a','a.unik=b.unik');
        $db_detail = $this->db->get('tb_permohonan_detail as b')->result();
        $total = $this->db->query("SELECT SUM(nominal) as nominal from tb_permohonan_detail where unik='$unik'")->row_array();
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "Detail Permohonan Permohonan",
            'titlePage' => 'Dashboard Admin Embun Pagi',
            'data' => $db_detail,
            'total_nominal' => $total
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/list',$data);
		$this->load->view('body/footer');
    }
    function status()
    {
        $id_user = $this->session->userdata('id_user');
        //approved atau rejected untuk atasan
        if ($this->input->post('status') == 'Rejected' && $this->input->post('atasan') == 'permohonan_baru') {
            $unik = $this->input->post('id');
            $this->db->where('unik',$unik);
            // $this->db->set('nama_atasan',$this->session->userdata('nama'));
            $this->db->set('status_permohonan','Rejected');
            // $this->db->set('note_atasan',$this->input->post('keterangan'));
            // $this->db->set('tgl_status_atasan',date('Y-m-d H:i:s'));
            $this->db->update('tb_permohonan');

            //insert table atasan
            $atasan = [
                "id_user" => $this->session->userdata('id_user'),
                "nama" => $this->session->userdata('nama'),
                "unik" => $this->input->post('id'),
                "status" => $this->input->post('status'),
                "keterangan" => $this->input->post('keterangan'),
                // "tgl_status_atasan" => date('Y-m-d H:i:s')
            ];
            $this->db->insert('tb_atasan',$atasan);

            
            echo json_encode('Success');
        }else if($this->uri->segment(5) == 'confirm_atasan'){
            $unik = $this->uri->segment(3);
            $status = $this->uri->segment(4);
            $this->db->select_max('no_permohonan');
            $this->db->where('tahun',date('Y'));
            $no = $this->db->get('tb_permohonan')->result_array();

           
            $cek_permohonan = $this->db->get_where('tb_permohonan',['unik' => $unik])->row();
            if ($cek_permohonan->no_permohonan == null) {
                $no_pemohon = $no[0]['no_permohonan']+1;
                $update = [
                    "no_permohonan" => $no_pemohon,
                    // "nama_admin" => $this->session->userdata('nama'),
                    // "status_permohonan_atasan" => $status,
                    // "tgl_status_atasan" => date('Y-m-d H:i:s')
                ];
                $this->db->where('unik',$unik);
                $this->db->update('tb_permohonan',$update);
            }
            // else{
            //     $update = [
                    // "no_permohonan" => $no_pemohon,
                    // "nama_atasan" => $this->session->userdata('nama'),
                    // "status_permohonan_atasan" => $status,
                    // "tgl_status_atasan" => date('Y-m-d H:i:s')
            //     ];
            // }


            //kolom nama_atasan,status_permohonan_atasan,note_atasan,tgl_status_atasan tidak terpakai
            //insert table atasan
            $id_user = $this->session->userdata('id_user');
            $sql = "SELECT check_admin_approval FROM tb_permohonan WHERE unik=$unik";
            $query = $this->db->query($sql);
            $result = $query->row();
            $kalimat = $result->check_admin_approval;
            if (preg_match("/$id_user/i", $kalimat)){}else{
                if ($kalimat == null) {
                    $kalimat1 = $id_user;
                    $data_update1	= array(
                        'check_admin_approval'	=> $kalimat1
                    );
                    $this->db->where('unik', $unik);
                    $this->db->update('tb_permohonan', $data_update1);
                }else{
                    $kalimat1 = $kalimat . ',' . $id_user;
                    $data_update1	= array(
                        'check_admin_approval'	=> $kalimat1
                    );
                    $this->db->where('unik', $unik);
                    $this->db->update('tb_permohonan', $data_update1);
                }
            }
            $atasan = [
                "id_user" => $this->session->userdata('id_user'),
                "nama" => $this->session->userdata('nama'),
                "unik" => $unik,
                "status" => $status
            ];
            $this->db->insert('tb_atasan',$atasan);
      
            //send notif whatsapp
            $get_user = $this->db->query("SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='$unik'")->row_array();
            $detail_permohonan = $this->db->get_where('tb_permohonan_detail',['unik' => $unik])->result();
            if (count($detail_permohonan) >= 2) {
                $pisah = "\n===================\n";
            }else{
                $pisah = "\n";
            }
            $isi_permohonan_x = array();
            foreach ($detail_permohonan as $x) {
                $url_link =  "http://localhost/embun_pagi_pengajuan/upload/file/" . $unik.$x->file;
                $isi_permohonan_x[] = "Isi permohonan : *".$x->isi_permohonan."*\nNominal : *" .'Rp.'.number_format($x->nominal,0,'.','.'). "*\nLink file : $url_link $pisah";
            }
            $nama = $get_user['nama'];
            $no_pemohon_2 = $get_user['no_permohonan'];
            $nama_admin_2 = $get_user['nama_admin'];
            // $bukti_transfer = "http://localhost/embun_pagi_pengajuan/upload/bukti_transfer/". $get_user['file_bukti_transfer'];
            $get_atasan = $this->db->get_where('tb_atasan',['unik' => $unik])->result();
            if (count($get_atasan) >= 2) {
                $pisah_atasan = "\n\n";
            }else{
                $pisah_atasan = "\n\n";
            }
            $isi_atasan = array();
            $noo = 1;
            foreach ($get_atasan as $x) {
                $isi_atasan[] = "Disetujui Admin ".$noo++." : *".$x->nama."*\nTanggal Disetujui : *".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s').'*'.$pisah_atasan."";
            }
            $tgl_permohonan = $this->tgl_indo(date('Y-m-d',strtotime($get_user['tgl_permohonan'])));
            $tgl_permohonan_jam = date('H:i:s',strtotime($get_user['tgl_permohonan']));
            $msg = "*[Notifkasi Admin Approved]*\n\nPermohonan : *$nama*\nTanggal Permohonan : *". $tgl_permohonan .' '. $tgl_permohonan_jam."*\nNomor Permohonan : *".$no_pemohon_2."*\nDisetujui admin filter : *".$nama_admin_2."*\n\n".implode('',$isi_atasan)."*[List Permohonan]*\n". implode('',$isi_permohonan_x)."\nSilahkan cek di https://pengeluaran.embunpagi.sch.id/";

            //notif user
            $get_user = $this->db->query('SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='.$unik.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_user['telp']);
            
            //notif confirm admin
            $cek_atasan = $this->db->query("SELECT COUNT(*) as total FROM tb_atasan WHERE unik='$unik'")->row_array();
            if ($cek_atasan['total'] == 1) { //send ke tata
                $get_admin = $this->db->query('SELECT * FROM users where id="13"')->row_array();
                $this->api_whatsapp->wa_notif($msg,$get_admin['telp']);
            }elseif ($cek_atasan['total'] == 2) { //send ke ivo
                $get_admin = $this->db->query('SELECT * FROM users where id="20"')->row_array();
                $this->api_whatsapp->wa_notif($msg,$get_admin['telp']);
            }
            // elseif ($cek_atasan['total'] == 3) { //send ke ivo
            //     // $get_admin = $this->db->query('SELECT * FROM users where id=""')->row_array();
            //     // $this->api_whatsapp->wa_notif($msg,$get_admin['telp']);
            // }
            //end
            $total_permohonan = $this->db->query("SELECT count(id_atasan) as total FROM tb_atasan where unik='$unik'")->row_array();
            if ($total_permohonan['total'] == 3) {
                $this->db->where('unik',$unik);
                $this->db->set('status_atasan','Selesai');
                $this->db->update('tb_permohonan');
            }
            redirect('permohonan/list2');
        }

        //approved atau rejected untuk admin
        if ($this->input->post('status') == 'Rejected' && $this->input->post('atasan') == 'waiting') {
            $unik = $this->input->post('id');
            $this->db->where('unik',$unik);
            $this->db->set('nama_admin',$this->session->userdata('nama'));
            $this->db->set('status_permohonan','Rejected');
            $this->db->set('note_status_permohonan',$this->input->post('keterangan'));
            $this->db->set('tgl_status_admin',date('Y-m-d H:i:s'));
            $this->db->update('tb_permohonan');

            //send notif whatsapp
            $get_user = $this->db->query("SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='$unik'")->row_array();
            $detail_permohonan = $this->db->get_where('tb_permohonan_detail',['unik' => $unik])->result();
            if (count($detail_permohonan) >= 2) {
                $pisah = "\n===================\n";
            }else{
                $pisah = "\n";
            }
            $isi_permohonan_x = array();
            foreach ($detail_permohonan as $x) {
                $url_link =  "http://localhost/embun_pagi_pengajuan/upload/file/" . $unik.$x->file;
                $isi_permohonan_x[] = "Isi permohonan : *".$x->isi_permohonan."*\nNominal : *" .'Rp.'.number_format($x->nominal,0,'.','.'). "*\nLink file : $url_link $pisah";
            }
            $nama = $get_user['nama'];
            // $bukti_transfer = "http://localhost/embun_pagi_pengajuan/upload/bukti_transfer/". $get_user['file_bukti_transfer'];
            $tgl_permohonan = $this->tgl_indo(date('Y-m-d',strtotime($get_user['tgl_permohonan'])));
            $tgl_permohonan_jam = date('H:i:s',strtotime($get_user['tgl_permohonan']));
            $msg = "*[Notifkasi Admin Filter]*\n\nPermohonan : *$nama*\nTanggal Permohonan : *". $tgl_permohonan .' '. $tgl_permohonan_jam."*\n\nStatus : Ditolak oleh *".$this->session->userdata('nama')."*\nAlasan : ".$this->input->post('keterangan')."\nTanggal : ".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s')."\n\n*[List Permohonan]*\n". implode('',$isi_permohonan_x)."\nSilahkan cek di https://pengeluaran.embunpagi.sch.id/";

            //notif user
            $get_user = $this->db->query('SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='.$unik.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_user['telp']);
            //notif confirm admin
            $get_admin = $this->db->query('SELECT * FROM users where id='.$id_user.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_admin['telp']);
            //end

            echo json_encode('Success');
            // redirect('permohonan/list');
            
        }else if($this->uri->segment(5) == 'confirm_admin'){
            $unik = $this->uri->segment(3);
            $status = $this->uri->segment(4);
            // $this->db->select_max('no_permohonan');
            // $no = $this->db->get('tb_permohonan')->row_array();
            // $update = [
            //     // "no_permohonan" => $no['no_permohonan']+1,
            //     "nama_admin" => $this->session->userdata('nama'),
            //     "status_permohonan" => $status,
            //     "tgl_status_admin" => date('Y-m-d H:i:s')
            // ];

            $this->db->set('nama_admin',$this->session->userdata('nama'));
            $this->db->set('status_permohonan',$status);
            $this->db->set('tgl_status_admin',date('Y-m-d H:i:s'));
            $this->db->where('unik',$unik);
            $this->db->update('tb_permohonan');

            //send notif whatsapp
            $get_user = $this->db->query("SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='$unik'")->row_array();
            $detail_permohonan = $this->db->get_where('tb_permohonan_detail',['unik' => $unik])->result();
            if (count($detail_permohonan) >= 2) {
                $pisah = "\n===================\n";
            }else{
                $pisah = "\n";
            }
            $isi_permohonan_x = array();
            foreach ($detail_permohonan as $x) {
                $url_link =  "http://localhost/embun_pagi_pengajuan/upload/file/" . $unik.$x->file;
                $isi_permohonan_x[] = "Isi permohonan : *".$x->isi_permohonan."*\nNominal : *" .'Rp.'.number_format($x->nominal,0,'.','.'). "*\nLink file : $url_link $pisah";
            }
            $nama = $get_user['nama'];
            // $bukti_transfer = "http://localhost/embun_pagi_pengajuan/upload/bukti_transfer/". $get_user['file_bukti_transfer'];
            $tgl_permohonan = $this->tgl_indo(date('Y-m-d',strtotime($get_user['tgl_permohonan'])));
            $tgl_permohonan_jam = date('H:i:s',strtotime($get_user['tgl_permohonan']));
            $msg = "*[Notifkasi Admin Filter]*\n\nPermohonan : *$nama*\nTanggal Permohonan : *". $tgl_permohonan .' '. $tgl_permohonan_jam."*\n\nStatus : Disetujui oleh *".$this->session->userdata('nama')."*\nTanggal Disetujui : ".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s')."\n\n*[List Permohonan]*\n". implode('',$isi_permohonan_x)."\nSilahkan cek di https://pengeluaran.embunpagi.sch.id/";

            //notif user
            $get_user = $this->db->query('SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='.$unik.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_user['telp']);
            //notif confirm admin
            $get_admin = $this->db->query('SELECT * FROM users where id='.$id_user.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_admin['telp']);

            //admin approve 1
            $get_admin1 = $this->db->query('SELECT * FROM users where id='.$this->id_ririn.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_admin1['telp']);
            //end

            redirect('permohonan/list2');
        }

        //upload file bayar
        if ($this->input->post('status') == 'upload_bukti_transfer') {
            $target_dir = "upload/bukti_transfer/";
            $file = $_FILES['file_bayar']['name'];
            $path = pathinfo($file);
            $filename = time().'_'.$path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES['file_bayar']['tmp_name'];
            $path_filename_ext = $target_dir.$filename.".".$ext;
            move_uploaded_file($temp_name,$path_filename_ext);

            $unik = $this->input->post('unik');
            $this->db->where('unik',$unik);
            $this->db->set('status_permohonan','Done');
            $this->db->set('status_bayar','Sudah Ditransfer');
            $this->db->set('file_bukti_transfer',$filename.'.'.$ext);
            $this->db->set('tgl_transfer',date('Y-m-d H:i:s'));
            $this->db->update('tb_permohonan');

            //send notif whatsapp
            $get_user = $this->db->query("SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='$unik'")->row_array();
            $detail_permohonan = $this->db->get_where('tb_permohonan_detail',['unik' => $unik])->result();
            if (count($detail_permohonan) >= 2) {
                $pisah = "\n===================\n";
            }else{
                $pisah = "\n";
            }
            $isi_permohonan_x = array();
            foreach ($detail_permohonan as $x) {
                $url_link =  "http://localhost/embun_pagi_pengajuan/upload/file/" . $unik.$x->file;
                $isi_permohonan_x[] = "Isi permohonan : *".$x->isi_permohonan."*\nNominal : *" .'Rp.'.number_format($x->nominal,0,'.','.'). "*\nLink file : $url_link $pisah";
            }

            $get_atasan = $this->db->get_where('tb_atasan',['unik' => $unik])->result();
            if (count($get_atasan) >= 2) {
                $pisah_atasan = "\n\n";
            }else{
                $pisah_atasan = "\n\n";
            }
            $nama_admin_2 = $get_user['nama_admin'];

            $isi_atasan = array();
            $noo = 1;
            foreach ($get_atasan as $x) {
                $isi_atasan[] = "Disetujui Admin ".$noo++." : *".$x->nama."*\nTanggal Disetujui : *".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s').'*'.$pisah_atasan."";
            }
            $nama = $get_user['nama'];
            $bukti_transfer = "http://localhost/embun_pagi_pengajuan/upload/bukti_transfer/". $get_user['file_bukti_transfer'];
            $tgl_permohonan = $this->tgl_indo(date('Y-m-d',strtotime($get_user['tgl_permohonan'])));
            $tgl_permohonan_jam = date('H:i:s',strtotime($get_user['tgl_permohonan']));
            $msg = "*[Notifkasi Upload Transfer]*\n\nPermohonan : *$nama*\nNomor Permohonan : *".$get_user['no_permohonan']."*\nTanggal Permohonan : *". $tgl_permohonan .' '. $tgl_permohonan_jam."*\nDisetujui admin filter : *".$nama_admin_2."*\n\n".implode($isi_atasan)."Status : *Bukti transfer berhasil diupload*\nTanggal Upload Transfer : *".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s')."*\nLink bukti transfer : $bukti_transfer \n\n*[List Permohonan]*\n". implode('',$isi_permohonan_x)."\nSilahkan cek di https://pengeluaran.embunpagi.sch.id/";

            //notif user
            $get_user = $this->db->query('SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='.$unik.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_user['telp']);
            //notif confirm admin
            $get_admin = $this->db->query('SELECT * FROM users where id='.$id_user.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_admin['telp']);
            //end

            $this->session->set_flashdata('msg','<div class="alert alert-primary">File bukti Petty cash / transfer berhasil di upload</div>');
            redirect('permohonan/list2');
        }elseif ($this->input->post('status') == 'upload_bukti_bayar') {
            $unik = $this->input->post('unik');
            $target_dir = "upload/bukti_bayar/";
            $file = $_FILES['file_bayar']['name'];
            $path = pathinfo($file);
            $filename = time().'_'.$path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES['file_bayar']['tmp_name'];
            $path_filename_ext = $target_dir.$filename.".".$ext;
            move_uploaded_file($temp_name,$path_filename_ext);
            $sisa = $this->remove_special($this->input->post('sisa_dana'));
            $this->db->where('unik',$unik);
            $this->db->set('bukti_bayar_user',$filename.'.'.$ext);
            $this->db->set('tgl_bayar_user',date('Y-m-d H:i:s'));
            $this->db->set('sisa_dana',$sisa);
            $this->db->update('tb_permohonan');

            //send notif whatsapp
            $get_user = $this->db->query("SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='$unik'")->row_array();
            $detail_permohonan = $this->db->get_where('tb_permohonan_detail',['unik' => $unik])->result();
            if (count($detail_permohonan) >= 2) {
                $pisah = "\n===================\n";
            }else{
                $pisah = "\n";
            }
            $isi_permohonan_x = array();
            foreach ($detail_permohonan as $x) {
                $url_link =  "http://localhost/embun_pagi_pengajuan/upload/file/" . $unik.$x->file;
                $isi_permohonan_x[] = "Isi permohonan : *".$x->isi_permohonan."*\nNominal : *" .'Rp.'.number_format($x->nominal,0,'.','.'). "*\nLink file : $url_link $pisah";
            }
            $nama = $get_user['nama'];
            $bukti_transfer = "http://localhost/embun_pagi_pengajuan/upload/bukti_bayar/". $get_user['bukti_bayar_user'];
            $tgl_permohonan = $this->tgl_indo(date('Y-m-d',strtotime($get_user['tgl_permohonan'])));
            $tgl_permohonan_jam = date('H:i:s',strtotime($get_user['tgl_permohonan']));
            $msg = "*[Notifkasi Upload Bayar]*\n\nPermohonan : *$nama*\nNomor Permohonan : *".$get_user['no_permohonan']."*\nTanggal Permohonan : *". $tgl_permohonan .' '. $tgl_permohonan_jam."*\n\nStatus : *Bukti bayar berhasil diupload*\nTanggal Upload bayar : *".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s')."*\nLink bukti bayar : $bukti_transfer \n\n*[List Permohonan]*\n". implode('',$isi_permohonan_x)."\nSilahkan cek di https://pengeluaran.embunpagi.sch.id/";

            //send notif whatsapp
            $get_user = $this->db->query("SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='$unik'")->row_array();
            $detail_permohonan = $this->db->get_where('tb_permohonan_detail',['unik' => $unik])->result();
            if (count($detail_permohonan) >= 2) {
                $pisah = "\n===================\n";
            }else{
                $pisah = "\n";
            }
            $isi_permohonan_x = array();
            foreach ($detail_permohonan as $x) {
                $url_link =  "http://localhost/embun_pagi_pengajuan/upload/file/" . $unik.$x->file;
                $isi_permohonan_x[] = "Isi permohonan : *".$x->isi_permohonan."*\nNominal : *" .'Rp.'.number_format($x->nominal,0,'.','.'). "*\nLink file : $url_link $pisah";
            }

            $get_atasan = $this->db->get_where('tb_atasan',['unik' => $unik])->result();
            if (count($get_atasan) >= 2) {
                $pisah_atasan = "\n\n";
            }else{
                $pisah_atasan = "\n\n";
            }
            $nama_admin_2 = $get_user['nama_admin'];

            $isi_atasan = array();
            $noo = 1;
            foreach ($get_atasan as $x) {
                $isi_atasan[] = "Disetujui Admin ".$noo++." : *".$x->nama."*\nTanggal Disetujui : *".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s').'*'.$pisah_atasan."";
            }
            $nama = $get_user['nama'];
            $bukti_transfer = "http://localhost/embun_pagi_pengajuan/upload/bukti_transfer/". $get_user['file_bukti_transfer'];
            $bukti_bayar = "http://localhost/embun_pagi_pengajuan/upload/bukti_bayar/". $get_user['bukti_bayar_user'];
            $tgl_permohonan = $this->tgl_indo(date('Y-m-d',strtotime($get_user['tgl_permohonan'])));
            $tgl_permohonan_jam = date('H:i:s',strtotime($get_user['tgl_permohonan']));
            if ($this->input->post('sisa_dana') == true) {
               $sisa_dana2 = "Sisa dana : *Rp.".$this->input->post('sisa_dana')."*";
            }else{
                $sisa_dana2 = "";
            }
            $status_bukti_bayar = "Status : *Bukti bayar berhasil diupload*\nTanggal Upload bayar : *".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s')."*\n$sisa_dana2\nLink bukti transfer : $bukti_bayar \n\n";
            $msg = "*[Notifkasi Upload Bayar]*\n\nPermohonan : *$nama*\nNomor Permohonan : *".$get_user['no_permohonan']."*\nTanggal Permohonan : *". $tgl_permohonan .' '. $tgl_permohonan_jam."*\nDisetujui admin filter : *".$nama_admin_2."*\n\n".implode($isi_atasan)."Status : *Bukti transfer berhasil diupload*\nTanggal Upload Transfer : *".$this->tgl_indo(date('Y-m-d')).' '.date('H:i:s')."*\nLink bukti transfer : $bukti_transfer \n\n$status_bukti_bayar*[List Permohonan]*\n". implode('',$isi_permohonan_x)."\nSTATUS PERMOHONAN : *SELESAI*\nSilahkan cek di https://pengeluaran.embunpagi.sch.id/";

            //notif user
            $get_user = $this->db->query('SELECT * FROM tb_permohonan as a left join users as b on(a.id_user=b.id) where a.unik='.$unik.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_user['telp']);
            //notif confirm admin
            $get_admin = $this->db->query('SELECT * FROM users where id='.$id_user.'')->row_array();
            $this->api_whatsapp->wa_notif($msg,$get_admin['telp']);
            //end

            $this->session->set_flashdata('msg','<div class="alert alert-primary">File bukti bayar berhasil di upload</div>');
            redirect('permohonan/list2');
        }
    }
    function fetch_permohonan()
    {
        $tgl_sampel_diterima = date('d-m-Y H:i:s');
        $data['detail_permohonan'] = $this->M_Permohonan->get_detail_permohonan($this->input->post('permohonan_id'));
        // $data['cek_pembayaran'] = $this->Mpermohonan->cek_pembayaran($this->input->post('sampel_id'));
        // $data['kaji_sampel'] = $this->Mpermohonan->get_kajisampel($this->input->post('sampel_id'));
        // $data['sts'] = $this->Mpermohonan->st_permohonan($this->input->post('sampel_id'));
        // $data['tgl_sampel_diterima'] = ($data['sts']['tgl_sampel_diterima'] != '0000-00-00 00:00:00') ? dmyhis($data['sts']['tgl_sampel_diterima']) : $tgl_sampel_diterima;
        $this->load->view('body/modal_permohonan', $data);
    }
    function permohonan_info()
    {
        $unik = $this->input->post('id');
        $this->db->where('unik',$unik);
        $data = $this->db->get('tb_permohonan')->row_array();
        echo json_encode($data);
    }
    public function logout() {
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('level');
        redirect('auth');
    }
}
