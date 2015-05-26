<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seting extends CI_Controller {

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
			
			$d['judul']="Seting Identitas Aplikasi";
			
			$text = "SELECT * FROM seting WHERE status='1'";
			$hasil = $this->app_model->manualQuery($text);
			$r = $hasil->num_rows();
			if($r>0){
				foreach($hasil->result() as $t){
					$d['status'] 		= $t->status;
					$d['nama_lurah'] 	= $t->nama_lurah;
					$d['nip_lurah'] 	= $t->nip_lurah;
					$d['kd_kelurahan'] 	= $t->kd_kelurahan;
					$d['lok_lurah'] 	= $t->lok_lurah;
					$d['s_kelurahan']	= $t->s_kelurahan;
					$d['s_alamat'] 		= $t->s_alamat;
					$d['s_tlp_fax'] 	= $t->s_tlp_fax;
					$d['s_url'] 		= $t->s_url;
					$d['s_kecamatan'] 	= $t->s_kecamatan;
					$d['no_skdu'] 		= $t->no_skdu;
					$d['no_sku'] 		= $t->no_sku;
					$d['no_sktt'] 		= $t->no_sktt;
					$d['no_sktmp'] 		= $t->no_sktmp;
					$d['no_skpck'] 		= $t->no_skpck;
					$d['no_skbm'] 		= $t->no_skbm;
					$d['no_skir'] 		= $t->no_skir;
					$d['no_skb'] 		= $t->no_skb;
					$d['no_skk'] 		= $t->no_skk;
					$d['no_skl'] 		= $t->no_skl;
					$d['no_skbn'] 		= $t->no_skbn;
					$d['no_sktkt'] 		= $t->no_sktkt;
					$d['no_spn'] 		= $t->no_spn;
					$d['no_skpm'] 		= $t->no_skpm;
					$d['no_siotm'] 		= $t->no_siotm;
					$d['no_skdk'] 		= $t->no_skdk;
					$d['no_skpnh'] 		= $t->no_skpnh;
					$d['no_skaw'] 		= $t->no_skaw;
					$d['no_skppsp'] 	= $t->no_skppsp;
					$d['no_skrt'] 		= $t->no_skrt;
					$d['no_skbmr'] 		= $t->no_skbmr;
					$d['no_skjd'] 		= $t->no_skjd;
					$d['no_skptt'] 		= $t->no_skptt;
				}
			}else{
					$d['status'] 		= '';
					$d['nama_lurah'] 	= '';
					$d['nip_lurah'] 	= '';
					$d['kd_kelurahan'] 	= '';
					$d['lok_lurah'] 	= '';
					$d['s_kelurahan'] 	= '';
					$d['s_alamat'] 		= '';
					$d['s_tlp_fax'] 	= '';
					$d['s_url'] 		= '';
					$d['s_kecamatan'] 	= '';
					$d['no_skdu'] 		= '';
					$d['no_sku'] 		= '';
					$d['no_sktt'] 		= '';
					$d['no_sktmp'] 		= '';
					$d['no_skpck'] 		= '';
					$d['no_skbm'] 		= '';
					$d['no_skir'] 		= '';
					$d['no_skb'] 		= '';
					$d['no_skk'] 		= '';
					$d['no_skl'] 		= '';
					$d['no_skbn'] 		= '';
					$d['no_sktkt'] 		= '';
					$d['no_spn'] 		= '';
					$d['no_skpm'] 		= '';
					$d['no_siotm'] 		= '';
					$d['no_skdk'] 		= '';
					$d['no_skpnh'] 		= '';
					$d['no_skaw'] 		= '';
					$d['no_skppsp'] 	= '';
					$d['no_skrt'] 		= '';
					$d['no_skbmr'] 		= '';
					$d['no_skjd'] 		= '';
					$d['no_skptt'] 		= '';
			}
			
			$d['content'] = $this->load->view('seting', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}

	}	
		
		public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
		
			$up['status']		= $this->input->post('status');
			$up['nama_lurah']	= $this->input->post('nama_lurah');
			$up['nip_lurah']	= $this->input->post('nip_lurah');
			$up['kd_kelurahan']	= $this->input->post('kd_kelurahan');
			$up['lok_lurah']	= $this->input->post('lok_lurah');
			$up['s_kelurahan']	= $this->input->post('s_kelurahan');
			$up['s_alamat']		= $this->input->post('s_alamat');
			$up['s_tlp_fax']	= $this->input->post('s_tlp_fax');
			$up['s_url']		= $this->input->post('s_url');
			$up['s_kecamatan']	= $this->input->post('s_kecamatan');
			$up['no_skdu']		= $this->input->post('no_skdu');
			$up['no_sku']		= $this->input->post('no_sku');
			$up['no_sktt']		= $this->input->post('no_sktt');
			$up['no_sktmp']		= $this->input->post('no_sktmp');
			$up['no_skpck']		= $this->input->post('no_skpck');
			$up['no_skbm']		= $this->input->post('no_skbm');
			$up['no_skir']		= $this->input->post('no_skir');
			$up['no_skb']		= $this->input->post('no_skb');
			$up['no_skk']		= $this->input->post('no_skk');
			$up['no_skl']		= $this->input->post('no_skl');
			$up['no_skbn']		= $this->input->post('no_skbn');
			$up['no_sktkt']		= $this->input->post('no_sktkt');
			$up['no_spn']		= $this->input->post('no_spn');
			$up['no_skpm']		= $this->input->post('no_skpm');
			$up['no_siotm']		= $this->input->post('no_siotm');
			$up['no_skdk']		= $this->input->post('no_skdk');
			$up['no_skpnh']		= $this->input->post('no_skpnh');
			$up['no_skaw']		= $this->input->post('no_skaw');
			$up['no_skppsp']	= $this->input->post('no_skppsp');
			$up['no_skrt']		= $this->input->post('no_skrt');
			$up['no_skbmr']		= $this->input->post('no_skbmr');
			$up['no_skjd']		= $this->input->post('no_skjd');
			$up['no_skptt']		= $this->input->post('no_skptt');
			
			$kode = date('YmHis');
			$p['ttd_kode']	= $kode;
			$p['ttd_nama']	= $this->input->post('nama_lurah');
			$p['ttd_nip']	= $this->input->post('nip_lurah');
			$p['ttd_jenis']	= '1';
			
			$q['ttd_jenis'] = '1';
			
			$id['status']=$this->input->post('status');
				
				$data = $this->app_model->getSelectedData("seting",$id);
				$data2 = $this->app_model->getSelectedData("penandatangan",$q);
				if($data->num_rows()>0){
					$this->app_model->updateData("seting",$up,$id);
					if($data2->num_rows()>0){
						$this->app_model->updateData("penandatangan",$p,$q);
					}else{
						$this->app_model->insertData("penandatangan",$p);
					}
					echo 'Update data Sukses';
				}else{
					$this->app_model->insertData("seting",$up);
					echo 'Simpan data Sukses';		
				}
				redirect('seting');
		}else{
				header('location:'.base_url());
		}
	
		
	}
	
	
	
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */