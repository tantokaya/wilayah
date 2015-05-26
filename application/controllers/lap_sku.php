<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_sku extends CI_Controller {

	/**
	* @author : Hartanto Kurniawan,S.Kom
	* @keterangan : Controller untuk Laporan Surat Keterangan Usaha
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

			
			$d['judul']="Laporan Surat Keterangan Usaha";
			
			$d['content'] = $this->load->view('lap_sku/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$nik = $this->input->post('nik');
			$pilih = $this->input->post('pilih');
			$tgl_1 = $this->app_model->tgl_str($this->input->post('tgl_1'));
			$tgl_2 = $this->app_model->tgl_str($this->input->post('tgl_2'));
			
			if($pilih=='all'){
				$where = ' ';
			}else if($pilih=='tgl'){
				$where = " WHERE tgl_pengajuan BETWEEN '$tgl_1' AND '$tgl_2'";
			}else{
				$where = " WHERE nik='$nik'";
			}
			
			$text = "SELECT * FROM sku $where 
					ORDER BY nmr_surat ASC ";
			$total = "SELECT COUNT(*) 'tgl_pengajuan' FROM skdu $where";
			
			$d['data'] = $this->app_model->manualQuery($text);
			$datatotal = $this->app_model->manualQuery($total)->result();
			foreach( $datatotal as $jum):
					$jumlah = $jum->tgl_pengajuan;
			endforeach;
			$d['totaldata'] = $jumlah;
			
			$this->load->view('lap_sku/view',$d);
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
			$tgl_1 = $this->app_model->tgl_str($this->uri->segment(4));
			$tgl_2 = $this->app_model->tgl_str($this->uri->segment(5));
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['nama_kelurahan']= $this->config->item('nama_kelurahan');
			
			if($pilih=='all'){
				$where = ' ';
				$d['filter']="Semua Data";
			}else if($pilih=='tgl'){
				$where = " WHERE tgl_pengajuan BETWEEN '$tgl_1' AND '$tgl_2'";
				$tgl_1 = $this->app_model->tgl_sql($tgl_1);
				$tgl_2 = $this->app_model->tgl_sql($tgl_2);
				$d['filter']="Tanggal $tgl_1 s/d $tgl_2";
			}else{
				$where = " WHERE nik='$kode'";
				$d['filter']=" NIK $kode";
			}

			$d['judul']="Laporan Surat Keterangan Usaha";
			
			$text = "SELECT * FROM sku $where 
					ORDER BY nmr_surat ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_sku/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
}

/* End of file lap_sku.php */
/* Location: ./application/controllers/lap_sku.php */