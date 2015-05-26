<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	  * @keterangan : Controller untuk halaman biodata
	 **/
	 
	 
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['nama_kelurahan']= $this->config->item('nama_kelurahan');

			
			$d['judul']="Backup / Restore Database";

			$d['content']= $this->load->view('backup',$d,true);
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url().'index.php/login');
		}
	}
	function BackupDB(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$tgl = date('YmHis');
			$file = $tgl.'SimWilayahBackup.sql.zip';
			
			$this->load->dbutil();
			$this->db->query("SET time_zone='+07:00'");
			$backup=&$this->dbutil->backup();
			force_download($file,$backup); 
		}else{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function logout(){
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'index.php/login');
		}else{
			$this->session->sess_destroy();
			header('location:'.base_url().'index.php/login');
		}
	}
	
	
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */