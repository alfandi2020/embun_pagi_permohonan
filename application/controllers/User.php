<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Permohonan'));
    }

    public function index()
    {
        $add = $this->input->post('adduser');
        if ($add == 'add') {
            if ($this->input->post('level') == '1') {
                $role = '1,2,3';
            }else if ($this->input->post('level') == '2') {
                $role = '1,2';
            }else{
                $role = '1';
            }
            $insert= [
                "nama" => $this->input->post('nama'),
                "username" => $this->input->post('username'),
                "password" => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
                "level" => $this->input->post('level'),
                "role" => $role,
                "status_sekolah" => $this->input->post('status_sekolah'),
                "status" => 'Aktif',
            ];
            $this->db->insert('users',$insert);
            redirect('user');
        }
        $this->db->select('*,b.status as level_status,a.status,a.nama,b.nama as nama_level,a.id as id_user');
        $this->db->join('tb_level as b','a.level=b.id');
        $user = $this->db->get('users as a')->result();
        $data = [
            'title' => "List User",
            'titlePage' => 'List User',
            'data' => $user
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/user',$data);
		$this->load->view('body/footer');
    }
    function status($id)
    {

        $val = $this->input->post('status');
        $this->db->set('status',$val == null ? 'NonAktif' : 'Aktif');
        $this->db->where('id',$id);
        $cek=$this->db->update('users');
        if ($cek == true) {
            redirect('user');
        }
    }
    function edit($id)
    {
        $this->db->where('id',$id);
        $get_user = $this->db->get('users')->row_array();
        $data = [
            'title' => "List User",
            'titlePage' => 'List User',
            'data' => $get_user
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/user',$data);
		$this->load->view('body/footer');
    }
}