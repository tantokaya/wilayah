<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_penduduk extends CI_Controller {

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

			
			$d['judul']="Laporan Data Penduduk";
			
			
			$d['content'] = $this->load->view('lap_penduduk/form', $d, true);		
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
			$no_kk = $this->input->post('no_kk');
			$pilih = $this->input->post('pilih');
			
			if($pilih=='all'){
				$where = ' ';
			}else if($pilih=='no_kk'){
				$where = " WHERE no_kk='$no_kk'";
			}else{
				$where = " WHERE nik='$nik'";
			}
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM biodata $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/lap_penduduk/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['next_link'] = 'Lanjut &raquo;';
			$config['prev_link'] = '&laquo; Kembali';
			$config['last_link'] = '<b>Terakhir &raquo; </b>';
			$config['first_link'] = '<b> &laquo; Pertama</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT * FROM biodata $where 
					ORDER BY nik ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM sta_nikah";
			$d['l_status'] = $this->app_model->manualQuery($text2);
			
			$text3 = "SELECT * FROM pekerjaan";
			$d['l_pek'] = $this->app_model->manualQuery($text3);
			
			$this->load->view('lap_penduduk/view',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$kode = $this->uri->segment(4);
			$no_kk = $this->uri->segment(4);
			$pilih = $this->uri->segment(3);
			
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
			}else if($pilih=='no_kk'){
				$where = " WHERE no_kk='$no_kk'";
				$d['filter']="No. Kartu Keluarga $no_kk";
			}else{
				$where = " WHERE nik='$kode'";
				$d['filter']="Kode NIK $kode";
			}

			$d['judul']="Laporan Data Penduduk";
			
			$text = "SELECT * FROM biodata $where 
					ORDER BY bio_nama ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM sta_nikah";
			$d['l_status'] = $this->app_model->manualQuery($text2);
			
			$this->load->view('lap_penduduk/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */