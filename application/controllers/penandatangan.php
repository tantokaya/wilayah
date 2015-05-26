<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penandatangan extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman penandatangan
	 **/
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = " WHERE ttd_jenis='2'";
			}else{
				$where = " WHERE ttd_nip LIKE '%$cari%' OR ttd_nama LIKE '%$cari%' ";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['nama_kelurahan']= $this->config->item('nama_kelurahan');

			
			$d['judul']="Setting Penandatanganan";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM penandatangan $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/penandatangan/index/';
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
			

			$text = "SELECT * FROM penandatangan $where 
					ORDER BY ttd_nip ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('penandatangan/view', $d, true);		
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
			$d['judul']="Tambah Penandatanganan";
			
			$d['ttd_nama']		='';
			$d['ttd_jab']		='';
			$d['ttd_nip']		='';
			$d['ttd_kode']		='';
			
			$d['content'] = $this->load->view('penandatangan/form', $d, true);		
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
			
			$d['judul'] = "Ubah Info Penandatanganan";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM penandatangan WHERE ttd_kode='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['ttd_nip']	=$db->ttd_nip;
					$d['ttd_nama']	=$db->ttd_nama;
					$d['ttd_kode']	=$db->ttd_kode;
					$d['ttd_jab']	=$db->ttd_jab;
					
					
				}
			}else{
					$d['ttd_nip']	=$db->ttd_nip;
					$d['ttd_nama']	='';
					$d['ttd_jab']	='';
					$d['ttd_kode']	='';
				}
						
			$d['content'] = $this->load->view('penandatangan/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM penandatangan WHERE ttd_kode='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/penandatangan'>";			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
				
				$up['ttd_nama']	= $this->input->post('ttd_nama');
				$up['ttd_jab']	= $this->input->post('ttd_jab');
				$up['ttd_nip']	= $this->input->post('ttd_nip');
				$up['ttd_jenis']='2';
				$id['ttd_kode']=$this->input->post('ttd_kode');
				
				$data = $this->app_model->getSelectedData("penandatangan",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("penandatangan",$up,$id);
					echo 'Update data Sukses';
				}else{
					$kode = date('YmHis');
					$up['ttd_kode'] = $kode;
					$this->app_model->insertData("penandatangan",$up);
					echo 'Simpan data Sukses';		
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file penandatangan.php */
/* Location: ./application/controllers/penandatangan.php */