<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sktot extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman sktot
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = ' ';
			}else{
				$where = " WHERE nmr_surat LIKE '%$cari%' OR sktot_nama LIKE '%$cari%'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['nama_kelurahan']= $this->config->item('nama_kelurahan');

			
			$d['judul']="Surat Keterangan Tentang Orang Tua";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM sktot $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/sktot/index/';
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
			

			$text = "SELECT * FROM sktot $where 
					ORDER BY nmr_surat ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('sktot/view', $d, true);		
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

			$d['judul']="Surat Keterangan Tentang Orang Tua";
			$kode	= $this->app_model->MaxKodeSktot();
			
			$tgl	= date('d-m-Y');
			$tgl3	= date('d-m-Y');
			
			$d['nmr_surat']		=$kode;
			$d['tgl_surat']		=$tgl3;
			$d['nik1']			='';
			$d['no_kk1']			='';
			$d['sktot_nama1']	='';
			$d['tmp_lahir1']	='';
			$d['tgl_lahir1']	='';
			$d['jk1']			='';
			$d['kew_id1']		='';
			$d['pek_id1']		='';
			$d['aga_id1']		='';
			$d['alamat1']		='';
			
			$d['nik2']			='';
			$d['no_kk2']			='';
			$d['sktot_nama2']	='';
			$d['tmp_lahir2']	='';
			$d['tgl_lahir2']	='';
			$d['jk2']			='';
			$d['kew_id2']		='';
			$d['pek_id2']		='';
			$d['aga_id2']		='';
			$d['alamat2']		='';
			
			$d['nik3']			='';
			$d['no_kk3']			='';
			$d['sktot_nama3']	='';
			$d['tmp_lahir3']	='';
			$d['tgl_lahir3']	='';
			$d['jk3']			='';
			$d['kew_id3']		='';
			$d['pek_id3']		='';
			$d['aga_id3']		='';
			$d['alamat3']		='';
			$d['tgl_pengajuan']	=$tgl;
			
			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text_pek = "SELECT * FROM pekerjaan";
			$d['l_pekerjaan'] = $this->app_model->manualQuery($text_pek);
			
			$text_jk = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text_jk);
			
			$text_kew = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text_kew);
			
			$d['content'] = $this->load->view('sktot/form', $d, true);		
			$this->load->view('home',$d);
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
			
			$d['judul'] = "Ubah Info Surat Keterangan Tentang Orang Tua";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM sktot WHERE nmr_surat='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['nmr_surat']		=$id;
					$d['tgl_surat']		=$this->app_model->tgl_str($db->tgl_surat);
					$d['nik1']			=$db->nik1;
					$d['no_kk1']			=$db->no_kk1;
					$d['sktot_nama1']	=$db->sktot_nama1;
					$d['tmp_lahir1']	=$db->tmp_lahir1;
					$d['tgl_lahir1']	=$db->tgl_lahir1;
					$d['jk1']			=$db->jk1;
					$d['kew_id1']		=$db->kew_id1;
					$d['pek_id1']		=$db->pek_id1;
					$d['aga_id1']		=$db->aga_id1;
					$d['alamat1']		=$db->alamat1;
					
					$d['nik2']			=$db->nik2;
					$d['no_kk2']			=$db->no_kk2;
					$d['sktot_nama2']	=$db->sktot_nama2;
					$d['tmp_lahir2']	=$db->tmp_lahir2;
					$d['tgl_lahir2']	=$db->tgl_lahir2;
					$d['jk2']			=$db->jk2;
					$d['kew_id2']		=$db->kew_id2;
					$d['pek_id2']		=$db->pek_id2;
					$d['aga_id2']		=$db->aga_id2;
					$d['alamat2']		=$db->alamat2;
					
					$d['nik3']			=$db->nik3;
					$d['sktot_nama3']	=$db->sktot_nama3;
					$d['tmp_lahir3']	=$db->tmp_lahir3;
					$d['tgl_lahir3']	=$db->tgl_lahir3;
					$d['jk3']			=$db->jk3;
					$d['kew_id3']		=$db->kew_id3;
					$d['pek_id3']		=$db->pek_id3;
					$d['aga_id3']		=$db->aga_id3;
					$d['alamat3']		=$db->alamat3;
					$d['tgl_pengajuan']	=$this->app_model->tgl_str($db->tgl_pengajuan);
				}
			}else{
					$d['nmr_surat']		=$id;
					$d['tgl_surat']		='';
					$d['nik1']			='';
					$d['no_kk1']			='';
					$d['sktot_nama1']	='';
					$d['tmp_lahir1']	='';
					$d['tgl_lahir1']	='';
					$d['jk1']			='';
					$d['kew_id1']		='';
					$d['pek_id1']		='';
					$d['aga_id1']		='';
					$d['alamat1']		='';
					
					$d['nik2']			='';
					$d['sktot_nama2']	='';
					$d['tmp_lahir2']	='';
					$d['tgl_lahir2']	='';
					$d['jk2']			='';
					$d['kew_id2']		='';
					$d['pek_id2']		='';
					$d['aga_id2']		='';
					$d['alamat2']		='';
					
					$d['nik3']			='';
					$d['sktot_nama3']	='';
					$d['tmp_lahir3']	='';
					$d['tgl_lahir3']	='';
					$d['jk3']			='';
					$d['kew_id3']		='';
					$d['pek_id3']		='';
					$d['aga_id3']		='';
					$d['alamat3']		='';
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
			
			$d['content'] = $this->load->view('sktot/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM sktot WHERE nmr_surat='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/sktot'>";			
		}else{
			header('location:'.base_url());
		}
	}
	public function checkdata()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id['nmr_surat']= $this->input->post('nmr_surat');
			
			$data = $this->app_model->getSelectedData("sktot",$id);
				if($data->num_rows()<= 0){
					echo '{"success":false}'; 
				}else{
					echo '{"success":true}'; 
				}		
		}else{
			header('location:'.base_url());
		}
	}
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
				
				$up['nmr_surat']		= $this->input->post('nmr_surat');
				$up['tgl_surat']		= $this->app_model->tgl_sql($this->input->post('tgl_surat'));
				$up['nik1']				= $this->input->post('nik1');
				$up['sktot_nama1']		= $this->input->post('sktot_nama1');
				$up['tmp_lahir1']		= $this->input->post('tmp_lahir1');
				$up['tgl_lahir1']		= $this->input->post('tgl_lahir1');
				$up['jk1']				= $this->input->post('jk1');
				$up['kew_id1']			= $this->input->post('kew_id1');
				$up['pek_id1']			= $this->input->post('pek_id1');
				$up['aga_id1']			= $this->input->post('aga_id1');
				$up['alamat1']			= $this->input->post('alamat1');
				
				$up['nik2']				= $this->input->post('nik2');
				$up['sktot_nama2']		= $this->input->post('sktot_nama2');
				$up['tmp_lahir2']		= $this->input->post('tmp_lahir2');
				$up['tgl_lahir2']		= $this->input->post('tgl_lahir2');
				$up['jk2']				= $this->input->post('jk2');
				$up['kew_id2']			= $this->input->post('kew_id2');
				$up['pek_id2']			= $this->input->post('pek_id2');
				$up['aga_id2']			= $this->input->post('aga_id2');
				$up['alamat2']			= $this->input->post('alamat2');
				
				$up['nik3']				= $this->input->post('nik3');
				$up['sktot_nama3']		= $this->input->post('sktot_nama3');
				$up['tmp_lahir3']		= $this->input->post('tmp_lahir3');
				$up['tgl_lahir3']		= $this->input->post('tgl_lahir3');
				$up['jk3']				= $this->input->post('jk3');
				$up['kew_id3']			= $this->input->post('kew_id3');
				$up['pek_id3']			= $this->input->post('pek_id3');
				$up['aga_id3']			= $this->input->post('aga_id3');
				$up['alamat3']			= $this->input->post('alamat3');
				$up['tgl_pengajuan']	= $this->app_model->tgl_sql($this->input->post('tgl_pengajuan'));
				
				
					$id['nmr_surat']=$this->input->post('nmr_surat');
				
				$data = $this->app_model->getSelectedData("sktot",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("sktot",$up,$id);
					echo 'Update data Sukses';
				}else{
					$this->app_model->insertData("sktot",$up);
					echo 'Simpan data Sukses';		
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */