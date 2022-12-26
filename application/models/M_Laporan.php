<?php

use LDAP\Result;

defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_Laporan extends CI_Model {
    
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
        $this->db->from($this->tb_fo);
        if(isset($setTahun)) $this->db->where('tahun', $setTahun);
        $this->db->where('status_permohonan','Done');
        $this->db->where('bukti_bayar_user !=',"");
        
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
         
            $this->db->where('status_permohonan','Done');
            $this->db->where('bukti_bayar_user !=',"");
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
        $this->db->where('status_permohonan','Done');
        $this->db->where('bukti_bayar_user !=',"");
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
        $this->db->where('status_permohonan','Done');
        $this->db->where('bukti_bayar_user !=',"");
        // $this->db->or_where('status_sampel', 'Diterima');
        // $this->db->where('status_sampel', 'Diproses');
        // $this->db->where('kode_sampel >= ', 0);
        return $this->db->count_all_results();
    }
    
}