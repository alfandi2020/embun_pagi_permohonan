<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Permohonan'));
        date_default_timezone_set("Asia/Jakarta");

    }

    public function index()
	{
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "Tambah Permohonan",
            'titlePage' => 'Dashboard Admin Embun Pagi'
        ];
        $set_unik = time() . rand(111, 999);
        $this->session->set_userdata('setUnik', $set_unik);
        $this->session->set_userdata('filterPermohonan','data_baru');
		$this->load->view('body/header', $data);
		$this->load->view('body/permohonan');
		$this->load->view('body/footer');
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
    public function submit()
    {
        $set_unik = $this->session->userdata('setUnik');
        $id_user = $this->session->userdata('id_user');
        $nama = $this->input->post('nama');
        $data = [
            'unik' => $set_unik,
            'id_user' => $id_user,
            'nama_pemohon' => $nama,
            // 'file' => time().'_' .$_FILES['att']['name'],
            'tgl_permohonan' => date('Y-m-d H:i:s'),
            'tahun' => date('Y'),
            // 'id_admin' => $this->input->post('admin'),
            'status_permohonan' => 'Waiting'
        ];
        $this->db->insert('tb_permohonan',$data);
       
        // $target_dir = "upload/file/";
        // $file = $_FILES['att']['name'];
        // $path = pathinfo($file);
        // $filename = time().'_'.$path['filename'];
        // $ext = $path['extension'];
        // $temp_name = $_FILES['att']['tmp_name'];
        // $path_filename_ext = $target_dir.$filename.".".$ext;
        // move_uploaded_file($temp_name,$path_filename_ext);

        $row = $this->input->post('row');
        for ($i=0; $i <count($row); $i++) { 
           if ($this->input->post('isi'.$i) != "") {
                $target_dir = "upload/file/";
                $file = $_FILES['att'.$i]['name'];
                $path = pathinfo($file);
                $filename = $set_unik.'_'. $i . '_'.$path['filename'];
                $ext = $path['extension'];
                $temp_name = $_FILES['att'.$i]['tmp_name'];
                $path_filename_ext = $target_dir.$filename.".".$ext;
                move_uploaded_file($temp_name,$path_filename_ext);
                $detail = [
                    "unik" => $set_unik,
                    "isi_permohonan" => $this->input->post('isi'.$i),
                    "nominal" => substr($this->remove_special($this->input->post('nominal'.$i)),2),
                    "file" => $set_unik.'_' . $i . '_'.$_FILES['att'.$i]['name']
                ];
                $this->db->insert('tb_permohonan_detail',$detail);
           }
        }
        $this->session->unset_userdata('setUnik');
        redirect('permohonan');
    }
    function list2()
    {
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "List Permohonan",
            'titlePage' => 'Dashboard Admin Embun Pagi',
            // 'data' => $this->db->get('tb_permohonan')->result()
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/list',$data);
		$this->load->view('body/footer');
    }
    function get_list_permohonan()
    {
        $list = $this->M_Permohonan->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $field) {
            $no++;

            // if($field->status_sampel === 'Waiting'){
            //     $btn = 'btn-warning';
            //     $dis = "";
            //     $edit = 'disabled';
            // } elseif($field->status_sampel === 'Draft'){
            //     $btn = 'btn-info';
            //     $dis = "disabled";
            //     $edit = "";
            // } elseif($field->status_sampel === 'Diproses'){
            //     $btn = 'btn-success';
            //     $dis = "";
            //     $edit = 'disabled';
            // } elseif($field->status_sampel === 'Diterima'){
            //     $btn = 'btn-success';
            //     $dis = "disabled";
            //     $edit = 'disabled';
            // }elseif ($field->status_sampel === 'Diterima Kajiulang') {
            //     $btn = 'btn-primary';
            //     $dis = "disabled";
            //     $edit = 'disabled';
            // }
            //  elseif($field->status_sampel === 'Ditolak'){
            //     $btn = 'btn-danger';
            //     $dis = "disabled";
            //     $edit = 'disabled';
            // }

            if ($field->status_permohonan === 'Waiting') {
                $status = '<a href="'.'detail/'.$field->unik.'" class="btn btn-warning"><i class="tf-icons bx bx-chevron-right"></i></a> &nbsp;&nbsp;
                <a href="'.'detail/'.$field->unik.'" class="btn btn-primary"><i class="bx bx-edit"></i></a>
                ';
            }else if($field->status_permohonan == 'Approved'){
                $status = '<a href="'.'detail/'.$field->unik.'" class="btn btn-primary"><i class="tf-icons bx bx-chevron-right"></i></a>';
            }else if($field->status_permohonan == 'Done'){
                $status = '<span class="btn btn-primary"><i class="bx bx-check-circle"></i> '.$field->status_permohonan.'</span>';
            }else{
                $status = '';
            }

            if ($field->no_permohonan > 0) {
               $permohonan = '<span class="badge bg-primary">'.$field->no_permohonan.'</span>';
            }else{
               $permohonan='<span class="btn btn-warning"> <i class="bx bx-time-five"></i></span>';
            }

            if($field->status_permohonan == 'Approved'){
                $status_admin ='<span class="btn btn-primary"> <i class="bx bx-check"></i> '. $field->nama_admin .'</span><br>'.$field->tgl_status_admin;
            }else if($field->status_permohonan == 'Rejected'){
                $status_admin ='<span class="btn btn-danger"> <i class="bx bx-x-circle"></i> '. $field->nama_admin .'</span>';
            }else{
                $status_admin = '12321';
            }
            
            if($field->status_permohonan_atasan == 'Approved'){
                $status_atasan ='<span class="btn btn-primary"> <i class="bx bx-check"></i> '. $field->nama_atasan .'</span><br>'.$field->tgl_status_admin;
            }else if($field->status_permohonan_atasan == 'Rejected'){
                $status_atasan ='<span class="btn btn-danger"> <i class="bx bx-x-circle"></i> '. $field->nama_atasan .'</span>';
            }else if($field->status_permohonan == 'Rejected'){
                $status_atasan = 'Ditolak '.$field->nama_admin;
            }else{
                $status_atasan ='<span class="btn btn-warning"> <i class="bx bx-time-five"></i></span>';
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
        //approved atau rejected untuk atasan
        if ($this->input->post('status') == 'Rejected' && $this->input->post('atasan') == 'data_baru') {
            $this->db->where('unik',$this->input->post('id'));
            $this->db->set('nama_atasan',$this->session->userdata('nama'));
            $this->db->set('status_permohonan_atasan','Rejected');
            $this->db->set('note_atasan',$this->input->post('keterangan'));
            $this->db->set('tgl_status_atasan',date('Y-m-d H:i:s'));
            $this->db->update('tb_permohonan');

               //insert table atasan
            $atasan = [
                "id_user" => $this->session->userdata('id_user'),
                "nama" => $this->session->userdata('nama'),
                "unik" => $this->input->post('id'),
                "status" => $this->input->post('status')
            ];
            $this->db->insert('tb_atasan',$atasan);
            echo json_encode('Success');
        }else if($this->uri->segment(5) == 'confirm_atasan'){
            $unik = $this->uri->segment(3);
            $status = $this->uri->segment(4);
            $this->db->select_max('no_permohonan');
            $no = $this->db->get('tb_permohonan')->row_array();
            $update = [
                "no_permohonan" => $no['no_permohonan']+1,
                "nama_atasan" => $this->session->userdata('nama'),
                "status_permohonan_atasan" => $status,
                "tgl_status_atasan" => date('Y-m-d H:i:s')
            ];
            $this->db->where('unik',$unik);
            $this->db->update('tb_permohonan',$update);

            //insert table atasan
            $atasan = [
                "id_user" => $this->session->userdata('id_user'),
                "nama" => $this->session->userdata('nama'),
                "unik" => $unik,
                "status" => $status
            ];
            $this->db->insert('tb_atasan',$atasan);
            redirect('permohonan/list2');
        }

        //approved atau rejected untuk admin
        if ($this->input->post('status') == 'Rejected' && $this->input->post('atasan') == 'waiting') {
            $this->db->where('unik',$this->input->post('id'));
            $this->db->set('nama_admin',$this->session->userdata('nama'));
            $this->db->set('status_permohonan','Rejected');
            $this->db->set('note_status_permohonan',$this->input->post('keterangan'));
            $this->db->set('tgl_status_admin',date('Y-m-d H:i:s'));
            $this->db->update('tb_permohonan');
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
    public function logout() {
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('level');
        redirect('auth');
    }
}