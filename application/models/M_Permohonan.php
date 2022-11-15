<?php

use LDAP\Result;

defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_Permohonan extends CI_Model {
    
    var $column_order = array(null, 'nama_pemohon', 'tgl_permohonan','no_permohonan');
    var $column_search = array('nama_pemohon', 'tgl_permohonan','no_permohonan');
    var $order = array('id' => 'desc');
    var $tb_fo = 'tb_permohonan';
    var $detail = 'tb_permohonan_detail';
    function get_detail_permohonan($unik)
    {
        $this->db->where('unik', $unik);
        $this->db->order_by("id", "asc");
        $query = $this->db->get($this->detail);
        if($query->num_rows()>0) {
            return $query->result_array();
        }
    }
    private function _get_datatables_query()
    {
        $setTahun = $this->session->userdata('setTahun');
        $filterPermohonan = $this->session->userdata('filterPermohonan');
        $level = $this->session->userdata('level');
        $id_user = $this->session->userdata('id_user');
        $this->db->from($this->tb_fo);
        if(isset($setTahun)) $this->db->where('tahun', $setTahun);
        if ($this->session->userdata('filterPermohonan') == 'waiting') {
            if ($level == 2) {
                if ($this->session->userdata('filterSekolah') == true) {
                    $this->db->where('tujuan_sekolah', $this->session->userdata('filterSekolah'));
                }
                $this->db->where('status_permohonan','Waiting');
            }else if($level == 3){
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->where('status_permohonan','Waiting');
            }
        }else if ($this->session->userdata('filterPermohonan') == 'permohonan_baru') {
            if ($this->session->userdata('filterSekolah') == true) {
                $this->db->where('tujuan_sekolah', $this->session->userdata('filterSekolah'));
            }
            if ($level == 2) { // admin filter
                $this->db->where('status_permohonan','Approved');
                $this->db->where('status_permohonan_atasan',null);
                $this->db->or_not_like('status_permohonan_atasan','Rejected');
                $this->db->not_like('status_permohonan','Done');
            }else if($level == 1){ // admin approval
                $this->db->where('status_permohonan','Approved');
                $this->db->where('status_permohonan_atasan',null);
                $this->db->or_not_like('status_permohonan_atasan','Rejected');
                $this->db->not_like('status_permohonan','Done');
                // $this->db->not_like('nama_atasan',$id_user);
            }else{
                $this->db->where('status_permohonan','Approved');
                $this->db->where('status_permohonan_atasan',null);
                $this->db->or_not_like('status_permohonan_atasan','Rejected');
                $this->db->not_like('status_permohonan','Done');
            }
        }elseif ($this->session->userdata('filterPermohonan') == 'permohonan_selesai') { // upload bukti
                if ($this->session->userdata('filterSekolah') == true) {
                    $this->db->where('tujuan_sekolah', $this->session->userdata('filterSekolah'));
                }
                // $this->db->where('status_permohonan','Waiting');
                $this->db->where('status_atasan','Selesai');
                $this->db->where('status_permohonan','Approved');
                $this->db->or_where('status_permohonan','Done');
                // $this->db->where('status_permohonan_atasan',null);
                // $this->db->or_not_like('status_permohonan_atasan','Rejected');
                // $this->db->like('status_permohonan','Done');
        }else{ // data_lama
            if ($level == 2) {
                if ($this->session->userdata('filterSekolah') == true) {
                    $this->db->where('tujuan_sekolah', $this->session->userdata('filterSekolah'));
                }
                $this->db->or_where('status_permohonan','Rejected');
                $this->db->or_where('status_permohonan','Done');
                $this->db->or_where('status_permohonan_atasan','Rejected');
            }else if($level == 1){
                $this->db->or_where('status_permohonan','Rejected');
                $this->db->or_where('status_permohonan','Done');
                $this->db->or_where('status_permohonan_atasan','Rejected');
            }else{
                if($level == 3) {
                    $this->db->where('id_user', $this->session->userdata('id_user'));
                }
                $this->db->where('status_permohonan','Done');
                $this->db->or_where('status_permohonan','Rejected');
                // $this->db->where('status_permohonan_atasan','Rejected');
            }
        }
        if ($this->session->userdata('filterSekolah') == true) {
            $this->db->where('tujuan_sekolah',$this->session->userdata('filterSekolah'));
        }
        if($level == 3) {
            $this->db->where('id_user', $this->session->userdata('id_user'));
        }

  
        // if ($level == 2) {
        //     $this->db->where('tujuan_sekolah', explode(',',$this->session->userdata('tujuan_sekolah')));
        // }
        // $level = $this->session->userdata('level');
        // if($level == 2 || $level == 22) {
        //     $date = date('Y-m-d');
        //     $date1 = str_replace('-', '/', $date);
        //     $to_date = date('Y-m-d',strtotime($date1 . "+3 days"));
            
        //     $this->db->where('id_user', $this->session->userdata('id'));
        //     if(str_replace('_', ' ', $filterPermohonan) == 'Sudah Dibayar'){
        //         $this->db->where('status_sampel', 'Diterima');
        //         $this->db->where('status_bayar', str_replace('_', ' ', $filterPermohonan));
        //         $this->db->where('status_terbit', 'Sudah Terbit');
        //     }else if(str_replace('_', ' ', $filterPermohonan) == 'Belum Dibayar'){
        //         $this->db->where('status_sampel', 'Diterima Kajiulang');
        //     }
        // }else{
        //     if(str_replace('_', ' ', $filterPermohonan) == 'Sudah Dibayar'){
        //         $this->db->where('status_terbit', 'Sudah Terbit');
        //         $this->db->where('status_bayar', str_replace('_', ' ', $filterPermohonan));
        //         $this->db->where('status_sampel', 'Diterima');
        //     } else if(str_replace('_', ' ', $filterPermohonan) == 'Belum Dibayar'){
        //         $this->db->where('status_terbit', 'Belum Terbit');
        //         // $this->db->where('status_bayar', str_replace('_', ' ', $filterPermohonan));
        //         // $this->db->where('status_sampel', 'Diterima');
        //         $this->db->where('status_sampel', 'Diterima Kajiulang');
        //         $this->db->where('status_sampel !=', 'Ditolak');
        //         // $this->db->where('kode_sampel > ', 0);
        //     }
        // }
        // $this->db->where('status_sampel', 'Diterima');
        // $this->db->where('kode_sampel >= ', 0);

        //add custom filter here
        // if($level != 2 && $level != 22) {
        //     if ($_POST['nama_pemohon']) {
        //         $this->db->like('nama', $_POST['nama_pemohon']);
        //         $this->db->or_like('nama_perusahaan', $_POST['nama_pemohon']);
        //     }
        // }
        
        if($_POST['nama_pemohon']) $this->db->like("nama_pemohon", $_POST['nama_pemohon']);
        if($_POST['no_permohonan']) $this->db->like("no_permohonan", $_POST['no_permohonan']);
        if($_POST['tgl_permohonan']) $this->db->like("DATE_FORMAT(tgl_permohonan, '%Y-%m-%d')", $_POST['tgl_permohonan']);
        if($_POST['no_permohonan']) $this->db->like("status_permohonan", $_POST['status_admin']);
        if($_POST['no_permohonan']) $this->db->like("status_permohonan_atasan", $_POST['status_atasan']);

        // if($_POST['status_sampel']) $this->db->like('status_sampel', $_POST['status_sampel']);
        // if($_POST['tgl_sampel_masuk']) $this->db->like("DATE_FORMAT(tgl_sampel_masuk, '%d-%m-%Y')", $_POST['tgl_sampel_masuk']);
        // if($_POST['kode_sampel']) $this->db->like("LPAD(kode_sampel, 4, '0')", $_POST['kode_sampel']);
        // if($level != 2 && $level != 22) {
        //     if ($_POST['tgl_spt']) $this->db->like("DATE_FORMAT(tgl_spt, '%d-%m-%Y')", $_POST['tgl_spt']);
        // }
        // if($_POST['id_billing']) $this->db->like('id_billing', $_POST['id_billing']);
        // if($_POST['jumlah_bayar']) $this->db->like('jumlah_bayar', $_POST['jumlah_bayar']);

        $i = 0;
        foreach ($this->column_search as $item) // looping awal
        {
            if (isset($_POST['search']['value'])) // jika datatable mengirimkan pencarian dengan metode POST
            {
                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $setTahun = $this->session->userdata('setTahun');
        $filterPermohonan = $this->session->userdata('filterPermohonan');
        $this->_get_datatables_query();
        $length = $this->input->post('length');
        if ($length != -1)
            $this->db->limit($length, $this->input->post('start'));
         
        // if(isset($setTahun)) $this->db->where('tahun', $setTahun);
        // $level = $this->session->userdata('level');
        // if($level == 2 || $level == 22) {
        //     // $this->db->where('status_sampel', 'Diterima');
        //     $this->db->where('id_user', $this->session->userdata('id'));
        //     if(str_replace('_', ' ', $filterPermohonan) == 'Sudah Dibayar'){
        //         $this->db->where('status_sampel', 'Diterima');
        //         $this->db->where('status_bayar', str_replace('_', ' ', $filterPermohonan));
        //         $this->db->where('status_terbit', 'Sudah Terbit');
        //     }elseif(str_replace('_', ' ', $filterPermohonan) == 'Belum Dibayar'){
        //         $this->db->where('status_sampel', 'Diterima Kajiulang');

        //     }
        // }else{
        //     if(str_replace('_', ' ', $filterPermohonan) == 'Sudah Dibayar'){
        //         $this->db->where('status_terbit', 'Sudah Terbit');
        //         $this->db->where('status_bayar', str_replace('_', ' ', $filterPermohonan));
        //         $this->db->where('status_sampel', 'Diterima');
        //     } else if(str_replace('_', ' ', $filterPermohonan) == 'Belum Dibayar'){
        //         $this->db->where('status_terbit', 'Belum Terbit');
        //         // $this->db->where('status_bayar', str_replace('_', ' ', $filterPermohonan));
        //         // $this->db->where('status_sampel', 'Diterima');
        //         $this->db->where('status_sampel', 'Diterima Kajiulang');
        //         $this->db->where('status_sampel !=', 'Ditolak');
        //         // $this->db->where('kode_sampel > ', 0);
        //     }
        // }
        // $this->db->where('status_sampel', 'Diterima');
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $setTahun = $this->session->userdata('setTahun');
        $filterPermohonan = $this->session->userdata('filterPermohonan');
        $this->_get_datatables_query();
        if(isset($setTahun)) $this->db->where('tahun', $setTahun);
        $level = $this->session->userdata('level');
        if ($this->session->userdata('filterPermohonan') == 'waiting') {
            $this->db->where('status_permohonan','Waiting');
        }else if ($this->session->userdata('filterPermohonan') == 'permohonan_baru') {
            $this->db->where('status_permohonan','Approved');
            $this->db->where('status_permohonan_atasan',null);
            $this->db->or_not_like('status_permohonan_atasan','Rejected');
            $this->db->not_like('status_permohonan','Done');

        }else{
            $this->db->or_where('status_permohonan','Rejected');
            $this->db->or_where('status_permohonan','Done');
            $this->db->or_where('status_permohonan_atasan','Rejected');
        }
        // $this->db->where('status_sampel', 'Diterima');
        // $this->db->where('kode_sampel > ', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        $setTahun = $this->session->userdata('setTahun');
        $filterPermohonan = $this->session->userdata('filterPermohonan');
        $this->db->from($this->tb_fo);
        if(isset($setTahun)) $this->db->where('tahun', $setTahun);
        $level = $this->session->userdata('level');
        if ($this->session->userdata('filterPermohonan') == 'waiting') {
            $this->db->where('status_permohonan','Waiting');
        }else if ($this->session->userdata('filterPermohonan') == 'permohonan_baru') {
            $this->db->where('status_permohonan','Approved');
            $this->db->where('status_permohonan_atasan',null);
            $this->db->or_not_like('status_permohonan_atasan','Rejected');
            $this->db->not_like('status_permohonan','Done');

        }else{
            $this->db->or_where('status_permohonan','Rejected');
            $this->db->or_where('status_permohonan','Done');
            $this->db->or_where('status_permohonan_atasan','Rejected');
        }
        // $this->db->or_where('status_sampel', 'Diterima');
        // $this->db->where('status_sampel', 'Diproses');
        // $this->db->where('kode_sampel >= ', 0);
        return $this->db->count_all_results();
    }
    
}