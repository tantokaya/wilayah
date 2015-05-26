<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skl extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman skl
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			$cari_tgl = $this->app_model->tgl_sql($this->input->post('cari_tgl'));
			if($cari!=''){
				$where = " WHERE nmr_surat LIKE '%$cari%' OR skl_nama1 LIKE '%$cari%' OR nik1 LIKE '%$cari%' OR skl_nama2 LIKE '%$cari%' OR nik2 LIKE '%$cari%'  OR skl_nama3 LIKE '%$cari%'";
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

			
			$d['judul']="Surat Keterangan Kelahiran";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM skl $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/skl/index/';
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
			

			$text = "SELECT * FROM skl $where 
					ORDER BY tgl_surat DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('skl/view', $d, true);		
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

			$d['judul']="Tambah Surat Keterangan Kelahiran";
			
			$tgl	= date('d-m-Y');
			$tgl3	= date('d-m-Y');
			
			$d['nmr_surat']			='';
			$d['nomor']			='';
			$d['tgl_surat']			=$tgl3;
			$d['nik']				='';
			$d['no_kk1']			='';
			$d['skl_nama1']			='';
			$d['tmp_lahir1']		='';
			$d['tgl_lahir1']		='';
			$d['kew_id1']			='';
			$d['aga_id1']			='';
			$d['no_kk2']			='';
			$d['alamat1']			='';
			$d['kodepos1']			='';
			$d['rt1']				='';
			$d['rw1']				='';
			$d['bio_kota1']				='';
			$d['propinsi1']			='';
			$d['kelurahan1']		='';
			$d['kecamatan1']		='';
			$d['nik2']				='';
			$d['skl_nama2']			='';
			$d['tmp_lahir2']		='';
			$d['tgl_lahir2']		='';
			$d['kew_id2']			='';
			$d['aga_id2']			='';
			$d['alamat2']			='';
			$d['kodepos2']			='';
			$d['rt2']				='';
			$d['rw2']				='';
			$d['bio_kota2']				='';
			$d['propinsi2']			='';
			$d['kelurahan2']		='';
			$d['kecamatan2']		='';
			$d['skl_nama3']			='';
			$d['tmp_lahir3']		='';
			$d['tgl_lahir3']		='';
			$d['jk3']				='';
			$d['lahir_id']			='';
			$d['pk_id']				='';
			$d['tk_id']				='';
			$d['skl_kembar']		='';
			$d['skl_kel']			='';
			$d['skl_kec']			='';
			$d['ttd_jenis']			='';
			$d['ttd_kode']			='';
			$d['tgl_pengajuan']		=$tgl;
			
			
			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text_pek = "SELECT * FROM pekerjaan";
			$d['l_pekerjaan'] = $this->app_model->manualQuery($text_pek);
			
			$text_jk = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text_jk);
			
			$text_kew = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text_kew);
			
			$text_lahir = "SELECT * FROM lahir";
			$d['l_lahir'] = $this->app_model->manualQuery($text_lahir);
			
			$text_tklahir = "SELECT * FROM tk";
			$d['l_tklahir'] = $this->app_model->manualQuery($text_tklahir);
			
			$text_pklahir = "SELECT * FROM pk";
			$d['l_pklahir'] = $this->app_model->manualQuery($text_pklahir);
			
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
			
			$text_lurah = "SELECT * FROM penandatangan where ttd_jenis='0' ORDER BY ttd_nama ASC";
			$d['l_ttd_nama'] = $this->app_model->manualQuery($text_lurah);
			
			$d['content'] = $this->load->view('skl/form', $d, true);		
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
			
			$d['judul'] = "Ubah Info Surat Keterangan Kelahiran";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM skl WHERE nmr_surat='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['nmr_surat']			=$id;
					$d['nomor']				=$db->nomor;
					$d['tgl_surat']			=$this->app_model->tgl_sql($db->tgl_surat);
					$d['nik']				=$db->nik1;
					$d['no_kk1']			=$db->no_kk1;
					$d['skl_nama1']			=$db->skl_nama1;
					$d['tmp_lahir1']		=$db->tmp_lahir1;
					$d['tgl_lahir1']		=$this->app_model->tgl_sql($db->tgl_lahir1);
					$d['kewar1']			=$db->kew_id1;
					$d['agama1']			=$db->aga_id1;
					$d['alamat1']			=$db->alamat1;
					$d['rt1']				=$db->rt1;
					$d['rw1']				=$db->rw1;
					$d['kodepos1']			=$db->kodepos1;
					$d['propinsi1']			=$db->propinsi1;
					$d['bio_kota1']				=$db->kota1;
					$d['kecamatan1']		=$db->kecamatan1;
					$d['kelurahan1']		=$db->kelurahan1;
					
					$d['nik2']				=$db->nik2;
					$d['no_kk2']			=$db->no_kk2;
					$d['skl_nama2']			=$db->skl_nama2;
					$d['tmp_lahir2']		=$db->tmp_lahir2;
					$d['tgl_lahir2']		=$this->app_model->tgl_sql($db->tgl_lahir2);
					$d['kewar2']			=$db->kew_id2;
					$d['agama2']			=$db->aga_id2;
					$d['alamat2']			=$db->alamat2;					
					$d['rt2']				=$db->rt2;
					$d['rw2']				=$db->rw2;
					$d['kodepos2']			=$db->kodepos2;
					$d['propinsi2']			=$db->propinsi2;
					$d['bio_kota2']				=$db->kota2;
					$d['kecamatan2']		=$db->kecamatan2;
					$d['kelurahan2']		=$db->kelurahan2;
					
					$d['skl_nama3']			=$db->skl_nama3;
					$d['tmp_lahir3']		=$db->tmp_lahir3;
					$d['tgl_lahir3']		=$this->app_model->tgl_sql($db->tgl_lahir3);
					$d['lahir_id']			=$db->lahir_id;
					$d['jk3']				=$db->jk3;
					$d['pk_id']				=$db->pk_id;
					$d['tk_id']				=$db->tk_id;
					$d['skl_kel']			=$db->skl_kel;
					$d['skl_kec']			=$db->skl_kec;
					$d['skl_kembar']		=$db->skl_kembar;
					$d['ttd_jenis']			=$db->ttd_jenis;
					$d['ttd_kode']			=$db->ttd_kode;
					$d['tgl_pengajuan']		=$this->app_model->tgl_sql($db->tgl_pengajuan);
				}
			}else{
					$d['nmr_surat']			=$id;
					$d['nomor']			='';
					$d['tgl_surat']			='';
					$d['nik']				='';
					$d['skl_nama1']			='';
					$d['tmp_lahir1']		='';
					$d['tgl_lahir1']		='';
					$d['kew_id1']			='';
					$d['aga_id1']			='';
					$d['no_kk1']			='';
					$d['alamat1']			='';
					$d['kodepos1']			='';
					$d['rt1']				='';
					$d['rw1']				='';
					$d['bio_kota1']				='';
					$d['propinsi1']			='';
					$d['kelurahan1']		='';
					$d['kecamatan1']		='';
					
					$d['nik2']				='';
					$d['no_kk2']			='';
					$d['skl_nama2']			='';
					$d['tmp_lahir2']		='';
					$d['tgl_lahir2']		='';
					$d['kew_id2']			='';
					$d['aga_id2']			='';
					$d['alamat2']			='';
					$d['kodepos2']			='';
					$d['rt2']				='';
					$d['rw2']				='';
					$d['bio_kota2']				='';
					$d['propinsi2']			='';
					$d['kelurahan2']		='';
					$d['kecamatan2']		='';
					
					$d['skl_nama3']			='';
					$d['tmp_lahir3']		='';
					$d['tgl_lahir3']		='';
					$d['jk3']				='';
					$d['lahir_id']			='';
					$d['pk_id']				='';
					$d['tk_id']				='';
					$d['skl_kembar']		='';
					$d['skl_kel']			='';
					$d['skl_kec']			='';
					$d['ttd_jenis']			='';
					$d['ttd_kode']			='';
					$d['tgl_pengajuan']		='';
				}
					
			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text_pek = "SELECT * FROM pekerjaan";
			$d['l_pekerjaan'] = $this->app_model->manualQuery($text_pek);
			
			$text_jk = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text_jk);
			
			$text_kew = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text_kew);
			
			$text_lahir = "SELECT * FROM lahir";
			$d['l_lahir'] = $this->app_model->manualQuery($text_lahir);
			
			$text_tklahir = "SELECT * FROM tk";
			$d['l_tklahir'] = $this->app_model->manualQuery($text_tklahir);
			
			$text_pklahir = "SELECT * FROM pk";
			$d['l_pklahir'] = $this->app_model->manualQuery($text_pklahir);
			
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
			
			$text_lurah = "SELECT * FROM penandatangan where ttd_jenis='$db->ttd_jenis' ORDER BY ttd_nama ASC";
			$d['l_ttd_nama'] = $this->app_model->manualQuery($text_lurah);
			
			$d['content'] = $this->load->view('skl/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM skl WHERE nmr_surat='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/skl'>";			
		}else{
			header('location:'.base_url());
		}
	}
	public function checkdata()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id['nmr_surat']= $this->input->post('nmr_surat');
			
			$data = $this->app_model->getSelectedData("skl",$id);
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
				$up['nik1']				= $this->input->post('nik');
				$up['no_kk1']			= $this->input->post('no_kk1');
				$up['skl_nama1']		= $this->input->post('skl_nama1');
				$up['tmp_lahir1']		= $this->input->post('tmp_lahir1');
				$up['tgl_lahir1']		= $this->app_model->tgl_sql($this->input->post('tgl_lahir1'));
				$up['kew_id1']			= $this->input->post('kew_id1');
				$up['aga_id1']			= $this->input->post('aga_id1');
				$up['alamat1']			= $this->input->post('alamat1');
				$up['rt1']				=$this->input->post('rt1');
				$up['rw1']				=$this->input->post('rw1');
				$up['kodepos1']			=$this->input->post('kodepos1');
				$up['propinsi1']		=$this->input->post('propinsi1');
				$up['kota1']			=$this->input->post('bio_kota1');
				$up['kecamatan1']		=$this->input->post('kecamatan1');
				$up['kelurahan1']		=$this->input->post('kelurahan1');
				
				$up['nik2']				= $this->input->post('nik2');
				$up['no_kk2']			= $this->input->post('no_kk2');
				$up['skl_nama2']		= $this->input->post('skl_nama2');
				$up['tmp_lahir2']		= $this->input->post('tmp_lahir2');
				$up['tgl_lahir2']		= $this->app_model->tgl_sql($this->input->post('tgl_lahir2'));
				$up['kew_id2']			= $this->input->post('kew_id2');
				$up['aga_id2']			= $this->input->post('aga_id2');
				$up['alamat2']			= $this->input->post('alamat2');
				$up['rt2']				=$this->input->post('rt2');
				$up['rw2']				=$this->input->post('rw2');
				$up['kodepos2']			=$this->input->post('kodepos2');
				$up['propinsi2']		=$this->input->post('propinsi2');
				$up['kota2']			=$this->input->post('bio_kota2');
				$up['kecamatan2']		=$this->input->post('kecamatan2');
				$up['kelurahan2']		=$this->input->post('kelurahan2');
				
				$up['skl_nama3']		= $this->input->post('skl_nama3');
				$up['tmp_lahir3']		= $this->input->post('tmp_lahir3');
				$up['tgl_lahir3']		= $this->app_model->tgl_sql($this->input->post('tgl_lahir3'));
				$up['jk3']				= $this->input->post('jk3');
				$up['lahir_id']			= $this->input->post('lahir_id');
				$up['pk_id']			= $this->input->post('pk_id');
				$up['tk_id']			= $this->input->post('tk_id');
				$up['skl_kembar']		= $this->input->post('skl_kembar');
				$up['skl_kel']			= $this->input->post('skl_kel');
				$up['skl_kec']			= $this->input->post('skl_kec');
				$up['ttd_jenis']		=$this->input->post('ttd_jenis');
				$up['ttd_kode']			=$this->input->post('ttd_kode');
				$up['tgl_pengajuan']	= $this->app_model->tgl_sql($this->input->post('tgl_pengajuan'));
                $up['nm_surat']		    = 'Surat Keterangan Kelahiran';
				
				$id['nmr_surat']=$this->input->post('nmr_surat');
				
				$data = $this->app_model->getSelectedData("skl",$id);
				if($data->num_rows()>0){
					$up['nmr_surat'] = $this->input->post('nmr_surat');
					$this->app_model->updateData("skl",$up,$id);
					$data="Update data Sukses<span style='diplay:none;>".$up['nmr_surat']."</span>";
					echo $data;	
				}else{
					$kode = $this->app_model->MaxKodeskl();
					$up['nmr_surat'] = $kode;
					$this->app_model->insertData("skl",$up);
					$data = "Simpan data Sukses<span style='diplay:none;>".$up['nmr_surat']."</span>";
					echo $data;		
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */