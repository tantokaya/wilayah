<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_json extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	  * @keterangan : Controller untuk halaman biodata
	 **/
	
	public function CariNoSJ(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kodebeli) as no FROM h_beli";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,5,5))+1;
				$hasil = 'BL'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'BL'.'00001';
		}
		return $hasil;
	}
	
	public function InfoBarang()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$text = "SELECT * FROM barang WHERE kode_barang='$kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['nama_barang'] = $t->nama_barang;
					$data['satuan'] = $t->satuan;
					$data['harga_beli'] = $t->harga_beli;
					$data['harga_jual'] = $t->harga_jual;
					$data['stok_awal'] = $t->stok_awal;
					echo json_encode($data);
				}
			}else{
				$data['nama_barang'] = '';
					$data['satuan'] = '';
					$data['harga_beli'] = '';
					$data['harga_jual'] = '';
					$data['stok_awal'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function InfoSupplier()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$text = "SELECT * FROM supplier WHERE kode_supplier='$kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['nama_supplier'] = $t->nama_supplier;
					$data['alamat'] = $t->alamat;
					echo json_encode($data);
				}
			}else{
				$data['nama_supplier'] = '';
				$data['alamat'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	
	public function DataBarang(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM barang";
			}else{
				$text = "SELECT * FROM barang WHERE kode_barang LIKE '%$cari%' OR nama_barang LIKE '%$cari%'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_barang',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataNik(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM biodata";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataNik2(){
		$cek2 = $this->session->userdata('logged_in');
		if(!empty($cek2)){
			$cari= $this->input->post('cari2');
			if(empty($cari)){
				$text = "SELECT * FROM biodata";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik2',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataNik3(){
		$cek2 = $this->session->userdata('logged_in');
		if(!empty($cek2)){
			$cari= $this->input->post('cari3');
			if(empty($cari)){
				$text = "SELECT * FROM biodata";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik3',$d);
		}else{
			header('location:'.base_url());
		}
	}
	public function DataNik4(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari= $this->input->post('cari4');
			if(empty($cari)){
				$text = "SELECT * FROM biodata";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik4',$d);
		}else{
			header('location:'.base_url());
		}
	}
	public function DataNik5(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari= $this->input->post('cari4');
			if(empty($cari)){
				$text = "SELECT * FROM biodata WHERE bio_agama='IS'";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%' AND bio_agama='IS'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik',$d);
		}else{
			header('location:'.base_url());
		}
	}

	public function InfoAgama()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$aga_kode = $this->input->post('aga_kode');
			$text = "SELECT * FROM agama WHERE aga_kode='$aga_kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['aga_nama'] = $t->aga_nama;
					echo json_encode($data);
				}
			}else{
				$data['aga_nama'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function InfoPendidikan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$pen_kode = $this->input->post('pen_kode');
			$text = "SELECT * FROM pendidikan WHERE pen_kode='$pen_kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['pen_nama'] = $t->pen_nama;
					echo json_encode($data);
				}
			}else{
				$data['pen_nama'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function InfoPekerjaan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$pek_kode = $this->input->post('pek_kode');
			$text = "SELECT * FROM pekerjaan WHERE pek_kode='$pek_kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['pek_nama'] = $t->pek_nama;
					echo json_encode($data);
				}
			}else{
				$data['pek_nama'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function InfoKewarganegaraan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kew_kode = $this->input->post('kew_kode');
			$text = "SELECT * FROM kewarganegaraan WHERE kew_kode='$kew_kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['kew_nama'] = $t->kew_nama;
					echo json_encode($data);
				}
			}else{
				$data['kew_nama'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	
	
	public function InfoBiodata()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$nik = $this->input->post('nik');
			$text = "SELECT * FROM biodata WHERE nik='$nik'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['bio_nama'] 		= $t->bio_nama;
					$data['bio_tmp_lahir']	= $t->bio_tmp_lahir;
					$data['bio_tgl_lahir']	= $t->bio_tgl_lahir;
					$data['bio_goldar']		= $t->bio_goldar;
					$data['bio_jk']			= $t->bio_jk;
					$data['bio_kew']		= $t->bio_kew;
					$data['bio_agama']		= $t->bio_agama;
					$data['bio_pendidikan']	= $t->bio_pendidikan;
					$data['bio_pekerjaan']	= $t->bio_pekerjaan;
					$data['bio_status']		= $t->bio_status;
					$data['bio_status_kel']	= $t->bio_status_kel;
					$data['bio_alamat']		= $t->bio_alamat;
					
					echo json_encode($data);
				}
			}else{
				$data['bio_nama'] 		= '';
				$data['bio_tmp_lahir']	= '';
				$data['bio_tgl_lahir']	= '';
				$data['bio_goldar']		= '';
				$data['bio_jk']			= '';
				$data['bio_kew']		= '';
				$data['bio_agama']		= '';
				$data['bio_pendidikan']	= '';
				$data['bio_pekerjaan']	= '';
				$data['bio_status']		= '';
				$data['bio_status_kel']	= '';
				$data['bio_alamat']		= '';
				
				
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	public function InfoBiodata2()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$nik = $this->input->post('nik');
			$text = "SELECT * FROM biodata WHERE nik='$nik' AND bio_agama='IS'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['bio_nama'] 		= $t->bio_nama;
					$data['bio_tmp_lahir']	= $t->bio_tmp_lahir;
					$data['bio_tgl_lahir']	= $t->bio_tgl_lahir;
					$data['bio_goldar']		= $t->bio_goldar;
					$data['bio_jk']			= $t->bio_jk;
					$data['bio_kew']		= $t->bio_kew;
					$data['bio_agama']		= $t->bio_agama;
					$data['bio_pendidikan']	= $t->bio_pendidikan;
					$data['bio_pekerjaan']	= $t->bio_pekerjaan;
					$data['bio_status']		= $t->bio_status;
					$data['bio_status_kel']	= $t->bio_status_kel;
					$data['bio_alamat']		= $t->bio_alamat;
					
					echo json_encode($data);
				}
			}else{
				$data['bio_nama'] 		= '';
				$data['bio_tmp_lahir']	= '';
				$data['bio_tgl_lahir']	= '';
				$data['bio_goldar']		= '';
				$data['bio_jk']			= '';
				$data['bio_kew']		= '';
				$data['bio_agama']		= '';
				$data['bio_pendidikan']	= '';
				$data['bio_pekerjaan']	= '';
				$data['bio_status']		= '';
				$data['bio_status_kel']	= '';
				$data['bio_alamat']		= '';
				
				
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */