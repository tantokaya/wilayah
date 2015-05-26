<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biodata extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman biodata
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = ' ';
			}else{
				$where = " WHERE nik LIKE '%$cari%' OR bio_nama LIKE '%$cari%'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['nama_kelurahan']= $this->config->item('nama_kelurahan');

			
			$d['judul']="Biodata Penduduk";
			
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
			
			$config['base_url'] = site_url() . '/biodata/index/';
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
			
			$d['content'] = $this->load->view('biodata/view', $d, true);		
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

			$d['judul']="Biodata Penduduk";
			
			$d['nik']				='';
			$d['no_kk']				='';
			$d['bio_nama']			='';
			$d['bio_tmp_lahir']		='';
			$d['bio_tgl_lahir']		='';
			$d['bio_goldar']		='';
			$d['bio_agama']			='';
			$d['bio_jk']			='';
			$d['bio_pekerjaan']		='';
			$d['bio_status']		='';
			$d['bio_alamat']		='';
			$d['bio_kodepos']		='';
			$d['bio_rt']			='';
			$d['bio_rw']			='';
			$d['bio_kota']			='';
			$d['bio_propinsi']		='';
			$d['bio_kelurahan']		='';
			$d['bio_kecamatan']		='';

			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM goldar";
			$d['l_goldar'] = $this->app_model->manualQuery($text2);
			
			$text3 = "SELECT * FROM pendidikan";
			$d['l_pendidikan'] = $this->app_model->manualQuery($text3);
			
			$text4 = "SELECT * FROM sta_nikah";
			$d['l_status'] = $this->app_model->manualQuery($text4);
			
			$text5 = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text5);
			
			$text6 = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text6);
			
			$text7 = "SELECT * FROM pekerjaan";
			$d['l_pek'] = $this->app_model->manualQuery($text7);
			
			$text8 = "SELECT * FROM propinsi";
			$d['l_propinsi'] = $this->app_model->manualQuery($text8);
						
			$text11 = "SELECT * FROM kota where left(kd_kota,2)='0' ORDER BY nm_kota ASC";
			$d['l_kota'] = $this->app_model->manualQuery($text11);
			
			$text9 = "SELECT * FROM kecamatan where left(kd_kecamatan,4)='0' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan'] = $this->app_model->manualQuery($text9);
			
			$text10 = "SELECT * FROM kelurahan where left(kd_kelurahan,7)='0'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan'] = $this->app_model->manualQuery($text10);

			$text12 = "SELECT * FROM sta_keluarga";
			$d['l_keluarga'] = $this->app_model->manualQuery($text12);
			
			$d['content'] = $this->load->view('biodata/form', $d, true);		
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
			
			$d['judul'] = "Ubah Info Biodata";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM biodata WHERE nik='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['nik']				=$id;
					$d['no_kk']				=$db->no_kk;
					$d['bio_nama']			=$db->bio_nama;
					$d['bio_tmp_lahir']		=$db->bio_tmp_lahir;
					$d['bio_tgl_lahir']		=$this->app_model->tgl_str($db->bio_tgl_lahir);
					$d['goldar']			=$db->bio_goldar;
					$d['agama']			=$db->bio_agama;
					$d['bio_pendidikan']		=$db->bio_pendidikan;
					$d['jns_kel']			=$db->bio_jk;
					$d['pekerjaan']			=$db->bio_pekerjaan;
					$d['status']			=$db->bio_status;
					$d['bio_alamat']		=$db->bio_alamat;
					$d['bio_kodepos']		=$db->bio_kodepos;
					$d['bio_rt']			=$db->bio_rt;
					$d['bio_rw']			=$db->bio_rw;
					$d['propinsi']			=$db->bio_propinsi;
					$d['bio_kota']			=$db->bio_kota;
					$d['bio_kecamatan']		=$db->bio_kecamatan;
					$d['bio_kelurahan']		=$db->bio_kelurahan;
				}
			}else{
					$d['nik']			=$id;
					$d['no_kk']			=$db->no_kk;
					$d['bio_nama']			=$db->bio_nama;
					$d['bio_tmp_lahir']		=$db->bio_tmp_lahir;
					$d['bio_tgl_lahir']		=$this->app_model->tgl_str($db->bio_tgl_lahir);
					$d['goldar']			=$db->bio_goldar;
					$d['agama']			=$db->bio_agama;
					$d['bio_pendidikan']		=$db->bio_pendidikan;
					$d['jns_kel']			=$db->bio_jk;
					$d['pekerjaan']			=$db->bio_pekerjaan;
					$d['status']			=$db->bio_status;
					$d['bio_alamat']		=$db->bio_alamat;
					$d['bio_kodepos']		=$db->bio_kodepos;
					$d['bio_rt']			=$db->bio_rt;
					$d['bio_rw']			=$db->bio_rw;
					$d['bio_propinsi']		=$db->bio_propinsi;
					$d['bio_kota']			=$db->bio_kota;
					$d['bio_kecamatan']		=$db->bio_kecamatan;
					$d['bio_kelurahan']		=$db->bio_kelurahan;
				}
				
			$text = "SELECT * FROM agama";
			$d['l_agama'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM goldar";
			$d['l_goldar'] = $this->app_model->manualQuery($text2);
			
			$text3 = "SELECT * FROM pendidikan";
			$d['l_pendidikan'] = $this->app_model->manualQuery($text3);
			
			$text4 = "SELECT * FROM sta_nikah";
			$d['l_status'] = $this->app_model->manualQuery($text4);
			
			$text5 = "SELECT * FROM kewarganegaraan";
			$d['l_kew'] = $this->app_model->manualQuery($text5);
			
			$text6 = "SELECT * FROM jk";
			$d['l_jk'] = $this->app_model->manualQuery($text6);
			
			$text7 = "SELECT * FROM pekerjaan";
			$d['l_pek'] = $this->app_model->manualQuery($text7);
			
			$text8 = "SELECT * FROM propinsi";
			$d['l_propinsi'] = $this->app_model->manualQuery($text8);
						
			$text11 = "SELECT * FROM kota where kd_propinsi='$db->bio_propinsi' ORDER BY nm_kota ASC";
			$d['l_kota'] = $this->app_model->manualQuery($text11);
			
			$text9 = "SELECT * FROM kecamatan where kd_kota='$db->bio_kota' AND kd_propinsi='$db->bio_propinsi' ORDER BY nm_kecamatan ASC";
			$d['l_kecamatan'] = $this->app_model->manualQuery($text9);
			
			$text10 = "SELECT * FROM kelurahan where kd_kecamatan='$db->bio_kecamatan' AND kd_kota='$db->bio_kota' AND kd_propinsi='$db->bio_propinsi'  ORDER BY nm_kelurahan ASC";
			$d['l_kelurahan'] = $this->app_model->manualQuery($text10);
			
			$text12 = "SELECT * FROM sta_keluarga";
			$d['l_keluarga'] = $this->app_model->manualQuery($text12);
			
			$d['content'] = $this->load->view('biodata/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM biodata WHERE nik='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/biodata'>";			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
				
				$up['nik']			= $this->input->post('nik');
				$up['no_kk']			= $this->input->post('no_kk');
				$up['bio_nama']			= $this->input->post('bio_nama');
				$up['bio_tmp_lahir']		= $this->input->post('bio_tmp_lahir');
				$up['bio_tgl_lahir']		= $this->app_model->tgl_sql($this->input->post('bio_tgl_lahir'));
				$up['bio_goldar']		= $this->input->post('bio_goldar');
				$up['bio_agama']		= $this->input->post('bio_agama');
				$up['bio_pendidikan']		= $this->input->post('bio_pendidikan');
				$up['bio_jk']			= $this->input->post('bio_jk');
				$up['bio_pekerjaan']		= $this->input->post('bio_pekerjaan');
				$up['bio_status']		= $this->input->post('bio_status');
				$up['bio_alamat']		= $this->input->post('bio_alamat');
				$up['bio_kodepos']		= $this->input->post('bio_kodepos');
				$up['bio_rt']			= $this->input->post('bio_rw');
				$up['bio_rw']			= $this->input->post('bio_rt');
				$up['bio_propinsi']		= $this->input->post('bio_propinsi');
				$up['bio_kota']			= $this->input->post('bio_kota');
				$up['bio_kecamatan']		= $this->input->post('bio_kecamatan');
				$up['bio_kelurahan']		= $this->input->post('bio_kelurahan');
				
				
				$id['nik']=$this->input->post('nik');
				
				$data = $this->app_model->getSelectedData("biodata",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("biodata",$up,$id);
					echo 'Update data Sukses';
				}else{
					$this->app_model->insertData("biodata",$up);
					echo 'Simpan data Sukses';		
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	public function import()
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
			$d['judul']="Import Biodata Penduduk";
						
			$d['content'] = $this->load->view('biodata/import', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	function do_upload()
	{
		$config['upload_path'] = './tmp_upload/';
		$config['allowed_types'] = 'xls';
				
		$this->load->library('upload', $config);
				
		if ( ! $this->upload->do_upload())
		{
			$data = array('error' => $this->upload->display_errors());	
		}
		else
		{
			$data = array('error' => false);
			$upload_data = $this->upload->data();

			$this->load->library('excel_reader');
			$this->excel_reader->setOutputEncoding('CP1251');

			$file =  $upload_data['full_path'];
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			$dataexcel = array();
			for ($i = 2; $i <= $data['numRows']; $i++) {

				if($data['cells'][$i][1] == '') break;
				$dataexcel['nik'] 			= $data['cells'][$i][1];
				$dataexcel['bio_nama']		= $data['cells'][$i][2];
				$dataexcel['bio_tmp_lahir'] = $data['cells'][$i][3];
				$dataexcel['bio_tgl_lahir'] = $this->app_model->tgl_sqlG($data['cells'][$i][4]);
				$dataexcel['bio_agama'] 	= $data['cells'][$i][5];
				$dataexcel['bio_pekerjaan'] = $data['cells'][$i][6];
				$dataexcel['bio_alamat'] 	= $data['cells'][$i][7];
				$dataexcel['bio_rt'] 		= $data['cells'][$i][8];
				$dataexcel['bio_rw'] 		= $data['cells'][$i][9];
				$dataexcel['bio_status'] 	= $data['cells'][$i][10];
				$dataexcel['no_kk']			= $data['cells'][$i][11];
				$dataexcel['bio_propinsi'] 	= $data['cells'][$i][12];
				$dataexcel['bio_kota'] 		= $data['cells'][$i][13];
				$dataexcel['bio_kecamatan'] = $data['cells'][$i][14];
				$dataexcel['bio_kelurahan'] = $data['cells'][$i][15];
				$dataexcel['bio_jk'] 		= $data['cells'][$i][16];
				
				$daftar_biodata[] = $dataexcel; 
			}	
			
			delete_files($upload_data['file_path']);
			$error = '';
			if(isset($daftar_biodata) and is_array($daftar_biodata)) {
			foreach($daftar_biodata as $rs){
				// Cek Ke DB Apakah NIK Sudah Ada ?
				$cek = $this->app_model->cek_nik($rs['nik']);
				
				if($cek){
					$form_data = array(
								'nik' => $rs['nik'],
								'bio_nama' => $rs['bio_nama'],
								'bio_tmp_lahir' => $rs['bio_tmp_lahir'],
								'bio_tgl_lahir' => $rs['bio_tgl_lahir'],
								'bio_agama' => $rs['bio_agama'],
								'bio_pekerjaan' => $rs['bio_pekerjaan'],
								'bio_alamat' => $rs['bio_alamat'],
								'bio_rt' => $rs['bio_rt'],
								'bio_rw' => $rs['bio_rw'],
								'bio_status' => $rs['bio_status'],
								'no_kk' => $rs['no_kk'],
								'bio_propinsi' => $rs['bio_propinsi'],
								'bio_kota' => $rs['bio_kota'],
								'bio_kecamatan' => $rs['bio_kecamatan'],
								'bio_kelurahan' => $rs['bio_kelurahan'],
								'bio_jk' => $rs['bio_jk'],
								
					);
					
					$simpan = $this->app_model->insertData("biodata",$form_data);
					if(!$simpan){
						$error .= "Error" ;
					}
					
				}
			}
		}
			
		}
        echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/biodata/import'>";	
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */