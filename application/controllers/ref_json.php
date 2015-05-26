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
	
	
	public function DataNik(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM biodata LIMIT 25";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%' LIMIT 25";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataNik1(){
		$cek1 = $this->session->userdata('logged_in');
		if(!empty($cek1)){
			$cari= $this->input->post('cari1');
			if(empty($cari)){
				$text = "SELECT * FROM biodata LIMIT 25";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%' LIMIT 25";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik1',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataNik2(){
		$cek2 = $this->session->userdata('logged_in');
		if(!empty($cek2)){
			$cari= $this->input->post('cari2');
			if(empty($cari)){
				$text = "SELECT * FROM biodata  LIMIT 25";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%' LIMIT 25";
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
				$text = "SELECT * FROM biodata  LIMIT 25";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%'  LIMIT 25";
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
				$text = "SELECT * FROM biodata  LIMIT 25";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%' LIMIT 25";
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
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM biodata WHERE bio_agama='1' LIMIT 25";
			}else{
				$text = "SELECT * FROM biodata WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%' LIMIT 25";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_nik5',$d);
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
					$data['no_kk'] 			= $t->no_kk;
					$data['bio_nama'] 		= $t->bio_nama;
					$data['bio_tmp_lahir']	= $t->bio_tmp_lahir;
					$data['bio_tgl_lahir']	= $this->app_model->tgl_str($t->bio_tgl_lahir);
					$data['bio_goldar']		= $t->bio_goldar;
					$data['bio_jk']			= $t->bio_jk;
					$data['bio_kew']		= $t->bio_kew;
					$data['bio_agama']		= $t->bio_agama;
					$data['bio_pekerjaan']	= $t->bio_pekerjaan;
					$data['bio_status']		= $t->bio_status;
					$data['bio_alamat']		= $t->bio_alamat;
					$data['bio_rt']			= $t->bio_rt;
					$data['bio_rw']			= $t->bio_rw;
					$data['bio_propinsi']	= $t->bio_propinsi;
					$data['bio_kota']		= $this->propinsi($t->bio_propinsi,$t->bio_kota);
					$data['bio_kecamatan']	= $this->kota($t->bio_kota,$t->bio_propinsi,$t->bio_kecamatan);
					$data['bio_kelurahan']	= $this->kecamatan($t->bio_kecamatan,$t->bio_kota,$t->bio_propinsi,$t->bio_kelurahan);
					$data['bio_kodepos']	= $t->bio_kodepos;
										
					echo json_encode($data);
				}
			}else{
				$data['no_kk'] 			= '';
				$data['bio_nama'] 		= '';
				$data['bio_tmp_lahir']	= '';
				$data['bio_tgl_lahir']	= '';
				$data['bio_goldar']		= '';
				$data['bio_jk']			= '';
				$data['bio_kew']		= '';
				$data['bio_agama']		= '';
				$data['bio_pekerjaan']	= '';
				$data['bio_status']		= '';
				$data['bio_alamat']		= '';
				$data['bio_rt']			= '';
				$data['bio_rw']			= '';
				$data['bio_propinsi']	= '';
				$data['bio_kota']		= "<option value=''>-PILIH-</option>";
				$data['bio_kecamatan']	= "<option value=''>-PILIH-</option>";
				$data['bio_kelurahan']	= "<option value=''>-PILIH-</option>";
				$data['bio_kodepos']	= '';
								
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	public function propinsi($p,$q)
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			if($p!=''){
				$bx = null;
				$by = null;
				$data['kota'] = $this->app_model->get_kota($p);
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($data['kota']->result() as $row)
				{
					if($row->kd_kota==$q){
						$by .= "<option value='".$row->kd_kota."' selected='selected'>".$row->nm_kota."</option>";
					}else{
						$by .= "<option value='".$row->kd_kota."'>".$row->nm_kota."</option>";
					}
				}
			}else{
				$by .= "<option value=''>-PILIH-</option>";
			}
			return  $bx.$by;
		}else{
			header('location:'.base_url());
		}
	}	
	public function kota($p,$q,$r)
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$bx = null;
			$by = null;
			if(($p!='') && ($q!='')){
				$data['kec'] = $this->app_model->get_kec($p,$q);
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($data['kec']->result() as $row)
				{
					if($row->kd_kecamatan==$r){
						$by .= "<option value='".$row->kd_kecamatan."' selected='selected'>".$row->nm_kecamatan."</option>";
					}else{
						$by .= "<option value='".$row->kd_kecamatan."'>".$row->nm_kecamatan."</option>";
					}
				}
			}else{
				$by .= "<option value=''>-PILIH-</option>";
			}
			return  $bx.$by;
		}else{
			header('location:'.base_url());
		}
	}
	public function kecamatan($p,$q,$r,$s)
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$bx = null;
			$by = null;
			if(($p!='') && ($q!='') && ($r!='')){
				$data['kel'] = $this->app_model->get_kel($p,$q,$r);
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($data['kel']->result() as $row)
				{
					if($row->kd_kelurahan==$s){
						$by .= "<option value='".$row->kd_kelurahan."' selected='selected'>".$row->nm_kelurahan."</option>";
					}else{
						$by .= "<option value='".$row->kd_kelurahan."'>".$row->nm_kelurahan."</option>";
					}
				}
			}else{
				$by .= "<option value=''>-PILIH-</option>";
			}
			return  $bx.$by;
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */