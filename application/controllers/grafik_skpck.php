<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grafik_skpck extends CI_Controller {

	
	
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

			
			$d['judul']="Grafik Pembuatan Surat Keterangan Pengantar Kepolisian";
			
			
			$d['content'] = $this->load->view('grafik_skpck', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	

}

/* End of file grafik_skpck.php */
/* Location: ./application/controllers/grafik_skpck.php */