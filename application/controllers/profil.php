<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends CI_Controller {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman profil
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

			
			$d['judul']="Edit Profil";
			
			$id = $this->session->userdata('username');
			
			$where = " WHERE username='$id'";

			$text = "SELECT * FROM admins $where ";
			$hasil = $this->app_model->manualQuery($text);
			$r = $hasil->num_rows();
			if($r>0){
				foreach($hasil->result() as $t){
					$d['username'] = $id;
					$d['nama_lengkap'] = $t->nama_lengkap;
					$d['pwd'] ='';
					$d['foto'] = $t->foto;
				}
			}else{
				$d['username'] = $id;
				$d['nama_lengkap'] ='';
				$d['pwd'] ='';
				$d['foto'] = '';
			}
			
			$d['content'] = $this->load->view('profil/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
				
				$pwd 	= $this->input->post('pwd');
				$nama 	= $this->input->post('nama_lengkap');
				$user	= mysql_real_escape_string($this->input->post('username'));
				$currentImage=$this->app_model->getImage($this->input->post('username'));
				$this->foto=$currentImage;
				
				if(@$_FILES['foto']['name']!=""){
					$config['upload_path'] = './asset/foto_profil/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['encrypt_name'] = FALSE;
					$config['remove_spaces'] = FALSE;
					$config['max_size']	= '204899999';
					$this->upload_file($config,'foto');
					
				}else{
					$this->foto=$currentImage;
				}
				$f=$this->foto;				
				$up['username']		= $user;
				$up['nama_lengkap']	= $nama;
				$up['password']		= md5($pwd);
				$up['foto']			= $f;
				
				$id['username']=$this->input->post('username');

				$data = $this->app_model->getSelectedData("admins",$id);
				if($data->num_rows()>0){
					if(empty($pwd)){
						$this->app_model->manualQuery("UPDATE admins SET nama_lengkap='$nama',foto='$f' WHERE username='$user'");
					}else{
						$this->app_model->updateData("admins",$up,$id);
					}
					redirect('home');
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	public  function check_file($field,$field_value)
	{
		if(isset($this->custom_errors[$field_value]))
		{
			$this->form_validation->set_message('check_file', $this->custom_errors[$field_value]);
			unset($this->custom_errors[$field_value]);
			return FALSE;
		}
		return TRUE;
	}
	function upload_file($config,$fieldname)
	{
		$this->load->library('upload');
		$this->upload->initialize($config);
		$this->upload->do_upload($fieldname);
		$error = $this->upload->display_errors();
		if(empty($error))
		{
			$data = $this->upload->data();
			$this->$fieldname = $data['file_name'];
		}
		else
		{
			$this->custom_errors[$fieldname] = $error;
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */