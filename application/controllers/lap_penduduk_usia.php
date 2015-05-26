<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_penduduk_usia extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	  * @keterangan : Controller untuk halaman Laporan Penduduk Berdasarkan Usia
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

			
			$d['judul']="Laporan Data Penduduk Berdasarkan Usia";
			
			
			$d['content'] = $this->load->view('lap_penduduk_usia/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$pilih = $this->input->post('pilih');
			$umur = $this->input->post('umur');
			
			if($pilih=='all'){
				$where_a=0;
				$where_b = 75;
			}else if($pilih=='umur'){
				$u = explode('-',$umur);
				$where_a = $u[0];
				$where_b = $u[1];
				if($where_b==0 ){
					$where_b=$where_a;
				}
			}
			$d['show_a'] = $where_a;
			$d['show_b'] = $where_b;
			$this->load->view('lap_penduduk_usia/view',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$kode = $this->uri->segment(4);
			$pilih = $this->uri->segment(3);
			$umur = $this->uri->segment(4);

			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['nama_kelurahan']= $this->config->item('nama_kelurahan');
			
			if($pilih=='all'){
				$where_a=0;
				$where_b = 75;
				$d['filter']="Semua Data";
			}else if($pilih=='umur'){
				$u = explode('-',$umur);
				$where_a = $u[0];
				$where_b = $u[1];
				if($where_b==0 ){
					$where_b=$where_a;
				}
				$d['filter']="Usia $where_a s/d $where_b";
			}

			$d['judul']="Laporan Data Penduduk Berdasarkan Usia";
			
			$d['show_a'] = $where_a;
			$d['show_b'] = $where_b;
			
			$this->load->view('lap_penduduk_usia/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file lap_penduduk_usia.php */
/* Location: ./application/controllers/lap_penduduk_usia.php */