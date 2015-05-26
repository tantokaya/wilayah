<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skun_na extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman skun_na
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			$cari_tgl = $this->app_model->tgl_sql($this->input->post('cari_tgl'));
			if($cari!=''){
				$where = " WHERE nmr_surat LIKE '%$cari%' OR skun_nama1 LIKE '%$cari%' OR skun_nama2 LIKE '%$cari%' OR nik1 LIKE '%$cari%'OR skun_nama3 LIKE '%$cari%' ";
			}else if($cari_tgl!=''){
				$where = " WHERE tgl_surat = '$cari_tgl'";
			}else{
				$where = ' ';
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['nama_kelurahan']= $this->config->item('nama_kelurahan');

			
			$d['judul']="Surat Keterangan Untuk Nikah NA";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM skun_na $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/skun_na/index/';
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
			

			$text = "SELECT * FROM skun_na $where 
					ORDER BY tgl_surat DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('skun_na/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tambah()
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

			$d['judul']="Tambah Surat Keterangan Untuk Nikah NA";
			
			
			$tgl	= date('d-m-Y');
			$tgl3	= date('d-m-Y');
			
			$d['nomor']		='';
			$d['nmr_surat']		='';
			$d['tgl_surat']		=$tgl3;
			$d['nik1']			='';
			$d['skun_na_nama1']	='';
			$d['tmp_lahir1']	='';
			$d['tgl_lahir1']	='';
			$d['jk1']			='';
			$d['kew_id1']		='';
			$d['pek_id1']		='';
			$d['aga_id1']		='';
			$d['alamat1']		='';
			$d['kodepos1']		='';
			$d['rt1']			='';
			$d['rw1']			='';
			$d['kota1']			='';
			$d['propinsi1']		='';
			$d['kelurahan1']	='';
			$d['kecamatan1']	='';
			$d['bin_binti']		='';
			$d['status1']		='';
			$d['status2']		='';
			
			$d['nik2']			='';
			$d['skun_na_nama2']	='';
			$d['tmp_lahir2']	='';
			$d['tgl_lahir2']	='';
			$d['jk2']			='';
			$d['kew_id2']		='';
			$d['pek_id2']		='';
			$d['aga_id2']		='';
			$d['alamat2']		='';
			$d['kodepos2']		='';
			$d['rt2']			='';
			$d['rw2']			='';
			$d['kota2']			='';
			$d['propinsi2']		='';
			$d['kelurahan2']	='';
			$d['kecamatan2']	='';
			
			$d['nik3']			='';
			$d['skun_na_nama3']	='';
			$d['tmp_lahir3']	='';
			$d['tgl_lahir3']	='';
			$d['jk3']			='';
			$d['kew_id3']		='';
			$d['pek_id3']		='';
			$d['aga_id3']		='';
			$d['alamat3']		='';
			$d['kodepos3']		='';
			$d['rt3']			='';
			$d['rw3']			='';
			$d['kota3']			='';
			$d['propinsi3']		='';
			$d['kelurahan3']	='';
			$d['kecamatan3']	='';
			
			$d['ttd_jenis']		='';
			$d['ttd_kode']		='';
			$d['tgl_pengajuan']	=$tgl;
			
			
			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text_pek = "SELECT * FROM pekerjaan";
			$d['l_pekerjaan'] = $this->app_model->manualQuery($text_pek);
			
			$text_jk = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text_jk);
			
			$text_kew = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text_kew);

			$text4 = "SELECT * FROM sta_nikah";
			$d['l_status'] = $this->app_model->manualQuery($text4);
			
			$text_propinsi1 = "SELECT * FROM propinsi";
			$d['l_propinsi1'] = $this->app_model->manualQuery($text_propinsi1);
						
			$text_kota1 = "SELECT * FROM kota where left(kd_kota,2)='0' ORDER BY nm_kota ASC";
			$d['l_kota1'] = $this->app_model->manualQuery($text_kota1);
			
			$text_kecamatan1 = "SELECT * FROM kecamatan where left(kd_kecamatan,4)='0' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan1'] = $this->app_model->manualQuery($text_kecamatan1);
			
			$text_kelurahan1 = "SELECT * FROM kelurahan where left(kd_kelurahan,7)='0'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan1'] = $this->app_model->manualQuery($text_kelurahan1);
			
			$text_propinsi2 = "SELECT * FROM propinsi";
			$d['l_propinsi2'] = $this->app_model->manualQuery($text_propinsi2);
						
			$text_kota2 = "SELECT * FROM kota where left(kd_kota,2)='0' ORDER BY nm_kota ASC";
			$d['l_kota2'] = $this->app_model->manualQuery($text_kota2);
			
			$text_kecamatan2 = "SELECT * FROM kecamatan where left(kd_kecamatan,4)='0' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan2'] = $this->app_model->manualQuery($text_kecamatan2);
			
			$text_kelurahan2 = "SELECT * FROM kelurahan where left(kd_kelurahan,7)='0'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan2'] = $this->app_model->manualQuery($text_kelurahan2);
			
			$text_propinsi3 = "SELECT * FROM propinsi";
			$d['l_propinsi3'] = $this->app_model->manualQuery($text_propinsi3);
						
			$text_kota3 = "SELECT * FROM kota where left(kd_kota,2)='0' ORDER BY nm_kota ASC";
			$d['l_kota3'] = $this->app_model->manualQuery($text_kota3);
			
			$text_kecamatan3 = "SELECT * FROM kecamatan where left(kd_kecamatan,4)='0' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan3'] = $this->app_model->manualQuery($text_kecamatan3);
			
			$text_kelurahan3 = "SELECT * FROM kelurahan where left(kd_kelurahan,7)='0'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan3'] = $this->app_model->manualQuery($text_kelurahan3);
			
			$text_lurah = "SELECT * FROM penandatangan where ttd_jenis='0' ORDER BY ttd_nama ASC";
			$d['l_ttd_nama'] = $this->app_model->manualQuery($text_lurah);
			
			$d['content'] = $this->load->view('skun_na/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	public function propinsi()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$p = $this->input->post('propinsi',TRUE);
			$by = null;
			$bx = null;
			if($p!=''){
				$data['kota'] = $this->app_model->get_kota($p);
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($data['kota']->result() as $row)
				{
					$by .= "<option value='".$row->kd_kota."'>".$row->nm_kota."</option>";
				}
			}else{
				$by .= "<option value=''>-PILIH-</option>";
			}
			echo  $bx.$by;
		}else{
			header('location:'.base_url());
		}
	}	
	public function kota()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$p = $this->input->post('kota',TRUE);
			$q = $this->input->post('propinsi',TRUE);
			$by = null;
			$bx = null;
			if(($p!='') && ($q!='')){
				$data['kec'] = $this->app_model->get_kec($p,$q);
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($data['kec']->result() as $row)
				{
					$by .= "<option value='".$row->kd_kecamatan."'>".$row->nm_kecamatan."</option>";
				}
			}else{
				$by .= "<option value=''>-PILIH-</option>";
			}
			echo  $bx.$by;
		}else{
			header('location:'.base_url());
		}
	}
	public function kecamatan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$p = $this->input->post('kecamatan',TRUE);
			$q = $this->input->post('kota',TRUE);
			$r = $this->input->post('propinsi',TRUE);
			$by = null;
			$bx = null;
			if(($p!='') && ($q!='') && ($r!='')){
				$data['kel'] = $this->app_model->get_kel($p,$q,$r);
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($data['kel']->result() as $row)
				{
					$by .= "<option value='".$row->kd_kelurahan."'>".$row->nm_kelurahan."</option>";
				}
			}else{
				$by .= "<option value=''>-PILIH-</option>";
			}
			echo  $bx.$by;
		}else{
			header('location:'.base_url());
		}
	}		
	public function edit()
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
			
			$d['judul'] = "Ubah Info Surat Keterangan Untuk Nikah NA";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM skun_na WHERE nmr_surat='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['nmr_surat']		=$id;
					$d['nomor']			=$db->nomor;
					$d['tgl_surat']		=$this->app_model->tgl_str($db->tgl_surat);
					$d['nik1']			=$db->nik1;
					$d['skun_na_nama1']	=$db->skun_na_nama1;
					$d['tmp_lahir1']	=$db->tmp_lahir1;
					$d['tgl_lahir1']	=$this->app_model->tgl_str($db->tgl_lahir1);
					$d['jk1']			=$db->jk1;
					$d['aga_id1']		=$db->aga_id1;
					$d['kew_id1']		=$db->kew_id1;
					$d['pek_id1']		=$db->pek_id1;
					$d['alamat1']		=$db->alamat1;
					$d['rt1']			=$db->rt1;
					$d['rw1']			=$db->rw1;
					$d['kodepos1']		=$db->kodepos1;
					$d['propinsi1']		=$db->propinsi1;
					$d['bio_kota1']			=$db->kota1;
					$d['kecamatan1']	=$db->kecamatan1;
					$d['kelurahan1']	=$db->kelurahan1;
					$d['bin_binti']		=$db->bin_binti;
					$d['status1']		=$db->status1;
					$d['status2']		=$db->status2;
					
					$d['nik2']			=$db->nik2;
					$d['skun_na_nama2']	=$db->skun_na_nama2;
					$d['tmp_lahir2']	=$db->tmp_lahir2;
					$d['tgl_lahir2']	=$this->app_model->tgl_str($db->tgl_lahir2);
					$d['jk2']			=$db->jk2;
					$d['kew_id2']		=$db->kew_id2;
					$d['pek_id2']		=$db->pek_id2;
					$d['aga_id2']		=$db->aga_id2;
					$d['alamat2']		=$db->alamat2;
					$d['rt2']			=$db->rt2;
					$d['rw2']			=$db->rw2;
					$d['kodepos2']		=$db->kodepos2;
					$d['propinsi2']		=$db->propinsi2;
					$d['bio_kota2']			=$db->kota2;
					$d['kecamatan2']	=$db->kecamatan2;
					$d['kelurahan2']	=$db->kelurahan2;
					
					$d['nik3']			=$db->nik3;
					$d['skun_na_nama3']	=$db->skun_na_nama3;
					$d['tmp_lahir3']	=$db->tmp_lahir3;
					$d['tgl_lahir3']	=$this->app_model->tgl_str($db->tgl_lahir3);
					$d['jk3']			=$db->jk3;
					$d['kew_id3']		=$db->kew_id3;
					$d['pek_id3']		=$db->pek_id3;
					$d['aga_id3']		=$db->aga_id3;
					$d['alamat3']		=$db->alamat3;
					$d['rt3']			=$db->rt3;
					$d['rw3']			=$db->rw3;
					$d['kodepos3']		=$db->kodepos3;
					$d['propinsi3']		=$db->propinsi3;
					$d['bio_kota3']			=$db->kota3;
					$d['kecamatan3']	=$db->kecamatan3;
					$d['kelurahan3']	=$db->kelurahan3;
					
					$d['ttd_jenis']		=$db->ttd_jenis;
					$d['ttd_kode']		=$db->ttd_kode;
					$d['tgl_pengajuan']	=$this->app_model->tgl_str($db->tgl_pengajuan);
				}
			}else{
					$d['nmr_surat']		=$id;
					$d['nomor']		='';
					$d['tgl_surat']		='';
					$d['nik1']		='';
					$d['skun_na_nama1']	='';
					$d['tmp_lahir1']	='';
					$d['tgl_lahir1']	='';
					$d['jk1']		='';
					$d['kew_id1']		='';
					$d['pek_id1']		='';
					$d['aga_id1']		='';
					$d['alamat1']		='';
					$d['kodepos1']		='';
					$d['rt']			='';
					$d['rw1']			='';
					$d['bio_kota1']			='';
					$d['propinsi1']		='';
					$d['kelurahan1']	='';
					$d['kecamatan1']	='';
					$d['bin_binti']		='';
					$d['status1']		='';
					$d['status2']		='';
					
					$d['nik2']			='';
					$d['skun_na_nama2']	='';
					$d['tmp_lahir2']	='';
					$d['tgl_lahir2']	='';
					$d['jk2']			='';
					$d['kew_id2']		='';
					$d['pek_id2']		='';
					$d['aga_id2']		='';
					$d['alamat2']		='';
					$d['kodepos2']		='';
					$d['rt2']			='';
					$d['rw2']			='';
					$d['bio_kota2']			='';
					$d['propinsi2']		='';
					$d['kelurahan2']	='';
					$d['kecamatan2']	='';
					
					$d['nik3']		='';
					$d['skun_na_nama3']	='';
					$d['tmp_lahir3']	='';
					$d['tgl_lahir3']	='';
					$d['jk3']		='';
					$d['kew_id3']		='';
					$d['pek_id3']		='';
					$d['aga_id3']		='';
					$d['alamat3']		='';
					$d['kodepos3']		='';
					$d['rt3']			='';
					$d['rw3']			='';
					$d['bio_kota3']			='';
					$d['propinsi3']		='';
					$d['kelurahan3']	='';
					$d['kecamatan3']	='';
					
					$d['ttd_jenis']		='';
					$d['ttd_kode']		='';
					$d['tgl_pengajuan']	='';
				}
						
			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text_pek = "SELECT * FROM pekerjaan";
			$d['l_pekerjaan'] = $this->app_model->manualQuery($text_pek);
			
			$text_jk = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text_jk);
			
			$text_kew = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text_kew);

			$text4 = "SELECT * FROM sta_nikah";
			$d['l_status'] = $this->app_model->manualQuery($text4);
			
			$text_propinsi1 = "SELECT * FROM propinsi";
			$d['l_propinsi1'] = $this->app_model->manualQuery($text_propinsi1);
						
			$text_kota1 = "SELECT * FROM kota where kd_propinsi='$db->propinsi1' ORDER BY nm_kota ASC";
			$d['l_kota1'] = $this->app_model->manualQuery($text_kota1);
			
			$text_kecamatan1 = "SELECT * FROM kecamatan where kd_kota='$db->kota1' AND kd_propinsi='$db->propinsi1' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan1'] = $this->app_model->manualQuery($text_kecamatan1);
			
			$text_kelurahan1 = "SELECT * FROM kelurahan where kd_kecamatan='$db->kecamatan1' AND kd_kota='$db->kota1' AND kd_propinsi='$db->propinsi1'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan1'] = $this->app_model->manualQuery($text_kelurahan1);

			$text_propinsi2 = "SELECT * FROM propinsi";
			$d['l_propinsi2'] = $this->app_model->manualQuery($text_propinsi2);
						
			$text_kota2 = "SELECT * FROM kota where kd_propinsi='$db->propinsi2' ORDER BY nm_kota ASC";
			$d['l_kota2'] = $this->app_model->manualQuery($text_kota2);
			
			$text_kecamatan2 = "SELECT * FROM kecamatan where kd_kota='$db->kota2' AND kd_propinsi='$db->propinsi2' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan2'] = $this->app_model->manualQuery($text_kecamatan2);
			
			$text_kelurahan2 = "SELECT * FROM kelurahan where kd_kecamatan='$db->kecamatan2' AND kd_kota='$db->kota2' AND kd_propinsi='$db->propinsi2'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan2'] = $this->app_model->manualQuery($text_kelurahan2);	

			$text_propinsi3 = "SELECT * FROM propinsi";
			$d['l_propinsi3'] = $this->app_model->manualQuery($text_propinsi3);
						
			$text_kota3 = "SELECT * FROM kota where kd_propinsi='$db->propinsi3' ORDER BY nm_kota ASC";
			$d['l_kota3'] = $this->app_model->manualQuery($text_kota3);
			
			$text_kecamatan3 = "SELECT * FROM kecamatan where kd_kota='$db->kota3' AND kd_propinsi='$db->propinsi3' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan3'] = $this->app_model->manualQuery($text_kecamatan3);
			
			$text_kelurahan3 = "SELECT * FROM kelurahan where kd_kecamatan='$db->kecamatan3' AND kd_kota='$db->kota3' AND kd_propinsi='$db->propinsi3'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan3'] = $this->app_model->manualQuery($text_kelurahan3);
			
			$text_lurah = "SELECT * FROM penandatangan where ttd_jenis='$db->ttd_jenis' ORDER BY ttd_nama ASC";
			$d['l_ttd_nama'] = $this->app_model->manualQuery($text_lurah);
			
			$d['content'] = $this->load->view('skun_na/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("DELETE FROM skun_na WHERE nmr_surat='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/skun_na'>";			
		}else{
			header('location:'.base_url());
		}
	}
	public function checkdata()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id['nmr_surat']= $this->input->post('nmr_surat');
			
			$data = $this->app_model->getSelectedData("skun_na",$id);
				if($data->num_rows()<= 0){
					echo '{"success":false}'; 
				}else{
					echo '{"success":true}'; 
				}		
		}else{
			header('location:'.base_url());
		}
	}
	public function ttd()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$p = $this->input->post('ttd_jenis',TRUE);
			$by = null;
			$bx = null;
			if($p=='1'){
				$text_lurah = "SELECT * FROM penandatangan WHERE ttd_jenis='1'";
				$d['ttd_lurah'] = $this->app_model->manualQuery($text_lurah);	
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($d['ttd_lurah']->result() as $row)
				{
					$by .= "<option value='".$row->ttd_kode."'>".$row->ttd_nama."</option>";
				}
			}else if($p=='2'){
				$text_an = "SELECT * FROM penandatangan WHERE ttd_jenis='2'";
				$d['ttd_an'] = $this->app_model->manualQuery($text_an);	
				$bx .= "<option value=''>-PILIH-</option>";
				foreach ($d['ttd_an']->result() as $row)
				{
					$by .= "<option value='".$row->ttd_kode."'>".$row->ttd_nama."</option>";
				}
			}
			else{
				$by .= "<option value=''>-PILIH-</option>";
			}
			echo  $bx.$by;
		}else{
			header('location:'.base_url());
		}
	}
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
				
				
				$up['tgl_surat']		= $this->app_model->tgl_sql($this->input->post('tgl_surat'));
				$up['nomor']				= $this->input->post('nomor');
				$up['nik1']				= $this->input->post('nik1');
				$up['skun_na_nama1']	= $this->input->post('skun_na_nama1');
				$up['tmp_lahir1']		= $this->input->post('tmp_lahir1');
				$up['tgl_lahir1']		= $this->app_model->tgl_sql($this->input->post('tgl_lahir1'));
				$up['jk1']				= $this->input->post('jk1');
				$up['kew_id1']			= $this->input->post('kew_id1');
				$up['pek_id1']			= $this->input->post('pek_id1');
				$up['aga_id1']			= $this->input->post('aga_id1');
				$up['alamat1']			= $this->input->post('alamat1');
				$up['rt1']				=$this->input->post('rt1');
				$up['rw1']				=$this->input->post('rw1');
				$up['kodepos1']			=$this->input->post('kodepos1');
				$up['propinsi1']		=$this->input->post('propinsi1');
				$up['kota1']			=$this->input->post('kota1');
				$up['kecamatan1']		=$this->input->post('kecamatan1');
				$up['kelurahan1']		=$this->input->post('kelurahan1');
				$up['bin_binti']		= $this->input->post('bin_binti');
				$up['status1']			= $this->input->post('status1');
				$up['status2']			= $this->input->post('status2');
				
				$up['nik2']				= $this->input->post('nik2');
				$up['skun_na_nama2']	= $this->input->post('skun_na_nama2');
				$up['tmp_lahir2']		= $this->input->post('tmp_lahir2');
				$up['tgl_lahir2']		= $this->app_model->tgl_sql($this->input->post('tgl_lahir2'));
				$up['jk2']				= $this->input->post('jk2');
				$up['kew_id2']			= $this->input->post('kew_id2');
				$up['pek_id2']			= $this->input->post('pek_id2');
				$up['aga_id2']			= $this->input->post('aga_id2');
				$up['alamat2']			= $this->input->post('alamat2');
				$up['rt2']				=$this->input->post('rt2');
				$up['rw2']				=$this->input->post('rw2');
				$up['kodepos2']			=$this->input->post('kodepos2');
				$up['propinsi2']		=$this->input->post('propinsi2');
				$up['kota2']			=$this->input->post('kota2');
				$up['kecamatan2']		=$this->input->post('kecamatan2');
				$up['kelurahan2']		=$this->input->post('kelurahan2');
				
				$up['nik3']				= $this->input->post('nik3');
				$up['skun_na_nama3']	= $this->input->post('skun_na_nama3');
				$up['tmp_lahir3']		= $this->input->post('tmp_lahir3');
				$up['tgl_lahir3']		= $this->app_model->tgl_sql($this->input->post('tgl_lahir3'));
				$up['jk3']				= $this->input->post('jk3');
				$up['kew_id3']			= $this->input->post('kew_id3');
				$up['pek_id3']			= $this->input->post('pek_id3');
				$up['aga_id3']			= $this->input->post('aga_id3');
				$up['alamat3']			= $this->input->post('alamat3');
				$up['rt3']				=$this->input->post('rt3');
				$up['rw3']				=$this->input->post('rw3');
				$up['kodepos3']			=$this->input->post('kodepos3');
				$up['propinsi3']		=$this->input->post('propinsi3');
				$up['kota3']			=$this->input->post('kota3');
				$up['kecamatan3']		=$this->input->post('kecamatan3');
				$up['kelurahan3']		=$this->input->post('kelurahan3');
				
				$up['ttd_jenis']		=$this->input->post('ttd_jenis');
				$up['ttd_kode']			=$this->input->post('ttd_kode');
				$up['tgl_pengajuan']	= $this->app_model->tgl_sql($this->input->post('tgl_pengajuan'));
				
				$id['nmr_surat'] = $this->input->post('nmr_surat');
				
				$data = $this->app_model->getSelectedData("skun_na",$id);

				if($data->num_rows()>0){
					$up['nmr_surat'] = $this->input->post('nmr_surat');
					$this->app_model->updateData("skun_na",$up,$id);
					$data="Update data Sukses<span style='diplay:none;>".$up['nmr_surat']."</span>";
					echo $data;	
				}else{
					$kode = $this->app_model->MaxKodeSkna();
					$up['nmr_surat'] = $kode;
					$this->app_model->insertData("skun_na",$up);
					$data="Simpan data Sukses<span style='diplay:none;>".$up['nmr_surat']."</span>";
					echo $data;	
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */