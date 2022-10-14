<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Permohonan'));
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
            'tgl_permohonan' => date('Y-m-d H:i:s'),
            'tahun' => date('Y'),
            'id_admin' => $this->input->post('admin'),
            'status_permohonan' => 'Waiting'
        ];
        $this->db->insert('tb_permohonan',$data);

        $row = $this->input->post('row');
        for ($i=0; $i < count($row)+1; $i++) { 
           if ($this->input->post('isi'.$i) != "") {
                $detail = [
                    "unik" => $set_unik,
                    "isi_permohonan" => $this->input->post('isi'.$i),
                    "nominal" => substr($this->remove_special($this->input->post('nominal'.$i)),2)
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
            if ($field->status_permohonan == 'Approved') {
                $status = '<span class="btn btn-primary">'.$field->status_permohonan.'</span>';
            }else{
                $status = '<a href="'.'detail/'.$field->unik.'" class="btn btn-warning"><i class="tf-icons bx bx-chevron-right"></i></a>';

            }
            if ($field->no_permohonan == '') {
               $permohonan = '';
            }else{
               $permohonan = '<span class="badge bg-warning"> '.$field->no_permohonan.'</span>';
            }
            $row = array();
            
			$row[] = $no;
			$row[] = $field->nama_pemohon;
			$row[] = $permohonan;
			$row[] = $field->tgl_permohonan;
			$row[] = $status;

            // if($level == 2 || $level == 22) {
            //     if($field->status_terbit === 'Sudah Terbit' && $x_cek_survey == true) {
            //         $row[] = '<a href="' . base_url() . 'permohonan/view_lhu/' . $field->unik . '" target="_blank" id="' . $field->unik . '" class="btn btn-info btn-xs view_permohonan" data-toggle="tooltip" title="View"><i class="glyphicon glyphicon-search"></i></a>';
            //     } else {
            //         $row[] = '';
            //     }
            // }

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
        $this->db->where('unik',$unik);
        $db_detail = $this->db->get('tb_permohonan_detail')->result();
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
        if ($this->input->post('status') == 'reject') {
            $this->db->where('');
            echo json_encode('da');
            // redirect('permohonan/list');
        }else{
            $unik = $this->uri->segment(3);
            $status = $this->uri->segment(4);
            $this->db->select_max('no_permohonan');
            $no = $this->db->get('tb_permohonan')->row_array();
            $update = [
                "no_permohonan" => $no['no_permohonan']+1,
                "status_permohonan" => $status,
            ];
            $this->db->where('unik',$unik);
            $this->db->update('tb_permohonan',$update);
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