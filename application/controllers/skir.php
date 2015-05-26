<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skir extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman skir
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			$cari_tgl = $this->app_model->tgl_sql($this->input->post('cari_tgl'));
			if($cari!=''){
				$where = " WHERE nmr_surat LIKE '%$cari%' OR skir_nama LIKE '%$cari%' OR nik LIKE '%$cari%'";
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

			
			$d['judul']="Surat Keterangan Ijin Keramaian";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM skir $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/skir/index/';
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
			

			$text = "SELECT * FROM skir $where 
					ORDER BY tgl_surat DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('skir/view', $d, true);		
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

			$d['judul']="Tambah Surat Keterangan Ijin Keramaian";
			
			$tgl	= date('d-m-Y');
			$tgl2	= date('d-m-Y');
			$tgl3	= date('d-m-Y');
			
			$d['nomor']		='';
			$d['nmr_surat']		='';
			$d['tgl_surat']		=$tgl3;
			$d['nik']			='';
			$d['no_kk']			='';
			$d['skir_nama']		='';
			$d['tmp_lahir']		='';
			$d['tgl_lahir']		='';
			$d['pek_id']		='';
			$d['alamat']		='';
			$d['kodepos']		='';
			$d['rt']			='';
			$d['rw']			='';
			$d['bio_kota']			='';
			$d['propinsi']		='';
			$d['kelurahan']		='';
			$d['kecamatan']		='';
			$d['tgl_ramai']		=$tgl2;
			$d['wkt_ramai']		='';
			$d['kegiatan']		='';
			$d['ttd_jenis']		='';
			$d['ttd_kode']		='';
			$d['ttd_mengetahui']	='';
			$d['tgl_pengajuan']	=$tgl;
			
			
			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text_pek = "SELECT * FROM pekerjaan";
			$d['l_pekerjaan'] = $this->app_model->manualQuery($text_pek);
			
			$text_jk = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text_jk);
			
			$text_kew = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text_kew);
			
			$text_propinsi = "SELECT * FROM propinsi";
			$d['l_propinsi'] = $this->app_model->manualQuery($text_propinsi);
						
			$text_kota = "SELECT * FROM kota where left(kd_kota,2)='0' ORDER BY nm_kota ASC";
			$d['l_kota'] = $this->app_model->manualQuery($text_kota);
			
			$text_kecamatan = "SELECT * FROM kecamatan where left(kd_kecamatan,4)='0' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan'] = $this->app_model->manualQuery($text_kecamatan);
			
			$text_kelurahan = "SELECT * FROM kelurahan where left(kd_kelurahan,7)='0'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan'] = $this->app_model->manualQuery($text_kelurahan);
			
			$text_lurah = "SELECT * FROM penandatangan where ttd_jenis='0' ORDER BY ttd_nama ASC";
			$d['l_ttd_nama'] = $this->app_model->manualQuery($text_lurah);
			
			$d['content'] = $this->load->view('skir/form', $d, true);		
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
			
			$d['judul'] = "Ubah Info Surat Keterangan Ijin Keramaian";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM skir WHERE nmr_surat='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['nomor']			=$db->nomor;
					$d['nmr_surat']		=$id;
					$d['tgl_surat']		=$this->app_model->tgl_str($db->tgl_surat);
					$d['nik']			=$db->nik;
					$d['no_kk']			=$db->no_kk;
					$d['skir_nama']		=$db->skir_nama;
					$d['tmp_lahir']		=$db->tmp_lahir;
					$d['tgl_lahir']		=$this->app_model->tgl_str($db->tgl_lahir);
					$d['pek_id']		=$db->pek_id;
					$d['alamat']		=$db->alamat;
					$d['rt']			=$db->rt;
					$d['rw']			=$db->rw;
					$d['kodepos']		=$db->kodepos;
					$d['propinsi']		=$db->propinsi;
					$d['bio_kota']			=$db->kota;
					$d['kecamatan']		=$db->kecamatan;
					$d['kelurahan']		=$db->kelurahan;
					$d['tgl_ramai']		=$this->app_model->tgl_str($db->tgl_ramai);
					$d['wkt_ramai']		=$db->wkt_ramai;
					$d['kegiatan']		=$db->kegiatan;
					$d['ttd_jenis']		=$db->ttd_jenis;
					$d['ttd_kode']		=$db->ttd_kode;
					$d['ttd_mengetahui']	=$db->ttd_mengetahui;
					$d['tgl_pengajuan']	=$this->app_model->tgl_str($db->tgl_pengajuan);
				}
			}else{
					$d['nmr_surat']		=$id;
					$d['nomor']		='';
					$d['tgl_surat']		='';
					$d['nik']			='';
					$d['no_kk']			='';
					$d['skir_nama']		='';
					$d['tmp_lahir']		='';
					$d['tgl_lahir']		='';
					$d['pek_id']		='';
					$d['alamat']		='';
					$d['kodepos']		='';
					$d['rt']			='';
					$d['rw']			='';
					$d['bio_kota']			='';
					$d['propinsi']		='';
					$d['kelurahan']		='';
					$d['kecamatan']		='';
					$d['tgl_ramai']		='';
					$d['wkt_ramai']		='';
					$d['kegiatan']		='';
					$d['ttd_jenis']		='';
					$d['ttd_kode']		='';
					$d['ttd_mengetahui']	='';
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
			
			$text_propinsi = "SELECT * FROM propinsi";
			$d['l_propinsi'] = $this->app_model->manualQuery($text_propinsi);
						
			$text_kota = "SELECT * FROM kota where kd_propinsi='$db->propinsi' ORDER BY nm_kota ASC";
			$d['l_kota'] = $this->app_model->manualQuery($text_kota);
			
			$text_kecamatan = "SELECT * FROM kecamatan where kd_kota='$db->kota' AND kd_propinsi='$db->propinsi' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan'] = $this->app_model->manualQuery($text_kecamatan);
			
			$text_kelurahan = "SELECT * FROM kelurahan where kd_kecamatan='$db->kecamatan' AND kd_kota='$db->kota' AND kd_propinsi='$db->propinsi'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan'] = $this->app_model->manualQuery($text_kelurahan);		
			
			$text_lurah = "SELECT * FROM penandatangan where ttd_jenis='$db->ttd_jenis' ORDER BY ttd_nama ASC";
			$d['l_ttd_nama'] = $this->app_model->manualQuery($text_lurah);
			
			$d['content'] = $this->load->view('skir/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM skir WHERE nmr_surat='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/skir'>";			
		}else{
			header('location:'.base_url());
		}
	}
	public function checkdata()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id['nmr_surat']= $this->input->post('nmr_surat');
			
			$data = $this->app_model->getSelectedData("skir",$id);
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
				
				$up['nomor']				= $this->input->post('nomor');
				$up['tgl_surat']		= $this->app_model->tgl_sql($this->input->post('tgl_surat'));
				$up['nik']				= $this->input->post('nik');
				$up['no_kk']			= $this->input->post('no_kk');
				$up['skir_nama']		= $this->input->post('skir_nama');
				$up['tmp_lahir']		= $this->input->post('tmp_lahir');
				$up['tgl_lahir']		= $this->app_model->tgl_sql($this->input->post('tgl_lahir'));
				$up['pek_id']			= $this->input->post('pek_id');
				$up['alamat']			= $this->input->post('alamat');				
				$up['rt']				=$this->input->post('rt');
				$up['rw']				=$this->input->post('rw');
				$up['kodepos']			=$this->input->post('kodepos');
				$up['propinsi']			=$this->input->post('propinsi');
				$up['kota']				=$this->input->post('bio_kota');
				$up['kecamatan']		=$this->input->post('kecamatan');
				$up['kelurahan']		=$this->input->post('kelurahan');
				$up['tgl_ramai']		= $this->app_model->tgl_sql($this->input->post('tgl_ramai'));
				$up['wkt_ramai']		= $this->input->post('wkt_ramai');
				$up['kegiatan']			= $this->input->post('kegiatan');
				$up['ttd_jenis']		=$this->input->post('ttd_jenis');
				$up['ttd_kode']			=$this->input->post('ttd_kode');
				$up['ttd_mengetahui']		=$this->input->post('ttd_mengetahui');
				$up['tgl_pengajuan']	= $this->app_model->tgl_sql($this->input->post('tgl_pengajuan'));
				
				$id['nmr_surat']=$this->input->post('nmr_surat');
				
				$data = $this->app_model->getSelectedData("skir",$id);
				if($data->num_rows()>0){
					$up['nmr_surat'] = $this->input->post('nmr_surat');
					$this->app_model->updateData("skir",$up,$id);
					$data="Update data Sukses<span style='diplay:none;>".$up['nmr_surat']."</span>";
					echo $data;	
				}else{
					$kode	= $this->app_model->MaxKodeSkir();
					$up['nmr_surat']		= $kode;
					$this->app_model->insertData("skir",$up);
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