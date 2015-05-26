<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman Cetak
	 **/

class Cetak extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
		$this->load->model('crud_model');
		$this->load->database();
		/*cash control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
    }
	
	/***default functin, redirects to login page if no admin logged in yet***/
	public function index()
	{
		if($this->session->userdata('admin_login') == 1)redirect(base_url().'index.php?admin/dashboard' , 'refresh');
		else redirect(base_url().'index.php?login' , 'refresh');
	}

	
	function skdu_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skdu_pdf']		= $this->crud_model->get_a_skdu($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skdu($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_link($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_link($nik);
		
		$this->load->library('fpdf');
		$header_pdf	= $data['header_pdf'];
		$skdu_pdf 	= $data['skdu_pdf'];
		$jk_pdf		= $data['jk_pdf'];
		$aga_pdf 	= $data['agama_pdf'];
		$pek_pdf 	= $data['pekerjaan_pdf'];
		
		$jsk='skdu';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skdu_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skdu_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skdu_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));
		
		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skdu_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skdu_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skdu_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		$skdu_ttl=$skdu_pdf['kota_lahir'].', '.$this->app_model->tgl_indo($skdu_pdf['tgl_lahir']);
		$skdu_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skdu'].' / '.$skdu_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skdu_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdu_pdf['skdu_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(30, 5,$skdu_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdu_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'No.KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdu_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nomor Pokok Wajib Pajak', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdu_pdf['npwp'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skdu_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$skdu_pdf['alamat'].' RT '.$skdu_pdf['rt'].' / RW '.$skdu_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skdu_pdf['rt']=='' && $skdu_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$skdu_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skdu_pdf['alamat'].' RT '.$skdu_pdf['rt'].' / RW '.$skdu_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skdu_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skdu_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(18, 5,'Membuat ', 0,0,'L');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(62, 5,'Surat Keterangan Domisili Usaha ', 0,0,'L');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(50, 5,'Sebagaimana tersebut dibawah ini :', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Cell(45, 5,'a. Nama Perusahaan', 0,0,'L');
		$this->fpdf->Cell(10, 5,':', 0,0,'R');
		$this->fpdf->Cell(60, 5,$skdu_pdf['perusahaan'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Cell(45, 5,'b. Bidang Usaha', 0,0,'L');
		$this->fpdf->Cell(10, 5,':', 0,0,'R');
		$this->fpdf->Cell(60, 5,$skdu_pdf['bid_usaha'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Cell(45, 5,'c. Badan Hukum', 0,0,'L');
		$this->fpdf->Cell(10, 5,':', 0,0,'R');
		$this->fpdf->Cell(60, 5,$skdu_pdf['bdn_hukum'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Cell(45, 5,'d. Akta Pendirian', 0,0,'L');
		$this->fpdf->Cell(10, 5,':', 0,0,'R');
		$this->fpdf->Cell(60, 5,$skdu_pdf['ak_pen'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Cell(45, 5,'e. Alamat Usaha', 0,0,'L');
		$this->fpdf->Cell(10, 5,':', 0,0,'R');
		$this->fpdf->Cell(60, 5,$skdu_pdf['alamat_usaha'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Multicell(170, 5,'Bahwa nama tersebut diatas membuka/memiliki usaha sebagaimana dimaksud diatas dan lokasi usaha tersebut berada diwilayah kerja kami :');
		
		$this->fpdf->Multicell(170, 5,'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya dengan ketentuan sebagai berikut :');
		$this->fpdf->Ln(2);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Multicell(170, 3,'1. Surat Keterangan Domisili Usaha ini bukan merupakan surat izin usaha.');
		$this->fpdf->Ln(2);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Multicell(170, 3,'2. Surat Keterangan Domisili Usaha ini bukan merupakan persyaratan pengurusan perizinan.');
		$this->fpdf->Ln(2);
		
		$this->fpdf->Cell(10, 5,'', 0,0,'R');
		$this->fpdf->Multicell(170, 3,'3. Surat Keterangan Domisili Usaha ini berlaku selama 1(satu) Tahun sejak dikeluarkan.');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skdu_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($skdu_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skdu_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(17);
		
		if($skdu_pdf['ttd_jenis'] !='' && $skdu_pdf['ttd_kode'] !=''){
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		$this->fpdf->Ln();
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
		$this->fpdf->Ln(8);
		}else{
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
		$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Output("Surat_Keterangan_Domilisi_Usaha","I"); 
	}
	
	/***********  SURAT KETERANGAN USAHA (SKU) **************/
	
	function sku_pdf($nik)
	{
		$data['header_pdf']	= $this->crud_model->get_header();
		$data['sku_pdf']	= $this->crud_model->get_a_sku($nik);
		$data['jk_pdf']		= $this->crud_model->get_a_jeniskelamin_sku($nik);
		$data['pek_pdf']		= $this->crud_model->get_a_pekerjaan_sku($nik);
		
		$this->load->library('fpdf');
		$header_pdf	= $data['header_pdf'];
		$sku_pdf 	= $data['sku_pdf'];
		$jk_pdf		= $data['jk_pdf'];
		$pek_pdf	= $data['pek_pdf'];
		$sku_ttl=$sku_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($sku_pdf['tgl_lahir']);
		$sku_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='sku';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($sku_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		if($sku_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($sku_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($sku_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($sku_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($sku_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_sku'].' / '.$sku_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($sku_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sku_pdf['sku_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sku_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sku_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'No.KTP / KK', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sku_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($sku_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$sku_pdf['alamat'].' RT '.$sku_pdf['rt'].' / RW '.$sku_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($sku_pdf['rt']=='' && $sku_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$sku_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$sku_pdf['alamat'].' RT '.$sku_pdf['rt'].' / RW '.$sku_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($sku_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$sku_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(18, 5,'Membuat ');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(46, 5,'Surat Keterangan Usaha ');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(100, 5,'Sebagaimana pengakuan yang bersangkutan diatas bahwa yang ');
		$this->fpdf->Ln();
		$this->fpdf->Multicell(170, 5,'bersangkutan diatas bahwa yang bersangkutan benar mempunyai kegiatan usaha sebagai berikut :');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'a. Jenis Usaha', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sku_pdf['jns_usaha'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'b. Lokasi Usaha', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sku_pdf['lok_usaha'], 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->Multicell(170, 5,'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$sku_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',11);
		if($sku_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($sku_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(17);
		
		if($sku_pdf['ttd_jenis'] !='' && $sku_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Usaha","I"); 
	}
	
	
/***********  SURAT KETERANGAN TIDAK MAMPU (SKTMP) **************/
	
	function sktmp_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header($nik);
		$data['sktmp_pdf']		= $this->crud_model->get_a_sktmp($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_sktmp($nik);
		$data['status_pdf']			= $this->crud_model->get_status_sktmp($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_sk_tdk_mampu($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_sk_tdk_mampu($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf	= $data['header_pdf'];
		$sktmp_pdf	= $data['sktmp_pdf'];
		$jk_pdf		= $data['jk_pdf'];
		$aga_pdf 	= $data['agama_pdf'];
		$pek_pdf 	= $data['pekerjaan_pdf'];
		$status_pdf = $data['status_pdf'];
		
		$sktmp_ttl	= $sktmp_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($sktmp_pdf['tgl_lahir']);
		$sktmp_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		$sktmp_jmltang= $sktmp_pdf['jml_tang'].' Jiwa';
		
		$jsk='sktmp';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($sktmp_pdf['nmr_surat'],$jsk);
		$ttd_pdf 		= $data['ttd_pdf'];
		
		if($sktmp_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($sktmp_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($sktmp_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($sktmp_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($sktmp_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_sktmp'].' / '.$sktmp_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($sktmp_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktmp_pdf['sktmp_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(30, 5,$sktmp_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktmp_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Status Perkawinan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$status_pdf['sta_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($sktmp_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$sktmp_pdf['alamat'].' RT '.$sktmp_pdf['rt'].' / RW '.$sktmp_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($sktmp_pdf['rt']=='' && $sktmp_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$sktmp_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$sktmp_pdf['alamat'].' RT '.$sktmp_pdf['rt'].' / RW '.$sktmp_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($sktmp_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$sktmp_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'Jml Tanggungan Keluarga', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktmp_jmltang, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(18, 5,'Membuat', 0,0,'L');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(62, 5,'Surat Keterangan Tidak Mampu', 0,0,'L');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(18, 5,'Dan Menerangkan bahwa yang bersangkutan adalah', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->MultiCell(170, 7,'betul-betul warga kami yang tidak mampu. Surat Keterangan ini dipergunakan untuk '.$sktmp_pdf['keterangan']);
		$this->fpdf->Ln(6);

		
		$this->fpdf->Multicell(170, 5,'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$sktmp_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($sktmp_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($sktmp_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(17);
		
		if($sktmp_pdf['ttd_jenis'] !='' && $sktmp_pdf['ttd_kode'] !=''){
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		$this->fpdf->Ln();
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
		$this->fpdf->Ln(8);
		}else{
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
		$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Tidak_Mampu","I"); 
	}
	
/***********  SURAT KETERANGAN CATATAN KEPOLISIAN (SKPCK) **************/
	
	function skpck_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skpck_pdf']		= $this->crud_model->get_a_sk_pck($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skpck($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_sk_pck($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_sk_pck($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skpck_pdf 		= $data['skpck_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		
		$skpck_ttl		= $skpck_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skpck_pdf['tgl_lahir']);
		$skpck_tglcetak	=$this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skpck';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skpck_pdf['nmr_surat'],$jsk);
		$ttd_pdf 		= $data['ttd_pdf'];
		
		if($skpck_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skpck_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skpck_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skpck_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skpck_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :  '.$header_pdf['no_skpck'].' / '.$skpck_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skpck_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpck_pdf['skpck_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpck_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpck_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'No.KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpck_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skpck_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$skpck_pdf['alamat'].' RT '.$skpck_pdf['rt'].' / RW '.$skpck_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skpck_pdf['rt']=='' && $skpck_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$skpck_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skpck_pdf['alamat'].' RT '.$skpck_pdf['rt'].' / RW '.$skpck_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skpck_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skpck_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(18, 5,'Membuat', 0,0,'L');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(70, 5,'Surat Keterangan Catatan Kepolisian', 0,0,'L');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(18, 5,'Sepanjang pengetahuan kami selama bertempat', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Multicell(170, 5,'tinggal pada alamat diatas sampai saat ini berkelakuan baik dan tidak terlibat dalam perkara pidana / urusan Kepolisian. Keterangan ini diperlukan untuk Keperluan '.$skpck_pdf['keperluan']);
		$this->fpdf->Ln(3);
		
		
		$this->fpdf->Multicell(170, 5,'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana.');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tanda Tangan Pemegang,', 0,0,'R');
		
		$this->fpdf->Cell(83, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skpck_tglcetak, 0,0,'L');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','B',11);
		if($skpck_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(145, 5,'LURAH', 0,0,'R');
			$this->fpdf->Ln();
		}else if($skpck_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(148, 5,'An. LURAH', 0,0,'R');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');
		}else{
			$this->fpdf->Cell(168, 5,'', 0,0,'R');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(55, 5,$skpck_pdf['skpck_nama'], 0,0,'C');
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		
		if($skpck_pdf['ttd_jenis'] !='' && $skpck_pdf['ttd_kode'] !=''){
		$this->fpdf->Cell(60, 5,'', 0,0,'J');
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		$this->fpdf->Ln();
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
		$this->fpdf->Ln(8);
		}else{
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
		$this->fpdf->Ln(8);
		}
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(170, 5,'Mengetahui :', 0,0,'C');
		$this->fpdf->Ln(7);
		$this->fpdf->Cell(170, 5,'CAMAT', 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','',12);
		//$this->fpdf->Cell(170, 5,'Camat Bogor...........................,', 0,0,'C');
		$this->fpdf->Ln(20);
		
		//$this->fpdf->Cell(170, 5,$skpck_pdf['ttd_mengetahui'], 0,0,'C');
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(170, 5,'_____________________', 0,0,'C');
		$this->fpdf->Ln(6);
		
		//$this->fpdf->Cell(136, 5,'NIP.', 0,0,'C');
		
		$this->fpdf->Output("Surat_Keterangan_Catatan_Kepolisian","I"); 
	}
	
	
/***********  SURAT KETERANGAN BELUM PERNAH MENIKAH (SKBM) **************/
	
	function skbm_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skbm_pdf']		= $this->crud_model->get_a_sk_blm_menikah($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skbm($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_sk_blm_menikah($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_sk_blm_menikah($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skbm_pdf 		= $data['skbm_pdf'];
		$jk_pdf			= $data['jk_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		
		$skbm_ttl		= $skbm_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skbm_pdf['tgl_lahir']);
		$skbm_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skbm';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skbm_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skbm_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skbm_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skbm_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skbm_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skbm_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skbm'].' / ' .$skbm_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skbm_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbm_pdf['skbm_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbm_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbm_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'No.KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbm_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skbm_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$skbm_pdf['alamat'].' RT '.$skbm_pdf['rt'].' / RW '.$skbm_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skbm_pdf['rt']=='' && $skbm_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$skbm_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skbm_pdf['alamat'].' RT '.$skbm_pdf['rt'].' / RW '.$skbm_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skbm_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skbm_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(18, 5,'Membuat', 0,0,'L');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(64, 5,'Surat Keterangan Belum Menikah', 0,0,'L');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(18, 5,'dan Sepanjang pengetahuan kami selama bertempat', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Multicell(173, 5,'tinggal pada alamat diatas sampai saat ini belum pernah menikah. Keterangan ini diperlukan untuk keperluan '.$skbm_pdf['keperluan']);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Multicell(170, 5,'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skbm_tglcetak, 0,0,'L');;
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($skbm_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skbm_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(20);
		
		if($skbm_pdf['ttd_jenis'] !='' && $skbm_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Belum_Pernah_Menikah","I"); 
	}
	
/***********  SURAT KETERANGAN IJIN KERAMAIAN (SKIR) **************/
	
	function skir_pdf($nik)
	{
		$data['header_pdf']			= $this->crud_model->get_header();
		$data['skir_pdf']			= $this->crud_model->get_a_sk_ijin_ramai($nik);
		$data['pekerjaan_pdf']		= $this->crud_model->get_a_pekerjaan_sk_ijin_ramai($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf		= $data['header_pdf'];
		$skir_pdf 		= $data['skir_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		
		$skir_ttl		= $skir_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skir_pdf['tgl_lahir']);
		$skir_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skir';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skir_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skir_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skir_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skir_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skir_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skir_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',15);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skir'].' / '.$skir_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skir_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skir_pdf['skir_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skir_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skir_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$skir_pdf['alamat'].' RT '.$skir_pdf['rt'].' / RW '.$skir_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skir_pdf['rt']=='' && $skir_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$skir_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skir_pdf['alamat'].' RT '.$skir_pdf['rt'].' / RW '.$skir_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skir_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skir_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'Waktu', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,'Pkl. '.$skir_pdf['wkt_ramai'].' WIB', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kegiatan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skir_pdf['kegiatan'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(18, 5,'Membuat', 0,0,'L');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(63, 5,'Surat Keterangan Izin Keramaian', 0,0,'L');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(18, 5,'dan menerangkan bahwa pada prinsipnya tidak keberatan', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Multicell(170, 5,'atas permohonan yang bersangkutan dengan ketentuan sebagai berikut :');
		$this->fpdf->Ln(3);
		$this->fpdf->Multicell(180, 5,'1. Pada waktu dilaksanakan keramaian harus disertai dengan tetangga, menghargai waktu-waktu ibadah dalam menciptakan kerukunan umat beragama maupun kebersihan lingkungan setelah selesai mengadakan keramaian');
		$this->fpdf->Ln(3);
		$this->fpdf->Multicell(180, 5,'2. Pada waktu dilaksanakan keramaian tidak dibenarkan / dilarang melakukan hal-hal yang bertentangan dengan ketentuan yang berlaku dan adat istiadat bangsa.');
		$this->fpdf->Ln(3);
		$this->fpdf->Multicell(170, 5,'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(30, 5,'Mengetahui,', 0,0,'R');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(30, 5,'CAMAT', 0,0,'R');
		
		$this->fpdf->Cell(110, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skir_tglcetak, 0,0,'L');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(94, 5,'', 0,0,'J');
		
		$this->fpdf->SetFont('Times','B',11);
		if($skir_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(100, 5,'LURAH', 0,0,'C');
		}else if($skir_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(100, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(100, 5,'', 0,0,'R');
		}
		$this->fpdf->Ln(20);
		$this->fpdf->SetFont('Times','',11);
		//$this->fpdf->Cell(50,5,$skir_pdf['ttd_mengetahui'],0,0,'C');
		$this->fpdf->ln(1);
		$this->fpdf->Cell(60, 5,'___________________________', 0,0,'C');
		
		if($skir_pdf['ttd_jenis'] !='' && $skir_pdf['ttd_kode'] !=''){
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(170, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(60, 5,'', 0,0,'C');
			$this->fpdf->Cell(170, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(60, 5,'', 0,0,'J');
			$this->fpdf->Cell(170, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(160, 5,'______________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}

		$this->fpdf->Output("Surat_Keterangan_Ijin_Keramaian","I"); 
	}
	

/***********  SURAT KETERANGAN BEPERGIAN (SKBP) **************/
	
	function skb_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skb_pdf']		= $this->crud_model->get_a_sk_pergi($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skb($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_sk_pergi($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_sk_pergi($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skb_pdf 		= $data['skb_pdf'];
		$jk_pdf			= $data['jk_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		
		$skb_ttl		= $skb_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skb_pdf['tgl_lahir']);
		$skb_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skb';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skb_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skb_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skb_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skb_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skb_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skb_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skb'].'/ '.$skb_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skb_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skb_pdf['skb_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skb_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skb_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'No.KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skb_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skb_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$skb_pdf['alamat'].' RT '.$skb_pdf['rt'].' / RW '.$skb_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skb_pdf['rt']=='' && $skb_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$skb_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skb_pdf['alamat'].' RT '.$skb_pdf['rt'].' / RW '.$skb_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skb_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skb_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skb_pdf['maksud'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat yang dituju', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skb_pdf['tujuan'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Lamanya bepergian', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skb_pdf['lama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Yang turut dalam bepergian', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skb_pdf['turut'], 0,0,'L');
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(18, 5,'Membuat', 0,0,'L');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(53, 5,'Surat Keterangan Bepergian', 0,0,'L');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(18, 5,'ini dibuat untuk dipergunakan sebagaimana mestinya.', 0,0,'L');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skb_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($skb_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skb_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(20);
		
		if($skb_pdf['ttd_jenis'] !='' && $skb_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(130, 5,'Keterangan :', 0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Multicell(170, 5,'Segera setelah sampai pada alamat yang dituju, yang bersangkutan segera melapor pada aparat wilayah setempat.');
		
		
		$this->fpdf->Output("Surat_Keterangan_Bepergian","I"); 
	}
		/***********  SURAT KETERANGAN KELAHIRAN (SKL) **************/
	
	function skl_pdf($nik)
	{
		
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skl_pdf']		= $this->crud_model->get_a_skl($nik);
		$data['agama1_pdf']		= $this->crud_model->get_a_agama1_skl($nik);
		$data['agama2_pdf']		= $this->crud_model->get_a_agama2_skl($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skl($nik);
		$data['pklahir_pdf']	= $this->crud_model->get_a_pkelahiran_skl($nik);
		$data['tklahir_pdf']	= $this->crud_model->get_a_tkelahiran_skl($nik);
		$data['lahir_pdf']		= $this->crud_model->get_a_lahir_skl($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skl_pdf 		= $data['skl_pdf'];
		$aga1_pdf 		= $data['agama1_pdf'];
		$aga2_pdf 		= $data['agama2_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		$pklahir_pdf	= $data['pklahir_pdf'];	
		$tklahir_pdf	= $data['tklahir_pdf'];
		$lahir_pdf		= $data['lahir_pdf'];
		
		$jsk='skl';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skl_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		/* TGL LAHIR ANAK */
		$data['hbt1_pdf'] = $this->app_model->tgl_indo($skl_pdf['tgl_lahir3']);
		$hbt1_exp	= explode(' ',$data['hbt1_pdf']);
		$h1_exp = $hbt1_exp[0];
		$b1_exp = $hbt1_exp[1];
		$t1_exp = $hbt1_exp[2];
		$hbt1_pdf	= 'Tanggal '.$h1_exp.' Bulan '.$b1_exp.' Tahun '.$t1_exp;
		
		/* TGL LAHIR IBU */
		$data['hbt2_pdf'] = $this->app_model->tgl_indo($skl_pdf['tgl_lahir1']);
		$umur2_pdf = $this->app_model->umur_str($skl_pdf['tgl_lahir1']);
		$hbt2_exp	= explode(' ',$data['hbt2_pdf']);
		$h2_exp = $hbt2_exp[0];
		$b2_exp = $hbt2_exp[1];
		$t2_exp = $hbt2_exp[2];
		$hbt2_pdf	= 'Tanggal '.$h2_exp.' Bulan '.$b2_exp.' Tahun '.$t2_exp.' / Umur '.$umur2_pdf.' Tahun';
		
		/* TGL LAHIR AYAH */
		$data['hbt3_pdf'] = $this->app_model->tgl_indo($skl_pdf['tgl_lahir2']);
		$umur3_pdf = $this->app_model->umur_str($skl_pdf['tgl_lahir2']);
		$hbt3_exp	= explode(' ',$data['hbt3_pdf']);
		$h3_exp = $hbt3_exp[0];
		$b3_exp = $hbt3_exp[1];
		$t3_exp = $hbt3_exp[2];
		$hbt3_pdf	= 'Tanggal '.$h3_exp.' Bulan '.$b3_exp.' Tahun '.$t3_exp.' / Umur '.$umur3_pdf.' Tahun';

		$skl_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		
		if($skl_pdf['propinsi1']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi1($skl_pdf['nmr_surat'],$jsk);
		$pro1_pdf = $data['pro_pdf'];
		$pro1_pdf = $pro1_pdf['nm_propinsi'];
		$pro1_pdf = ucwords(strtolower($pro1_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota1($skl_pdf['nmr_surat'],$jsk);
		$kot1_pdf = $data['kot_pdf'];
		$kot1_pdf = $kot1_pdf['nm_kota'];	
		$kot1_pdf = ucwords(strtolower($kot1_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan1($skl_pdf['nmr_surat'],$jsk);
		$kec1_pdf = $data['kec_pdf'];
		$kec1_pdf = $kec1_pdf['nm_kecamatan'];	
		$kec1_pdf = ucwords(strtolower($kec1_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan1($skl_pdf['nmr_surat'],$jsk);
		$kel1_pdf = $data['kel_pdf'];
		$kel1_pdf = $kel1_pdf['nm_kelurahan'];	
		$kel1_pdf = ucwords(strtolower($kel1_pdf));
		}
		
		if($skl_pdf['propinsi2']!=''){
		// Selected Propinsi //
		$data['pro2_pdf'] = $this->crud_model->get_selected_propinsi2($skl_pdf['nmr_surat'],$jsk);
		$pro2_pdf = $data['pro2_pdf'];
		$pro2_pdf = $pro2_pdf['nm_propinsi'];
		$pro2_pdf = ucwords(strtolower($pro2_pdf));

		// Selected Kota //		
		$data['kot2_pdf'] = $this->crud_model->get_selected_kota2($skl_pdf['nmr_surat'],$jsk);
		$kot2_pdf = $data['kot2_pdf'];
		$kot2_pdf = $kot2_pdf['nm_kota'];	
		$kot2_pdf = ucwords(strtolower($kot1_pdf));
		
		// Selected Kecamatan //	
		$data['kec2_pdf'] = $this->crud_model->get_selected_kecamatan2($skl_pdf['nmr_surat'],$jsk);
		$kec2_pdf = $data['kec2_pdf'];
		$kec2_pdf = $kec2_pdf['nm_kecamatan'];	
		$kec2_pdf = ucwords(strtolower($kec2_pdf));
		
		// Selected Kelurahan //	
		$data['kel2_pdf'] = $this->crud_model->get_selected_kelurahan2($skl_pdf['nmr_surat'],$jsk);
		$kel2_pdf = $data['kel2_pdf'];
		$kel2_pdf = $kel2_pdf['nm_kelurahan'];	
		$kel2_pdf = ucwords(strtolower($kel2_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skl'].' / ' .$skl_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skl_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skl_pdf['skl_nama3'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Dilahirkan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$hbt1_pdf, 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Kelahiran', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$lahir_pdf['lahir_nama'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		/* Ini Untuk Anak Kembar */
		if($skl_pdf['skl_kembar']!=0){
		$this->fpdf->Cell(60, 5,'Anak ini lahir ke ', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skl_pdf['skl_kembar'], 0,0,'L');
		$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Cell(60, 5,'Tempat Kelahiran', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$tklahir_pdf['tk_nama'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(85, 5,'Kelurahan', 0,0,'R');
		$this->fpdf->Cell(60, 5,$skl_pdf['skl_kel'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(86, 5,'Kecamatan', 0,0,'R');
		$this->fpdf->Cell(60, 5,$skl_pdf['skl_kec'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Penolong Kelahiran', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pklahir_pdf['pk_nama'], 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->SetFont('Times','BU',12);
		$this->fpdf->Cell(170, 5,'IBU', 0,0,'C');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(60, 5,'Nama Lengkap', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skl_pdf['skl_nama1'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skl_pdf['propinsi1']!=''){
			$this->fpdf->Cell(60, 5,$skl_pdf['alamat1'].' RT '.$skl_pdf['rt1'].' / RW '.$skl_pdf['rw1'].' '.$kel1_pdf, 0,0,'L');
		}else if($skl_pdf['rt1']=='' && $skl_pdf['rw1']==''){
			$this->fpdf->Cell(60, 5,$skl_pdf['alamat1'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skl_pdf['alamat1'].' RT '.$skl_pdf['rt1'].' / RW '.$skl_pdf['rw1'], 0,0,'L');
		}
		$this->fpdf->Ln(8);
		
		if($skl_pdf['propinsi1']!=''){
			$this->fpdf->Cell(60, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec1_pdf.' '.$kot1_pdf.' '.$pro1_pdf.' '.$skl_pdf['kodepos1'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Cell(60, 5,'Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$hbt2_pdf, 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga1_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skl_pdf['kew_id1'], 0,0,'L');
		$this->fpdf->Ln(60);
		
		$this->fpdf->SetFont('Times','BU',12);
		$this->fpdf->Cell(170, 5,'AYAH', 0,0,'C');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(60, 5,'Nama Lengkap', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skl_pdf['skl_nama2'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skl_pdf['propinsi2']!=''){
			$this->fpdf->Cell(60, 5,$skl_pdf['alamat2'].' RT '.$skl_pdf['rt2'].' / RW '.$skl_pdf['rw2'].' '.$kel2_pdf, 0,0,'L');
		}else if($skl_pdf['rt2']=='' && $skl_pdf['rw2']==''){
			$this->fpdf->Cell(60, 5,$skl_pdf['alamat2'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skl_pdf['alamat2'].' RT '.$skl_pdf['rt2'].' / RW '.$skl_pdf['rw2'], 0,0,'L');
		}
		$this->fpdf->Ln(8);
		
		if($skl_pdf['propinsi2']!=''){
			$this->fpdf->Cell(60, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec2_pdf.' '.$kot2_pdf.' '.$pro1_pdf.' '.$skl_pdf['kodepos2'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Cell(60, 5,'Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$hbt3_pdf, 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga2_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skl_pdf['kew_id2'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'No. Kartu Keluarga / KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(36, 5,$skl_pdf['no_kk1'], 0,0,'L');
		$this->fpdf->Cell(5, 5,' / ', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skl_pdf['nik2'], 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(18, 5,'Demikian ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(54, 5,'Surat Keterangan Kelahiran ', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(170, 5,'ini dibuat atas dasar yang sebenarnya, untuk dipergunakan', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'sebagaimana mestinya. ', 0,0,'J');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skl_tglcetak, 0,0,'L');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','B',11);
		if($skl_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skl_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(20);
		
		if($skl_pdf['ttd_jenis'] !='' && $skl_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Kelahiran","I"); 
	}
	
/***********  SURAT KETERANGAN KEMATIAN (SKK) **************/
	
	function skk_pdf($nik)
	{
		
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skk_pdf']		= $this->crud_model->get_a_skk($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skk($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skk($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skk($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skk_pdf 		= $data['skk_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skk_tgl_lahir_ctk 		= $this->app_model->tgl_indo($skk_pdf['tgl_lahir1']);
		$skk_tgl_age_ctk 		= $this->app_model->umur_str($skk_pdf['tgl_lahir2']);
		$skk_tgl_lapor_ctk 		= $this->app_model->tgl_indo($skk_pdf['tgl_pengajuan']);
		$skk_tgl_meninggal_ctk 	= $this->app_model->tgl_indo($skk_pdf['tgl_meninggal']);
		$skk_ttl				= $skk_pdf['tmp_lahir1'].', '.$skk_tgl_lahir_ctk;
		$skk_tgl_umur_ctk		= $skk_tgl_age_ctk.' tahun';
		$skk_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));	

		$jsk='skk';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skk_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		// Ambil Propinsi //
		$data['propinsi_pdf'] = $this->crud_model->get_selected_propinsi1($skk_pdf['nmr_surat'],$jsk);
		$propinsi_pdf = $data['propinsi_pdf'];
		// Ambil Kota //		
		$data['kota_pdf'] = $this->crud_model->get_selected_kota1($skk_pdf['nmr_surat'],$jsk);
		$kota_pdf = $data['kota_pdf'];	
		// Ambil Kecamatan //	
		$data['kecamatan_pdf'] = $this->crud_model->get_selected_kecamatan1($skk_pdf['nmr_surat'],$jsk);
		$kecamatan_pdf = $data['kecamatan_pdf'];
		// Ambil Kelurahan //	
		$data['kelurahan_pdf'] = $this->crud_model->get_selected_kelurahan1($skk_pdf['nmr_surat'],$jsk);
		$kelurahan_pdf = $data['kelurahan_pdf'];	

		if($skk_pdf['propinsi2']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi2($skk_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota2($skk_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan2($skk_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan2($skk_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}

		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skk'].' / '.$skk_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'] , 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skk_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_pdf['skk_nama1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_pdf['kew_id1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Meninggal Dunia Tanggal', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_tgl_meninggal_ctk, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Dilaporkan tanggal', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_tgl_lapor_ctk, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Sebab-sebab meninggal dunia', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_pdf['sebab_meninggal'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Tempat meninggal dunia', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skk_pdf['tmp_meninggal'], 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->SetFont('Times','BU',11);
		$this->fpdf->Cell(175, 5,'TEMPAT TINGGAL YANG MENINGGAL DUNIA', 0,0,'C');
		$this->fpdf->Ln(12);
		$this->fpdf->SetFont('Times','',12);
		
		$this->fpdf->Cell(60, 5,'Provinsi', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$propinsi_pdf['nm_propinsi'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Kota', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$kota_pdf['nm_kota'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Kecamatan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$kecamatan_pdf['nm_kecamatan'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Kelurahan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$kelurahan_pdf['nm_kelurahan'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skk_pdf['rt1']=='' && $skk_pdf['rw1']==''){
			$this->fpdf->Cell(60, 5,$skk_pdf['alamat1'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skk_pdf['alamat1'].' RT '.$skk_pdf['rt1'].' / RW '.$skk_pdf['rw1'], 0,0,'L');
		}
		$this->fpdf->Ln(12);
				
		$this->fpdf->SetFont('Times','BU',11);
		$this->fpdf->Cell(175, 5,'KELUARGA YANG DITINGGALKAN', 0,0,'C');
		$this->fpdf->Ln(12);
		$this->fpdf->Cell(60, 5,'Nama dan Hubungan Keluarga :', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','',12);
		
		$this->fpdf->Cell(60, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_pdf['skk_nama2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Umur', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_tgl_umur_ctk, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skk_pdf['kew_id2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skk_pdf['propinsi2']!=''){
			$this->fpdf->Cell(60, 5,$skk_pdf['alamat2'].' RT '.$skk_pdf['rt2'].' / RW '.$skk_pdf['rw2'].' '.$kel_pdf, 0,0,'L');
		}else if($skk_pdf['rt2']=='' && $skk_pdf['rw2']==''){
			$this->fpdf->Cell(60, 5,$skk_pdf['alamat2'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skk_pdf['alamat2'].' RT '.$skk_pdf['rt2'].' / RW '.$skk_pdf['rw2'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skk_pdf['propinsi2']!=''){
			$this->fpdf->Cell(60, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skk_pdf['kodepos2'], 0,0,'L');
			
		}
		$this->fpdf->Ln(40);
		$this->fpdf->Cell(18, 5,'Demikian ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(52, 5,'Surat Keterangan Kematian ', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(170, 5,' ini dibuat, untuk dipergunakan sebagaimana mestinya.', 0,0,'J');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skk_tglcetak, 0,0,'L');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','B',11);
		if($skk_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skk_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(20);
		
		if($skk_pdf['ttd_jenis'] !='' && $skk_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Kematian","I"); 
	}
/***********  SURAT KETERANGAN BEDA NAMA (SKBN) **************/
	
	function skbn_pdf($nik)
	{
		
		$data['header_pdf']			= $this->crud_model->get_header();
		$data['skbn_pdf']			= $this->crud_model->get_a_skbn($nik);
		$data['agama_pdf']			= $this->crud_model->get_a_agama_skbn($nik);
		$data['jeniskelamin_pdf']	= $this->crud_model->get_a_jeniskelamin_skbn($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skbn_pdf 		= $data['skbn_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$jk_pdf 		= $data['jeniskelamin_pdf'];
		
		$skbn_ttl		= $skbn_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skbn_pdf['tgl_lahir']);
		$skbn_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		$skbn_content='Menerangkan bahwa nama tersebut diatas tercatat dengan ejaan/huruf yang berbeda yaitu '.$skbn_pdf['maksud1'] .', adapun yang benar adalah '.$skbn_pdf['maksud2'] . ' yang tercantum dalam '.$skbn_pdf['maksud3'] .' namun merupakan orang yang sama.';
		
		$jsk='skbn';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skbn_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skbn_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skbn_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skbn_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skbn_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skbn_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skbn'].' / '.$skbn_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skbn_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbn_pdf['skbn_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbn_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
				
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbn_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbn_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
				
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skbn_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$skbn_pdf['alamat'].' RT '.$skbn_pdf['rt'].' / RW '.$skbn_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skbn_pdf['rt']=='' && $skbn_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$skbn_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skbn_pdf['alamat'].' RT '.$skbn_pdf['rt'].' / RW '.$skbn_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skbn_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skbn_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Multicell(170, 5,$skbn_content);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(18, 5,'Demikian ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(55, 5,'Surat Keterangan Beda Nama', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(170, 5,' ini dibuat atas dasar yang sebenarnya, untuk diperguna-', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Multicell(170, 5,'kan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skbn_tglcetak, 0,0,'L');
		
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($skbn_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skbn_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(20);
		
		if($skbn_pdf['ttd_jenis'] !='' && $skbn_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Beda_Nama","I"); 
	}
	

/***********  SURAT KETERANGAN TIDAK KEBERATAN DARI TETANGGA (SKTKT) **************/
	
	function sktkt_pdf($nik)
	{
		
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['sktkt_pdf']		= $this->crud_model->get_a_sktkt($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_sktkt($nik);
		$data['jk_pdf']	= $this->crud_model->get_a_jeniskelamin_sktkt($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$sktkt_pdf 		= $data['sktkt_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$sktkt_ttl		= $sktkt_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($sktkt_pdf['tgl_lahir']);
		$sktkt_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='sktkt';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($sktkt_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($sktkt_pdf['propinsi']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($sktkt_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($sktkt_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($sktkt_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($sktkt_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',15);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_sktkt'].'/ '.$sktkt_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($sktkt_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktkt_pdf['sktkt_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktkt_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktkt_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
				
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($sktkt_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$sktkt_pdf['alamat'].' RT '.$sktkt_pdf['rt'].' / RW '.$sktkt_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($sktkt_pdf['rt']=='' && $sktkt_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$sktkt_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$sktkt_pdf['alamat'].' RT '.$sktkt_pdf['rt'].' / RW '.$sktkt_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($sktkt_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$sktkt_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(20, 5,'Membuat ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(88, 5,' Surat Keterangan Tidak Keberatan Tetangga ', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(88, 5,'berdasarkan surat pernyataan tidak ');
		$this->fpdf->Ln(6);
		$this->fpdf->Multicell(170, 5,'keberatan (terlampir), untuk dipergunakan sebagai kelengkapan persyaratan '.$sktkt_pdf['syarat'] );
		$this->fpdf->Ln(6);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan  ini dibuat, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		$this->fpdf->Cell(30, 5,'Mengetahui', 0,0,'L');
		$this->fpdf->Cell(85, 5,'', 0,0,'L');
		$this->fpdf->Cell(13, 5,'Bogor,', 0,0,'C');
		$this->fpdf->Cell(2, 5,$sktkt_tglcetak, 0,0,'L');
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(30, 5,'CAMAT', 0,0,'C');
		$this->fpdf->Cell(50, 5,'', 0,0,'L');
		//$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(45, 5,'', 0,0,'C');
		$this->fpdf->SetFont('Times','B',11);
		if($sktkt_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(28, 5,'LURAH', 0,0,'C');
		}else if($sktkt_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(28, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(188, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Ln(24);
		//$this->fpdf->Cell(50,5,$sktkt_pdf['ttd_mengetahui'],0,0,'C');
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(1, 5,'_____________________', 0,0,'L');
				
		if($sktkt_pdf['ttd_jenis'] !='' && $sktkt_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Tidak_Keberatan_Tetangga","I"); 
	}
	
	/***********  SURAT KETERANGAN TENTANG ORANG TUA (sktot) **************/
	
	function sktot_pdf($nik)
	{
		$h_kota 		= $this->config->item('h_kota');
		$h_kecamatan	= $this->config->item('h_kecamatan');
		$h_kelurahan 	= $this->config->item('h_kelurahan');
		$h_kode_kelurahan 	= $this->config->item('kode_kelurahan');
		$h_jab_lurah 	= $this->config->item('jab_lurah');
		$h_alamat 		= $this->config->item('h_alamat');
		$h_tlp_fax 		= $this->config->item('h_tlp_fax');
		$h_url 		= $this->config->item('h_url');

		$data['sktot_pdf']		= $this->crud_model->get_a_sktot($nik);
		
		$data['agama1_pdf']		= $this->crud_model->get_a_agama1_sktot($nik);
		$data['agama2_pdf']		= $this->crud_model->get_a_agama2_sktot($nik);
		$data['agama3_pdf']		= $this->crud_model->get_a_agama3_sktot($nik);
		
		$data['pekerjaan1_pdf']	= $this->crud_model->get_a_pekerjaan1_sktot($nik);
		$data['pekerjaan2_pdf']	= $this->crud_model->get_a_pekerjaan2_sktot($nik);
		$data['pekerjaan3_pdf']	= $this->crud_model->get_a_pekerjaan3_sktot($nik);
		
		$data['jk1_pdf']	= $this->crud_model->get_a_jeniskelamin1_sktot($nik);
		$data['jk2_pdf']	= $this->crud_model->get_a_jeniskelamin2_sktot($nik);
		$data['jk3_pdf']	= $this->crud_model->get_a_jeniskelamin3_sktot($nik);

		$sktot_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));

		$this->load->library('fpdf');
		
		$sktot_pdf 	= $data['sktot_pdf'];
		
		$aga1_pdf 	= $data['agama1_pdf'];
		$aga2_pdf 	= $data['agama2_pdf'];
		$aga3_pdf 	= $data['agama3_pdf'];
		
		$pek1_pdf 	= $data['pekerjaan1_pdf'];
		$pek2_pdf 	= $data['pekerjaan2_pdf'];
		$pek3_pdf 	= $data['pekerjaan3_pdf'];
		
		$jk1_pdf 	= $data['jk1_pdf'];
		$jk2_pdf 	= $data['jk2_pdf'];
		$jk3_pdf 	= $data['jk3_pdf'];
		
		$sktot_ttl1=$sktot_pdf['tmp_lahir1'].', '.$this->app_model->tgl_indo($sktot_pdf['tgl_lahir1']);
		$sktot_ttl2=$sktot_pdf['tmp_lahir2'].', '.$this->app_model->tgl_indo($sktot_pdf['tgl_lahir2']);
		$sktot_ttl3=$sktot_pdf['tmp_lahir3'].', '.$this->app_model->tgl_indo($sktot_pdf['tgl_lahir3']);
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $h_kota, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$h_kecamatan, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$h_kelurahan, 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$h_alamat, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$h_tlp_fax, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$h_url, 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   / '.$sktot_pdf['nmr_surat'].' - '.$h_kode_kelurahan, 0,0,'C');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'a.   Nama       :  '.$header_pdf['nama_lurah'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'b.   Jabatan    :   Lurah '.$h_jab_lurah, 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['sktot_nama1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_ttl1, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk1_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['kew_id1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga1_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['nik1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek1_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$sktot_pdf['alamat1'], 0,0,'L');
		$this->fpdf->Ln(10);
				
		$this->fpdf->Cell(50, 5,'2.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['sktot_nama2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_ttl2, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk2_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['kew_id2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga2_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['nik2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek2_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$sktot_pdf['alamat2'], 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->MultiCell(170, 5,'Maksud membuat surat keterangan ini adalah untuk Menerangkan bahwa nama tersebut diatas adalah ayah kandung dan ibu kandung dari seorang anak :');
		$this->fpdf->Ln(8);
		$this->fpdf->Cell(50, 5,'     Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['sktot_nama3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_ttl3, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk3_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['kew_id3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga3_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktot_pdf['nik3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek3_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$sktot_pdf['alamat3'], 0,0,'L');
		
		
		$this->fpdf->Ln(10);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$sktot_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(170, 5,'LURAH .............................', 0,0,'R');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Ln(20);
		
		$this->fpdf->Cell(168, 5,'_____________________', 0,0,'R');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(132, 5,'NIP.', 0,0,'R');
				
		$this->fpdf->Output("Surat_Keterangan_Tentang_OrangTua","I"); 
	}

	/***********  SURAT KETERANGAN ASAL USUL (skau) **************/
	
	function skau_pdf($nik)
	{
		$h_kota 		= $this->config->item('h_kota');
		$h_kecamatan	= $this->config->item('h_kecamatan');
		$h_kelurahan 	= $this->config->item('h_kelurahan');
		$h_kode_kelurahan 	= $this->config->item('kode_kelurahan');
		$h_jab_lurah 	= $this->config->item('jab_lurah');
		$h_alamat 		= $this->config->item('h_alamat');
		$h_tlp_fax 		= $this->config->item('h_tlp_fax');
		$h_url 		= $this->config->item('h_url');

		$data['skau_pdf']		= $this->crud_model->get_a_skau($nik);
		
		$data['agama1_pdf']		= $this->crud_model->get_a_agama1_skau($nik);
		$data['agama2_pdf']		= $this->crud_model->get_a_agama2_skau($nik);
		$data['agama3_pdf']		= $this->crud_model->get_a_agama3_skau($nik);
		
		$data['pekerjaan1_pdf']	= $this->crud_model->get_a_pekerjaan1_skau($nik);
		$data['pekerjaan2_pdf']	= $this->crud_model->get_a_pekerjaan2_skau($nik);
		$data['pekerjaan3_pdf']	= $this->crud_model->get_a_pekerjaan3_skau($nik);
		
		$data['jk1_pdf']	= $this->crud_model->get_a_jeniskelamin1_skau($nik);
		$data['jk2_pdf']	= $this->crud_model->get_a_jeniskelamin2_skau($nik);
		$data['jk3_pdf']	= $this->crud_model->get_a_jeniskelamin3_skau($nik);

		$skau_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));

		$this->load->library('fpdf');
		
		$skau_pdf 	= $data['skau_pdf'];
		
		$aga1_pdf 	= $data['agama1_pdf'];
		$aga2_pdf 	= $data['agama2_pdf'];
		$aga3_pdf 	= $data['agama3_pdf'];
		
		$pek1_pdf 	= $data['pekerjaan1_pdf'];
		$pek2_pdf 	= $data['pekerjaan2_pdf'];
		$pek3_pdf 	= $data['pekerjaan3_pdf'];
		
		$jk1_pdf 	= $data['jk1_pdf'];
		$jk2_pdf 	= $data['jk2_pdf'];
		$jk3_pdf 	= $data['jk3_pdf'];
		
		$skau_ttl1=$skau_pdf['tmp_lahir1'].', '.$this->app_model->tgl_indo($skau_pdf['tgl_lahir1']);
		$skau_ttl2=$skau_pdf['tmp_lahir2'].', '.$this->app_model->tgl_indo($skau_pdf['tgl_lahir2']);
		$skau_ttl3=$skau_pdf['tmp_lahir3'].', '.$this->app_model->tgl_indo($skau_pdf['tgl_lahir3']);
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $h_kota, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$h_kecamatan, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$h_kelurahan, 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$h_alamat, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$h_tlp_fax, 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$h_url, 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   / '.$skau_pdf['nmr_surat'].' - '.$h_kode_kelurahan, 0,0,'C');
		$this->fpdf->Ln(12);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a.   Nama       :  '.$header_pdf['nama_lurah'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'b.   Jabatan    :   Lurah '.$h_jab_lurah, 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(50, 5,'     Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['skau_nama1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_ttl1, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk1_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['kew_id1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga1_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['nik1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek1_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skau_pdf['alamat1'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->MultiCell(170, 5,'Maksud membuat surat keterangan ini adalah untuk Menerangkan bahwa nama tersebut diatas adalah benar anak kandung dari pernikahan : ');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(50, 5,'1.  Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['skau_nama2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_ttl2, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk2_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['kew_id2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga2_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['nik2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek2_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skau_pdf['alamat2'], 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(50, 5,'2.  Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['skau_nama3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_ttl3, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk3_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['kew_id3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga3_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'      No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skau_pdf['nik3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek3_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skau_pdf['alamat3'], 0,0,'L');
		
		
		$this->fpdf->Ln(12);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan Asal-Usul ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(0.1);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skau_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(170, 5,'LURAH .............................', 0,0,'R');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Ln(20);
		
		$this->fpdf->Cell(168, 5,'_____________________', 0,0,'R');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(132, 5,'NIP.', 0,0,'R');
				
		$this->fpdf->Output("Surat_Keterangan_Asal_Usul","I"); 
	}


	/***********  SURAT KETERANGAN UNTUK MENIKAH (skun) **************/
	
	function skun_pdf($nik)
	{
		$h_kota 		= $this->config->item('h_kota');
		$h_kecamatan	= $this->config->item('h_kecamatan');
		$h_kelurahan 	= $this->config->item('h_kelurahan');
		$h_kode_kelurahan 	= $this->config->item('kode_kelurahan');
		$h_jab_lurah 	= $this->config->item('jab_lurah');
		$h_alamat 		= $this->config->item('h_alamat');
		$h_tlp_fax 		= $this->config->item('h_tlp_fax');
		$h_url 		= $this->config->item('h_url');

		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skun_pdf']		= $this->crud_model->get_a_skun($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skun($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skun($nik);
		$data['jk_pdf']	= $this->crud_model->get_a_jeniskelamin_skun($nik);

		$skun_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		
		$this->load->library('fpdf');
		
		$header_pdf	= $data['header_pdf'];
		$skun_pdf 	= $data['skun_pdf'];
		$aga_pdf 	= $data['agama_pdf'];
		$pek_pdf 	= $data['pekerjaan_pdf'];
		$jk_pdf 	= $data['jk_pdf'];
		$skun_ttl=$skun_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skun_pdf['tgl_lahir']);
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$h_url, 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',14);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :    / '.$skun_pdf['nmr_surat'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a.   Nama       :  '.$header_pdf['nama_lurah'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'b.   Jabatan    :   Lurah '.$header_pdf['lok_lurah'], 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_pdf['skun_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'8.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(110, 5,$skun_pdf['alamat'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'9.   Bin/Binti', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_pdf['bin_binti'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'10. Status Perkawinan', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'      a.   Keterangan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_pdf['status1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'      b.   Nama Istri/Suami Terdahulu', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_pdf['status2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(70, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Membuat surat keterangan ini adalah untuk melengkapi persyaratan pernikahan. ', 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya, ');
		$this->fpdf->Ln(14);
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skun_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(169, 5,'LURAH .............................', 0,0,'R');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(167, 5,'_____________________', 0,0,'R');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(130, 5,'NIP.', 0,0,'R');
		
		$this->fpdf->Output("Surat_Keterangan_Untuk_Menikah","I"); 
	}
	/***********  SURAT KETERANGAN TEMPAT TINGGAL  **************/
	
	function sktt_pdf($nik)
	{
		
		
		/******************************   ********************/
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['sktt_pdf']		= $this->crud_model->get_a_sk_tmp_tinggal($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_sktt($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf		= $data['header_pdf'];
		$sktt_pdf 		= $data['sktt_pdf'];
		$jk_pdf			= $data['jk_pdf'];
		
		$sktt_tgllahir	= $sktt_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($sktt_pdf['tgl_lahir']);
		$sktt_tglsurat	= $this->app_model->tgl_indo($sktt_pdf['tgl_surat']);
		
		$jsk='sktt';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($sktt_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($sktt_pdf['propinsi']!=''){
			// Selected Propinsi //
			$data['pro_pdf'] = $this->crud_model->selected_propinsi($sktt_pdf['nmr_surat'],$jsk);
			$pro_pdf = $data['pro_pdf'];
			$pro_pdf = $pro_pdf['nm_propinsi'];
			$pro_pdf = ucwords(strtolower($pro_pdf));

			// Selected Kota //		
			$data['kot_pdf'] = $this->crud_model->selected_kota($sktt_pdf['nmr_surat'],$jsk);
			$kot_pdf = $data['kot_pdf'];
			$kot_pdf = $kot_pdf['nm_kota'];	
			$kot_pdf = ucwords(strtolower($kot_pdf));
			
			// Selected Kecamatan //	
			$data['kec_pdf'] = $this->crud_model->selected_kecamatan($sktt_pdf['nmr_surat'],$jsk);
			$kec_pdf = $data['kec_pdf'];
			$kec_pdf = $kec_pdf['nm_kecamatan'];	
			$kec_pdf = ucwords(strtolower($kec_pdf));
			
			// Selected Kelurahan //	
			$data['kel_pdf'] = $this->crud_model->selected_kelurahan($sktt_pdf['nmr_surat'],$jsk);
			$kel_pdf = $data['kel_pdf'];
			$kel_pdf = $kel_pdf['nm_kelurahan'];	
			$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_sktt'].' / '.$sktt_pdf['nomor'] .' - ' .$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($sktt_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktt_pdf['sktt_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(2, 5,$sktt_tgllahir, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$sktt_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'No.KTP / KK', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($sktt_pdf['no_kk']!=''){
			$this->fpdf->Cell(60, 5,$sktt_pdf['nik'].' / '.$sktt_pdf['no_kk'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$sktt_pdf['nik'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($sktt_pdf['propinsi']!=''){
			$this->fpdf->Cell(60, 5,$sktt_pdf['alamat'].' RT '.$sktt_pdf['rt'].' / RW '.$sktt_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($sktt_pdf['rt']=='' && $sktt_pdf['rw']==''){
			$this->fpdf->Cell(60, 5,$sktt_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$sktt_pdf['alamat'].' RT '.$sktt_pdf['rt'].' / RW '.$sktt_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($sktt_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$sktt_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		$this->fpdf->Cell(50, 5,'Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(20, 5,'Membuat ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(67, 5,'Surat Keterangan Tempat Tinggal ', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(170, 5,'yang menerangkan bahwa benar nama tersebut ', 0,0,'L');
		$this->fpdf->Ln();
		$this->fpdf->Multicell(170, 5,'diatas adalah  warga kami yang bertempat tinggal di alamat tersebut. Surat keterangan ini berlaku 1 (satu) bulan sejak tanggal dikeluarkan.');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Multicell(170, 5,'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$sktt_tglsurat, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($sktt_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($sktt_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(20);
		
		if($sktt_pdf['ttd_jenis'] !='' && $sktt_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Tempat_Tinggal","I"); 
	}



	/***********  SURAT KETERANGAN PERSETUJUAN MEMPELAI (skpm) **************/
	
	function skpm_pdf($nik)
	{
		
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skpm_pdf']		= $this->crud_model->get_a_skpm($nik);
		
		$data['agama1_pdf']		= $this->crud_model->get_a_agama1_skpm($nik);
		$data['agama2_pdf']		= $this->crud_model->get_a_agama2_skpm($nik);
		
		$data['pekerjaan1_pdf']	= $this->crud_model->get_a_pekerjaan1_skpm($nik);
		$data['pekerjaan2_pdf']	= $this->crud_model->get_a_pekerjaan2_skpm($nik);
		
		$data['jk1_pdf']	= $this->crud_model->get_a_jeniskelamin1_skpm($nik);
		$data['jk2_pdf']	= $this->crud_model->get_a_jeniskelamin2_skpm($nik);

		$skpm_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		
		$this->load->library('fpdf');
		
		$header_pdf = $data['header_pdf'];
		$skpm_pdf 	= $data['skpm_pdf'];
		
		$aga1_pdf 	= $data['agama1_pdf'];
		$aga2_pdf 	= $data['agama2_pdf'];
		
		$pek1_pdf 	= $data['pekerjaan1_pdf'];
		$pek2_pdf 	= $data['pekerjaan2_pdf'];
		
		$jk1_pdf 	= $data['jk1_pdf'];
		$jk2_pdf 	= $data['jk2_pdf'];
		
		$skpm_ttl1=$skpm_pdf['tmp_lahir1'].', '.$this->app_model->tgl_indo($skpm_pdf['tgl_lahir1']);
		$skpm_ttl2=$skpm_pdf['tmp_lahir2'].', '.$this->app_model->tgl_indo($skpm_pdf['tgl_lahir2']);
		
		$jsk='skpm';
		if($skpm_pdf['propinsi1']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi1($skpm_pdf['nmr_surat'],$jsk);
		$pro1_pdf = $data['pro_pdf'];
		$pro1_pdf = $pro1_pdf['nm_propinsi'];
		$pro1_pdf = ucwords(strtolower($pro1_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota1($skpm_pdf['nmr_surat'],$jsk);
		$kot1_pdf = $data['kot_pdf'];
		$kot1_pdf = $kot1_pdf['nm_kota'];	
		$kot1_pdf = ucwords(strtolower($kot1_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan1($skpm_pdf['nmr_surat'],$jsk);
		$kec1_pdf = $data['kec_pdf'];
		$kec1_pdf = $kec1_pdf['nm_kecamatan'];	
		$kec1_pdf = ucwords(strtolower($kec1_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan1($skpm_pdf['nmr_surat'],$jsk);
		$kel1_pdf = $data['kel_pdf'];
		$kel1_pdf = $kel1_pdf['nm_kelurahan'];	
		$kel1_pdf = ucwords(strtolower($kel1_pdf));
		}
		
		if($skpm_pdf['propinsi2']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi2($skpm_pdf['nmr_surat'],$jsk);
		$pro2_pdf = $data['pro_pdf'];
		$pro2_pdf = $pro2_pdf['nm_propinsi'];
		$pro2_pdf = ucwords(strtolower($pro2_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota2($skpm_pdf['nmr_surat'],$jsk);
		$kot2_pdf = $data['kot_pdf'];
		$kot2_pdf = $kot2_pdf['nm_kota'];	
		$kot2_pdf = ucwords(strtolower($kot2_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan2($skpm_pdf['nmr_surat'],$jsk);
		$kec2_pdf = $data['kec_pdf'];
		$kec2_pdf = $kec2_pdf['nm_kecamatan'];	
		$kec2_pdf = ucwords(strtolower($kec2_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan2($skpm_pdf['nmr_surat'],$jsk);
		$kel2_pdf = $data['kel_pdf'];
		$kel2_pdf = $kel2_pdf['nm_kelurahan'];	
		$kel2_pdf = ucwords(strtolower($kel2_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',14);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skpm'].'/ '.$skpm_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'I.   Calon Suami', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_pdf['skpm_nama1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_ttl1, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk1_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_pdf['kew_id1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga1_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek1_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skpm_pdf['propinsi1']!=''){
			$this->fpdf->Cell(60, 5,$skpm_pdf['alamat1'].' RT '.$skpm_pdf['rt1'].' / RW '.$skpm_pdf['rw1'].' '.$kel1_pdf, 0,0,'L');
		}else if($skpm_pdf['rt1']=='' && $skpm_pdf['rw1']==''){
			$this->fpdf->Cell(60, 5,$skpm_pdf['alamat1'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skpm_pdf['alamat1'].' RT '.$skpm_pdf['rt1'].' / RW '.$skpm_pdf['rw1'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skpm_pdf['propinsi1']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec1_pdf.' '.$kot1_pdf.' '.$pro1_pdf.' '.$skpm_pdf['kodepos1'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Cell(50, 5,'II. Calon Istri', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(50, 5,'     Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_pdf['skpm_nama2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_ttl2, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk2_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_pdf['kew_id2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga2_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     No. KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpm_pdf['nik2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek2_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skpm_pdf['propinsi2']!=''){
			$this->fpdf->Cell(60, 5,$skpm_pdf['alamat2'].' RT '.$skpm_pdf['rt2'].' / RW '.$skpm_pdf['rw2'].' '.$kel2_pdf, 0,0,'L');
		}else if($skpm_pdf['rt2']=='' && $skpm_pdf['rw2']==''){
			$this->fpdf->Cell(60, 5,$skpm_pdf['alamat2'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$skpm_pdf['alamat2'].' RT '.$skpm_pdf['rt2'].' / RW '.$skpm_pdf['rw2'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skpm_pdf['propinsi2']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec2_pdf.' '.$kot2_pdf.' '.$pro2_pdf.' '.$skpm_pdf['kodepos2'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Multicell(170, 5,'Menyatakan dengan sesungguhnya bahwa atas dasar sukarela, dengan kesadaran sendiri tanpa paksaan dari siapa pun juga, setuju untuk melangsungkan pernikahan.');
		
		$this->fpdf->Ln(6);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan Asal-Usul ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(2);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skpm_tglcetak, 0,0,'L');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(45, 5,'CALON SUAMI', 0,0,'C');
		$this->fpdf->Cell(200, 5,'CALON ISTRI', 0,0,'C');
		$this->fpdf->Ln(26);
		
		$this->fpdf->Cell(45, 5,$skpm_pdf['skpm_nama1'], 0,0,'C');
		$this->fpdf->Cell(200, 5,$skpm_pdf['skpm_nama2'], 0,0,'C');
		$this->fpdf->Ln(2);
		
		$this->fpdf->Cell(45, 5,'________________________', 0,0,'C');
		$this->fpdf->Cell(200, 5,'________________________', 0,0,'C');
		$this->fpdf->Ln(12);
				
		$this->fpdf->Output("Surat_Keterangan_Persetujuan_Mempelai","I"); 
	}


	/***********  SURAT KETERANGAN IZIN ORANG TUA UNTUK MENIKAH (siotm) **************/
	
	function siotm_pdf($nik)
	{
		
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['siotm_pdf']		= $this->crud_model->get_a_siotm($nik);
		
		$data['agama1_pdf']		= $this->crud_model->get_a_agama1_siotm($nik);
		$data['agama2_pdf']		= $this->crud_model->get_a_agama2_siotm($nik);
		$data['agama3_pdf']		= $this->crud_model->get_a_agama3_siotm($nik);
		$data['agama4_pdf']		= $this->crud_model->get_a_agama4_siotm($nik);
		
		$data['pekerjaan1_pdf']	= $this->crud_model->get_a_pekerjaan1_siotm($nik);
		$data['pekerjaan2_pdf']	= $this->crud_model->get_a_pekerjaan2_siotm($nik);
		$data['pekerjaan3_pdf']	= $this->crud_model->get_a_pekerjaan3_siotm($nik);
		$data['pekerjaan4_pdf']	= $this->crud_model->get_a_pekerjaan4_siotm($nik);
		
		$data['jk1_pdf']	= $this->crud_model->get_a_jeniskelamin1_siotm($nik);
		$data['jk2_pdf']	= $this->crud_model->get_a_jeniskelamin2_siotm($nik);
		$data['jk3_pdf']	= $this->crud_model->get_a_jeniskelamin3_siotm($nik);
		$data['jk4_pdf']	= $this->crud_model->get_a_jeniskelamin4_siotm($nik);
		
		$siotm_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		$this->load->library('fpdf');
		
		$header_pdf	= $data['header_pdf'];
		$siotm_pdf 	= $data['siotm_pdf'];
		
		$aga1_pdf 	= $data['agama1_pdf'];
		$aga2_pdf 	= $data['agama2_pdf'];
		$aga3_pdf 	= $data['agama3_pdf'];
		$aga4_pdf 	= $data['agama4_pdf'];
		
		$pek1_pdf 	= $data['pekerjaan1_pdf'];
		$pek2_pdf 	= $data['pekerjaan2_pdf'];
		$pek3_pdf 	= $data['pekerjaan3_pdf'];
		$pek4_pdf 	= $data['pekerjaan4_pdf'];
		
		$jk1_pdf 	= $data['jk1_pdf'];
		$jk2_pdf 	= $data['jk2_pdf'];
		$jk3_pdf 	= $data['jk3_pdf'];
		$jk4_pdf 	= $data['jk4_pdf'];
		
		$siotm_ttl1=$siotm_pdf['tmp_lahir1'].', '.$this->app_model->tgl_indo($siotm_pdf['tgl_lahir1']);
		$siotm_ttl2=$siotm_pdf['tmp_lahir2'].', '.$this->app_model->tgl_indo($siotm_pdf['tgl_lahir2']);
		$siotm_ttl3=$siotm_pdf['tmp_lahir3'].', '.$this->app_model->tgl_indo($siotm_pdf['tgl_lahir3']);
		$siotm_ttl4=$siotm_pdf['tmp_lahir4'].', '.$this->app_model->tgl_indo($siotm_pdf['tgl_lahir4']);
		
		$jsk='siotm';
		if($siotm_pdf['propinsi1']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi1($siotm_pdf['nmr_surat'],$jsk);
		$pro1_pdf = $data['pro_pdf'];
		$pro1_pdf = $pro1_pdf['nm_propinsi'];
		$pro1_pdf = ucwords(strtolower($pro1_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota1($siotm_pdf['nmr_surat'],$jsk);
		$kot1_pdf = $data['kot_pdf'];
		$kot1_pdf = $kot1_pdf['nm_kota'];	
		$kot1_pdf = ucwords(strtolower($kot1_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan1($siotm_pdf['nmr_surat'],$jsk);
		$kec1_pdf = $data['kec_pdf'];
		$kec1_pdf = $kec1_pdf['nm_kecamatan'];	
		$kec1_pdf = ucwords(strtolower($kec1_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan1($siotm_pdf['nmr_surat'],$jsk);
		$kel1_pdf = $data['kel_pdf'];
		$kel1_pdf = $kel1_pdf['nm_kelurahan'];	
		$kel1_pdf = ucwords(strtolower($kel1_pdf));
		}
		if($siotm_pdf['propinsi2']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi2($siotm_pdf['nmr_surat'],$jsk);
		$pro2_pdf = $data['pro_pdf'];
		$pro2_pdf = $pro2_pdf['nm_propinsi'];
		$pro2_pdf = ucwords(strtolower($pro2_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota2($siotm_pdf['nmr_surat'],$jsk);
		$kot2_pdf = $data['kot_pdf'];
		$kot2_pdf = $kot2_pdf['nm_kota'];	
		$kot2_pdf = ucwords(strtolower($kot2_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan2($siotm_pdf['nmr_surat'],$jsk);
		$kec2_pdf = $data['kec_pdf'];
		$kec2_pdf = $kec2_pdf['nm_kecamatan'];	
		$kec2_pdf = ucwords(strtolower($kec2_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan2($siotm_pdf['nmr_surat'],$jsk);
		$kel2_pdf = $data['kel_pdf'];
		$kel2_pdf = $kel2_pdf['nm_kelurahan'];	
		$kel2_pdf = ucwords(strtolower($kel2_pdf));
		}
		if($siotm_pdf['propinsi3']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi3($siotm_pdf['nmr_surat'],$jsk);
		$pro3_pdf = $data['pro_pdf'];
		$pro3_pdf = $pro3_pdf['nm_propinsi'];
		$pro3_pdf = ucwords(strtolower($pro3_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota3($siotm_pdf['nmr_surat'],$jsk);
		$kot3_pdf = $data['kot_pdf'];
		$kot3_pdf = $kot3_pdf['nm_kota'];	
		$kot3_pdf = ucwords(strtolower($kot3_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan3($siotm_pdf['nmr_surat'],$jsk);
		$kec3_pdf = $data['kec_pdf'];
		$kec3_pdf = $kec3_pdf['nm_kecamatan'];	
		$kec3_pdf = ucwords(strtolower($kec3_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan3($siotm_pdf['nmr_surat'],$jsk);
		$kel3_pdf = $data['kel_pdf'];
		$kel3_pdf = $kel3_pdf['nm_kelurahan'];	
		$kel3_pdf = ucwords(strtolower($kel3_pdf));
		}
		if($siotm_pdf['propinsi4']!=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->get_selected_propinsi4($siotm_pdf['nmr_surat'],$jsk);
		$pro4_pdf = $data['pro_pdf'];
		$pro4_pdf = $pro4_pdf['nm_propinsi'];
		$pro4_pdf = ucwords(strtolower($pro4_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->get_selected_kota4($siotm_pdf['nmr_surat'],$jsk);
		$kot4_pdf = $data['kot_pdf'];
		$kot4_pdf = $kot4_pdf['nm_kota'];	
		$kot4_pdf = ucwords(strtolower($kot4_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->get_selected_kecamatan4($siotm_pdf['nmr_surat'],$jsk);
		$kec4_pdf = $data['kec_pdf'];
		$kec4_pdf = $kec4_pdf['nm_kecamatan'];	
		$kec4_pdf = ucwords(strtolower($kec4_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->get_selected_kelurahan4($siotm_pdf['nmr_surat'],$jsk);
		$kel4_pdf = $data['kel_pdf'];
		$kel4_pdf = $kel4_pdf['nm_kelurahan'];	
		$kel4_pdf = ucwords(strtolower($kel4_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_siotm'].'/ '.$siotm_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(12);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(50, 5,'I.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['siotm_nama1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_ttl1, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk1_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['kew_id1'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga1_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek1_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($siotm_pdf['propinsi1']!=''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat1'].' RT '.$siotm_pdf['rt1'].' / RW '.$siotm_pdf['rw1'].' '.$kel1_pdf, 0,0,'L');
		}else if($siotm_pdf['rt1']=='' && $siotm_pdf['rw1']==''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat1'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat1'].' RT '.$siotm_pdf['rt1'].' / RW '.$siotm_pdf['rw1'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($siotm_pdf['propinsi1']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec1_pdf.' '.$kot1_pdf.' '.$pro1_pdf.' '.$siotm_pdf['kodepos1'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Cell(50, 5,'II.  Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['siotm_nama2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_ttl2, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk2_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['kew_id2'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga2_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek2_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($siotm_pdf['propinsi2']!=''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat2'].' RT '.$siotm_pdf['rt2'].' / RW '.$siotm_pdf['rw2'].' '.$kel2_pdf, 0,0,'L');
		}else if($siotm_pdf['rt2']=='' && $siotm_pdf['rw2']==''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat2'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat2'].' RT '.$siotm_pdf['rt2'].' / RW '.$siotm_pdf['rw2'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($siotm_pdf['propinsi2']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec2_pdf.' '.$kot2_pdf.' '.$pro2_pdf.' '.$siotm_pdf['kodepos2'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Cell(60, 5,'Adalah Ayah Kandung dan Ibu Kandung dari :', 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(50, 5,'     Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['siotm_nama3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_ttl3, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk3_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['kew_id3'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga3_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek3_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($siotm_pdf['propinsi3']!=''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat3'].' RT '.$siotm_pdf['rt3'].' / RW '.$siotm_pdf['rw3'].' '.$kel3_pdf, 0,0,'L');
		}else if($siotm_pdf['rt3']=='' && $siotm_pdf['rw3']==''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat3'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat3'].' RT '.$siotm_pdf['rt3'].' / RW '.$siotm_pdf['rw3'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($siotm_pdf['propinsi3']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec3_pdf.' '.$kot3_pdf.' '.$pro3_pdf.' '.$siotm_pdf['kodepos3'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		
		$this->fpdf->Cell(60, 5,'Memberikan izin kepadanya untuk melakukan pernikahan dengan :', 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(50, 5,'     Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['siotm_nama4'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_ttl4, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk4_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$siotm_pdf['kew_id4'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga4_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek4_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'     Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($siotm_pdf['propinsi4']!=''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat4'].' RT '.$siotm_pdf['rt4'].' / RW '.$siotm_pdf['rw4'].' '.$kel4_pdf, 0,0,'L');
		}else if($siotm_pdf['rt4']=='' && $siotm_pdf['rw4']==''){
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat4'], 0,0,'L');
		}else{
			$this->fpdf->Cell(60, 5,$siotm_pdf['alamat4'].' RT '.$siotm_pdf['rt4'].' / RW '.$siotm_pdf['rw4'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($siotm_pdf['propinsi4']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(60, 5,$kec4_pdf.' '.$kot4_pdf.' '.$pro4_pdf.' '.$siotm_pdf['kodepos4'], 0,0,'L');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Ln(14);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan izin orang tua ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$siotm_tglcetak, 0,0,'L');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(45, 5,'AYAH,', 0,0,'C');
		$this->fpdf->Cell(200, 5,'IBU,', 0,0,'C');
		$this->fpdf->Ln(26);
		
		$this->fpdf->Cell(45, 5,$siotm_pdf['siotm_nama1'], 0,0,'C');
		$this->fpdf->Cell(200, 5,$siotm_pdf['siotm_nama2'], 0,0,'C');
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(45, 5,'______________________', 0,0,'C');
		$this->fpdf->Cell(200, 5,'_____________________', 0,0,'C');
		$this->fpdf->Ln(12);
				
		$this->fpdf->Output("Surat_Keterangan_Izin_Orangtua_Untuk_Menikah","I"); 
	}

/***********  SURAT KETERANGAN DAFTAR KELUARGA (skdk) **************/
	
	function skdk_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skdk_pdf']		= $this->crud_model->get_a_skdk($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skdk($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skdk($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skdk($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skdk_pdf 		= $data['skdk_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skdk_ttl		= $skdk_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skdk_pdf['tgl_lahir']);
		$skdk_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		// Ini Untuk Anggota Tanggungan //
		$skdk_nm1		= $skdk_pdf['tmp1'].', '.$this->app_model->tgl_str($skdk_pdf['tgl1']).' / '.$this->app_model->umur_str($skdk_pdf['tgl1']).'Thn';
		$skdk_nm2		= $skdk_pdf['tmp2'].', '.$this->app_model->tgl_str($skdk_pdf['tgl2']).' / '.$this->app_model->umur_str($skdk_pdf['tgl2']).'Thn';
		$skdk_nm3		= $skdk_pdf['tmp3'].', '.$this->app_model->tgl_str($skdk_pdf['tgl3']).' / '.$this->app_model->umur_str($skdk_pdf['tgl3']).'Thn';
		$skdk_nm4		= $skdk_pdf['tmp4'].', '.$this->app_model->tgl_str($skdk_pdf['tgl4']).' / '.$this->app_model->umur_str($skdk_pdf['tgl4']).'Thn';
		$skdk_nm5		= $skdk_pdf['tmp5'].', '.$this->app_model->tgl_str($skdk_pdf['tgl5']).' / '.$this->app_model->umur_str($skdk_pdf['tgl5']).'Thn';
		$skdk_nm6		= $skdk_pdf['tmp6'].', '.$this->app_model->tgl_str($skdk_pdf['tgl6']).' / '.$this->app_model->umur_str($skdk_pdf['tgl6']).'Thn';
		
		$jsk='skdk';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skdk_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skdk_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skdk_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skdk_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skdk_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skdk_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skdk'].'/ '.$skdk_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
				
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdk_pdf['skdk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdk_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdk_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdk_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'8.   No. Kartu Keluarga', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skdk_pdf['no_kk'], 0,0,'L');
		$this->fpdf->Ln(6);

		$this->fpdf->Cell(50, 5,'9.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skdk_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skdk_pdf['alamat'].' RT '.$skdk_pdf['rt'].' / RW '.$skdk_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skdk_pdf['rt']=='' && $skdk_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skdk_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skdk_pdf['alamat'].' RT '.$skdk_pdf['rt'].' / RW '.$skdk_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skdk_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skdk_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'10. Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(10);
		
		$this->fpdf->Cell(18, 5,'Membuat ');
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->Cell(60,5,'Surat Keterangan Daftar Keluarga ',0,0,'J');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Cell(70,5,'ini adalah untuk menerangkan bahwa nama tersebut diatas',0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Multicell(170, 5,'adalah benar-benar warga kami dan mempunyai tanggungan keluarga sebagaimana tercatat dalam kartu keluarga yang ada pada kami seperti di bawah ini.');
		$this->fpdf->Ln();
		$this->fpdf->Line(1.6,1.1,1,1.1); 
		$this->fpdf->Cell(10,12.5,'No.',1,0,'C');
		$this->fpdf->Cell(50,12.5,'Nama',1,0,'C');
		$this->fpdf->Cell(53,12.5,'Tempat/Tgl Lahir/Umur',1,0,'C');
		$this->fpdf->Cell(30,12.5,'Hub. Keluarga',1,0,'C');
		$this->fpdf->Cell(30,12.5,'Keterangan',1,0,'C');
		$this->fpdf->Ln();
		if(!empty($skdk_pdf['nm1']) && !empty($skdk_pdf['tmp1']) && $skdk_pdf['tgl1']!=='0000-00-00'){
		$this->fpdf->Cell(10,6,'1',1,0,'C');
		$this->fpdf->Cell(50,6,$skdk_pdf['nm1'],1,0,'J');
		$this->fpdf->Cell(53,6,$skdk_nm1,1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['hub1'],1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['ket1'],1,0,'J');
		$this->fpdf->Ln();
		}
		if(!empty($skdk_pdf['nm2']) && !empty($skdk_pdf['tmp2']) && $skdk_pdf['tgl2']!=='0000-00-00'){
		$this->fpdf->Cell(10,6,'2',1,0,'C');
		$this->fpdf->Cell(50,6,$skdk_pdf['nm2'],1,0,'J');
		$this->fpdf->Cell(53,6,$skdk_nm2,1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['hub2'],1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['ket2'],1,0,'J');
		$this->fpdf->Ln();
		}
		if(!empty($skdk_pdf['nm3']) && !empty($skdk_pdf['tmp3']) && $skdk_pdf['tgl3']!=='0000-00-00'){
		$this->fpdf->Cell(10,6,'3',1,0,'C');
		$this->fpdf->Cell(50,6,$skdk_pdf['nm3'],1,0,'J');
		$this->fpdf->Cell(53,6,$skdk_nm3,1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['hub3'],1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['ket3'],1,0,'J');
		$this->fpdf->Ln();
		}
		if(!empty($skdk_pdf['nm4']) && !empty($skdk_pdf['tmp4']) && $skdk_pdf['tgl4']!=='0000-00-00'){
		$this->fpdf->Cell(10,6,'4',1,0,'C');
		$this->fpdf->Cell(50,6,$skdk_pdf['nm4'],1,0,'J');
		$this->fpdf->Cell(53,6,$skdk_nm4,1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['hub4'],1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['ket4'],1,0,'J');
		$this->fpdf->Ln();
		}
		if(!empty($skdk_pdf['nm5']) && !empty($skdk_pdf['tmp5']) && $skdk_pdf['tgl5']!=='0000-00-00'){
		$this->fpdf->Cell(10,6,'5',1,0,'C');
		$this->fpdf->Cell(50,6,$skdk_pdf['nm5'],1,0,'J');
		$this->fpdf->Cell(53,6,$skdk_nm5,1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['hub5'],1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['ket5'],1,0,'J');
		$this->fpdf->Ln();
		}
		if(!empty($skdk_pdf['nm6']) && !empty($skdk_pdf['tmp6']) && $skdk_pdf['tgl6']!=='0000-00-00'){
		$this->fpdf->Cell(10,6,'6',1,0,'C');
		$this->fpdf->Cell(50,6,$skdk_pdf['nm6'],1,0,'J');
		$this->fpdf->Cell(53,6,$skdk_nm6,1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['hub6'],1,0,'J');
		$this->fpdf->Cell(30,6,$skdk_pdf['ket6'],1,0,'J');
		$this->fpdf->Ln();
		}
		$this->fpdf->Ln(5);
		
		$this->fpdf->Multicell(170, 5,'Keterangan ini di pergunakan untuk keperluan'.$skdk_pdf['keperluan']);
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(8);
		$this->fpdf->Cell(2, 5,'Mengetahui', 0,0,'L');
		$this->fpdf->Cell(136, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skdk_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(45, 5,'CAMAT', 0,0,'C');
		$this->fpdf->Cell(90, 5,'', 0,0,'L');
		$this->fpdf->SetFont('Times','B',11);
		if($skdk_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(18, 5,'LURAH', 0,0,'C');
		}else if($skdk_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(18, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(168, 5,'', 0,0,'C');
		}
		$this->fpdf->Ln(16);
		$this->fpdf->SetFont('Times','',12);
		
		$this->fpdf->Cell(2, 5,'_____________________', 0,0,'L');
		if($skdk_pdf['ttd_jenis'] !='' && $skdk_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Daftar_Keluarga","I"); 
	}



	/***********  SURAT KETERANGAN PENGANTAR NAIK HAJI (SKPNH) **************/
	
	function skpnh_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skpnh_pdf']		= $this->crud_model->get_a_skpnh($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skpnh($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skpnh($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skpnh($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skpnh_pdf 		= $data['skpnh_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skpnh_ttl		= $skpnh_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skpnh_pdf['tgl_lahir']);
		$skpnh_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skpnh';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skpnh_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		
		if($skpnh_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skpnh_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skpnh_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skpnh_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skpnh_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skpnh'].'/ '.$skpnh_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skpnh_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpnh_pdf['skpnh_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpnh_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpnh_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skpnh_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.  Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'8.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skpnh_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skpnh_pdf['alamat'].' RT '.$skpnh_pdf['rt'].' / RW '.$skpnh_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skpnh_pdf['rt']=='' && $skpnh_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skpnh_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skpnh_pdf['alamat'].' RT '.$skpnh_pdf['rt'].' / RW '.$skpnh_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skpnh_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skpnh_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'9.   Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->MultiCell(170, 5,'Membuat surat keterangan ini adalah untuk menerangkan bahwa nama tersebut diatas adalah benar-benar warga kami dan berdomisili pada alamat tersebut diatas berdasarkan surat pernyataan (terlampir). Surat Keterangan ini dipergunakan untuk keperluan pendaftaran calon jemaah haji.');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','',12);
		//$this->fpdf->Ln(8);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(12);
		$this->fpdf->Cell(2, 5,'Mengetahui', 0,0,'L');
		$this->fpdf->Ln(1);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skpnh_tglcetak, 0,0,'L');
		
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(32, 5,'CAMAT', 0,0,'C');
		$this->fpdf->Cell(80, 5,'', 0,0,'J');
		
		$this->fpdf->SetFont('Times','B',11);
		if($skpnh_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
		}else if($skpnh_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(168, 5,'', 0,0,'C');
		}
		$this->fpdf->Ln(22);
		$this->fpdf->SetFont('Times','',12);
		
		//$this->fpdf->Cell(60, 5,$skpnh_pdf['ttd_mengetahui'], 0,0,'L');
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(2, 5,'_____________________', 0,0,'L');
		if($skpnh_pdf['ttd_jenis'] !='' && $skpnh_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Pengantar_Naik_Haji","I"); 
	}	

/***********  SURAT KETERANGAN AHLI WARIS (skaw) **************/
	
	function skaw_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skaw_pdf']		= $this->crud_model->get_a_skaw($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skaw($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skaw($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skaw($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skaw_pdf 		= $data['skaw_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skaw_ttl		= $skaw_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skaw_pdf['tgl_lahir']);
		$skaw_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skaw';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skaw_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];		
		
		if($skaw_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skaw_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skaw_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skaw_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skaw_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',15);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skaw'].'/ '.$skaw_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
				
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skaw_pdf['skaw_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skaw_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skaw_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skaw_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);

		$this->fpdf->Cell(50, 5,'8.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skaw_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skaw_pdf['alamat'].' RT '.$skaw_pdf['rt'].' / RW '.$skaw_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skaw_pdf['rt']=='' && $skaw_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skaw_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skaw_pdf['alamat'].' RT '.$skaw_pdf['rt'].' / RW '.$skaw_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skaw_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skaw_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'9.   Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Multicell(170, 5,'Atas nama keluarga...................................................membuat surat keterangan ini untuk menerangkan, dengan sanggup diangkat sumpah menyatakan bahwa kami adalah ahli waris dari almarhum Bapak................................................., yang meninggal dunia pada hari................................., bertempat tinggal terakhir di.....................................Kelurahan.................................Kecamatan.................................... Kota Bogor.');
		$this->fpdf->Ln(2);
		$this->fpdf->Multicell(170, 5,'Dari pernikahan Bapak........................ dengan Ibu.................. dilahirkan ........orang anak terdiri dari:');
		$this->fpdf->Ln(1);
		$this->fpdf->Line(1.1,1.1,1,1.1); 
		$this->fpdf->Cell(15,8.5,'No.',1,0,'C');
		$this->fpdf->Cell(38,8.5,'Nama',1,0,'C');
		$this->fpdf->Cell(42,8.5,' Tempat/Tgl Lahir/Umur ',1,0,'C');
		$this->fpdf->Cell(40,8.5,'Alamat',1,0,'C');
		$this->fpdf->Cell(38,8.5,'Keterangan',1,0,'C');
		$this->fpdf->Ln();
		$this->fpdf->Cell(15,12.5,'',1,0,'C');
		$this->fpdf->Cell(38,12.5,'',1,0,'C');
		$this->fpdf->Cell(42,12.5,'',1,0,'C');
		$this->fpdf->Cell(40,12.5,'',1,0,'C');
		$this->fpdf->Cell(38,12.5,'',1,0,'C');
		$this->fpdf->Ln(16);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, dan kami bersedia dituntut di Pengadilan apabila kami memberikan pernyataan yang tidak benar, dengan tidak melibatkan pihak yang mengetahui dan menandatangai pernyataan ini. ');
		$this->fpdf->Ln(1);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skaw_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(2, 5,'Saksi-Saksi : ', 0,0,'L');
		$this->fpdf->Cell(150, 5,'Yang Menyatakan,', 0,0,'R');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(2, 5,'1. ...................................', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(2, 5,'2. ...................................', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(2, 5,'3. dst.', 0,0,'L');
		$this->fpdf->Ln(2);
		$this->fpdf->SetFont('Times','U',11);
		$this->fpdf->Cell(270, 5,$skaw_pdf['skaw_nama'], 0,0,'C');
		
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->Ln(2);
		$this->fpdf->Cell(100, 5,'MENGETAHUI', 0,0,'R');
		
		$this->fpdf->Ln(4);
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Cell(2, 5,'Ketua RW,......... ', 0,0,'L');
		$this->fpdf->Cell(146, 5,'Ketua RT,.........', 0,0,'R');
		$this->fpdf->Ln(8);
		$this->fpdf->Cell(2, 5,'_____________________', 0,0,'L');
		$this->fpdf->Cell(162, 5,'_____________________', 0,0,'R');
		$this->fpdf->Ln(8);
		$this->fpdf->Cell(2, 5,'CAMAT,...........', 0,0,'L');
		if($skaw_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(146, 5,'LURAH', 0,0,'R');
		}else if($skaw_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(146, 5,'An. LURAH', 0,0,'R');
		}else{
			$this->fpdf->Cell(146, 5,'', 0,0,'R');
		}
		$this->fpdf->Ln(8);
		$this->fpdf->Cell(2, 5,'_____________________', 0,0,'L');
		if($skaw_pdf['ttd_jenis'] !='' && $skaw_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(2, 5,'', 0,0,'J');
			$this->fpdf->Cell(166, 5,'_________________________', 0,0,'R');
			$this->fpdf->Ln();
			$this->fpdf->Cell(166, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'R');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(2, 5,'_____________________', 0,0,'R');
		}
		$this->fpdf->Ln();
		$this->fpdf->Ln(12);
		
		$this->fpdf->Output("Surat_Keterangan_Ahli_Waris","I"); 
	}


	/***********  SURAT KETERANGAN PENGANTAR SPPT (skppsp) **************/
	
	function skppsp_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skppsp_pdf']		= $this->crud_model->get_a_skppsp($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skppsp($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skppsp($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skppsp($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skppsp_pdf 	= $data['skppsp_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skppsp_ttl		= $skppsp_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skppsp_pdf['tgl_lahir']);
		$skppsp_tglcetak= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skppsp';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skppsp_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skppsp_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skppsp_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skppsp_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skppsp_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skppsp_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		
		// Selected Propinsi //
		$data['pro2_pdf'] = $this->crud_model->get_selected_propinsi2($skppsp_pdf['nmr_surat'],$jsk);
		$pro2_pdf = $data['pro2_pdf'];
		$pro2_pdf = $pro2_pdf['nm_propinsi'];
		$pro2_pdf = ucwords(strtolower($pro2_pdf));

		// Selected Kota //		
		$data['kot2_pdf'] = $this->crud_model->get_selected_kota2($skppsp_pdf['nmr_surat'],$jsk);
		$kot2_pdf = $data['kot2_pdf'];
		$kot2_pdf = $kot2_pdf['nm_kota'];	
		$kot2_pdf = ucwords(strtolower($kot2_pdf));
		
		// Selected Kecamatan //	
		$data['kec2_pdf'] = $this->crud_model->get_selected_kecamatan2($skppsp_pdf['nmr_surat'],$jsk);
		$kec2_pdf = $data['kec2_pdf'];
		$kec2_pdf = $kec2_pdf['nm_kecamatan'];	
		$kec2_pdf = ucwords(strtolower($kec2_pdf));
		
		// Selected Kelurahan //	
		$data['kel2_pdf'] = $this->crud_model->get_selected_kelurahan2($skppsp_pdf['nmr_surat'],$jsk);
		$kel2_pdf = $data['kel2_pdf'];
		$kel2_pdf = $kel2_pdf['nm_kelurahan'];	
		$kel2_pdf = ucwords(strtolower($kel2_pdf));
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skppsp'].'/ '.$skppsp_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skppsp_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skppsp_pdf['skppsp_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skppsp_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skppsp_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skppsp_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'8.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skppsp_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skppsp_pdf['alamat'].' RT '.$skppsp_pdf['rt'].' / RW '.$skppsp_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skppsp_pdf['rt']=='' && $skppsp_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skppsp_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skppsp_pdf['alamat'].' RT '.$skppsp_pdf['rt'].' / RW '.$skppsp_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skppsp_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skppsp_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'9.   Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(12);
		
		$bold1 = 'Balik Nama/Pembetulan SPPT PBB ke Dinas Pendapatan Daerah Kota Bogor';
		$bold2 = 'Pemilik/Pemanfaat';
		
		$this->fpdf->Multicell(170, 5,'Membuat surat keterangan ini adalah sebagai persyaratan dalam pengurusan '.$bold1.' berdasarkan Surat Pernyataan bersangkutan yang menyatakan bahwa nama tersebut diatas adalah benar '.$bold2.' sebidang tanah seluas '.$skppsp_pdf['luas_tanah'].' m2 dan Bangunan diatasnya seluas '.$skppsp_pdf['luas_bangun'].' m2 yang terletak di '.$skppsp_pdf['alamat2'].' RT '.$skppsp_pdf['rt2'].' RW '.$skppsp_pdf['rw2'].' '.$kel2_pdf.', '.$kec2_pdf.' dengan bukti perpajakan berupa SPPT PBB dengan NOP '.$skppsp_pdf['nop'].' dan sesuai dengan bukti alas hak atas tanah yang dimiliki.');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skppsp_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($skppsp_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skppsp_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(16);
		
		if($skppsp_pdf['ttd_jenis'] !='' && $skppsp_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Pengantar_Penerbitan_SPPT_PBB","I"); 
	}	

/***********  SURAT KETERANGAN RIWAYAT TANAH (skrt) **************/
	
	function skrt_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skrt_pdf']		= $this->crud_model->get_a_skrt($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skrt($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skrt($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skrt($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skrt_pdf 		= $data['skrt_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skrt_ttl		= $skrt_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skrt_pdf['tgl_lahir']);
		$skrt_tgl_beralih1	= $this->app_model->tgl_indo($skrt_pdf['tgl_beralih1']);
		$skrt_tgl_beralih2	= $this->app_model->tgl_indo($skrt_pdf['tgl_beralih2']);
		
		$skrt_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skrt';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skrt_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];		
		
		if($skrt_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skrt_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skrt_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //$skrt_pdf
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skrt_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skrt_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		
		// Selected Propinsi //
		$data['pro2_pdf'] = $this->crud_model->get_selected_propinsi2($skrt_pdf['nmr_surat'],$jsk);
		$pro2_pdf = $data['pro2_pdf'];
		$pro2_pdf = $pro2_pdf['nm_propinsi'];
		$pro2_pdf = ucwords(strtolower($pro2_pdf));

		// Selected Kota //		
		$data['kot2_pdf'] = $this->crud_model->get_selected_kota2($skrt_pdf['nmr_surat'],$jsk);
		$kot2_pdf = $data['kot2_pdf'];
		$kot2_pdf = $kot2_pdf['nm_kota'];	
		$kot2_pdf = ucwords(strtolower($kot2_pdf));
		
		// Selected Kecamatan //	
		$data['kec2_pdf'] = $this->crud_model->get_selected_kecamatan2($skrt_pdf['nmr_surat'],$jsk);
		$kec2_pdf = $data['kec2_pdf'];
		$kec2_pdf = $kec2_pdf['nm_kecamatan'];	
		$kec2_pdf = ucwords(strtolower($kec2_pdf));
		
		// Selected Kelurahan //	
		$data['kel2_pdf'] = $this->crud_model->get_selected_kelurahan2($skrt_pdf['nmr_surat'],$jsk);
		$kel2_pdf = $data['kel2_pdf'];
		$kel2_pdf = $kel2_pdf['nm_kelurahan'];	
		$kel2_pdf = ucwords(strtolower($kel2_pdf));
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skrt'].'/ '.$skrt_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skrt_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skrt_pdf['skrt_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skrt_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skrt_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skrt_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'8.   NOP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skrt_pdf['nop'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'9.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skrt_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skrt_pdf['alamat'].' RT '.$skrt_pdf['rt'].' / RW '.$skrt_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skrt_pdf['rt']=='' && $skrt_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skrt_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skrt_pdf['alamat'].' RT '.$skrt_pdf['rt'].' / RW '.$skrt_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skrt_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skrt_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'10. Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->MultiCell(180, 6,'Membuat surat keterangan ini adalah sebagai persyaratan dalam pengurusan Pendaftaran Baru SPPT PBB  ke Dinas	Pendapatan Daerah Kota Bogor berdasarkan  Surat  Pernyataan  bersangkutan  yang menyatakan bahwa nama tersebut diatas adalah benar Pemilik/Pemanfaat sebidang tanah nomor C : '.$skrt_pdf['no_c'].', nomor Persil : '.$skrt_pdf['no_parsil'].' seluas '.$skrt_pdf['lt_pemilik'].' m2 dan Bangunan diatasnya seluas '.$skrt_pdf['lb_pemilik'].' m2 yang terletak di '.$skrt_pdf['alamat2'].' Rt '.$skrt_pdf['rt_pemilik'].' Rw '.$skrt_pdf['rw_pemilik'].' kelurahan '.$kel2_pdf.' ' );
		$this->fpdf->Ln(1);
		
		$this->fpdf->MultiCell(180, 5,'Adapun objek sebagaimana dimaksud sesuai dengan data yang ada/tercatat di Kelurahan belum pernah terbit SPPT PBB atas nama siapapun dan riwayat kepemilikan objek berasal dari :');
		$this->fpdf->Ln(2);
		$this->fpdf->Cell(170, 5,'      a.   Sejak Tahun '.$skrt_pdf['s_tahun'].' tercatat dalam leter C/girik atas nama '.$skrt_pdf['a_nama'].'', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'      b.   Pada tanggal '.$skrt_tgl_beralih1.' beralih kepada '.$skrt_pdf['a_nama1'].'', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'            Berdasarkan '.$skrt_pdf['dasar1'].'', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'      c.   Pada tanggal  '.$skrt_tgl_beralih2.' beralih kepada '.$skrt_pdf['a_nama2'].'', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'            Berdasarkan '.$skrt_pdf['dasar2'].'', 0,0,'J');
		$this->fpdf->Ln(8);
		
		
		$this->fpdf->Multicell(180, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya.');
		$this->fpdf->Ln(1);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skrt_tglcetak, 0,0,'L');
		$this->fpdf->Ln(4);
		$this->fpdf->SetFont('Times','B',11);
		if($skrt_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skrt_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(15);
		
		if($skrt_pdf['ttd_jenis'] !='' && $skrt_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Riwayat_Tanah","I"); 
	}

/***********  SURAT KETERANGAN BELUM MEMILIKI RUMAH (SKBMR) **************/
	
	function skbmr_pdf($nik)
	{
		$data['header_pdf']		= $this->crud_model->get_header();
		$data['skbmr_pdf']		= $this->crud_model->get_a_skbmr($nik);
		$data['agama_pdf']		= $this->crud_model->get_a_agama_skbmr($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skbmr($nik);
		$data['jk_pdf']			= $this->crud_model->get_a_jeniskelamin_skbmr($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skbmr_pdf 		= $data['skbmr_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skbmr_ttl		= $skbmr_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skbmr_pdf['tgl_lahir']);
		$skbmr_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skbmr';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skbmr_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];		
		
		if($skbmr_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skbmr_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skbmr_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skbmr_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skbmr_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skbmr'].'/ '.$skbmr_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skbmr_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbmr_pdf['skbmr_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbmr_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbmr_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skbmr_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'8.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skbmr_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skbmr_pdf['alamat'].' RT '.$skbmr_pdf['rt'].' / RW '.$skbmr_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skbmr_pdf['rt']=='' && $skbmr_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skbmr_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skbmr_pdf['alamat'].' RT '.$skbmr_pdf['rt'].' / RW '.$skbmr_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skbmr_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skbmr_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'9.   Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(18, 5,'      Membuat ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(80, 5,'      Surat Keterangan Belum Memiliki Rumah ', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(170, 5,'      ini adalah untuk menerangkan bahwa ', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'      nama tersebut diatas adalah benar warga kami dan sampai saat ini belum memiliki rumah/huni-', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'      an/masih menumpang berdasarkan Surat Pernyataan yang dibuat (terlampir).', 0,0,'J');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya, apabila dikemudian hari terdapat keterangan yang tidak benar maka nama yang diterangkat diatas, bersedia mengembalikan fasilitas likuiditas pembiayaan perumahan yang diterima dan bersedia dituntut di muka pengadilan serta bersedia menerima tindakan hukum yang diambil secara perdata maupun pidana.');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skbmr_tglcetak, 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','B',11);
		if($skbmr_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skbmr_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(16);
		
		if($skbmr_pdf['ttd_jenis'] !='' && $skbmr_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Belum_Memiliki_Rumah","I"); 
	}
		


/***********  SURAT KETERANGAN JANDA/DUDA (SKJD) **************/
	
	function skjd_pdf($nik)
	{
		$data['header_pdf']	= $this->crud_model->get_header();
		$data['skjd_pdf']	= $this->crud_model->get_a_skjd($nik);
		$data['agama_pdf']	= $this->crud_model->get_a_agama_skjd($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skjd($nik);
		$data['jk_pdf']	= $this->crud_model->get_a_jeniskelamin_skjd($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf = $data['header_pdf'];
		$skjd_pdf 	= $data['skjd_pdf'];
		$aga_pdf 	= $data['agama_pdf'];
		$pek_pdf 	= $data['pekerjaan_pdf'];
		$jk_pdf 	= $data['jk_pdf'];
		
		$skjd_ttl	= $skjd_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skjd_pdf['tgl_lahir']);
		$skjd_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skjd';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skjd_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		
		if($skjd_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skjd_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skjd_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skjd_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skjd_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skjd'].'/ '.$skjd_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skjd_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skjd_pdf['skjd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skjd_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skjd_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skjd_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'8.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skjd_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skjd_pdf['alamat'].' RT '.$skjd_pdf['rt'].' / RW '.$skjd_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skjd_pdf['rt']=='' && $skjd_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skjd_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skjd_pdf['alamat'].' RT '.$skjd_pdf['rt'].' / RW '.$skjd_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skjd_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skjd_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'9.   Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(18, 5,'      Membuat ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(76, 5,'      Surat Keterangan Cerai Mati atau Hidup ', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(80, 5,'      ini adalah untuk menerangkan bahwa nama  ', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(170, 5,'      tersebut diatas adalah benar warga kami, pernah menikah dan saat ini berstatus Cerai.', 0,0,'J');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya. ');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skjd_tglcetak, 0,0,'L');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','B',11);
		if($skjd_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skjd_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(16);
		
		if($skjd_pdf['ttd_jenis'] !='' && $skjd_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
		$this->fpdf->Cell(115, 5,'', 0,0,'J');
		$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
		$this->fpdf->Ln(8);
		}
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(115, 5,'Keterangan :', 0,0,'L');
		
		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(50, 5,'1. Fotocopy Akta Cerai, atau', 0,0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(50, 5,'2.	Surat Keterangan Kematian Istri atau Suami.', 0,0,'L');
		
		$this->fpdf->Output("Surat_Keterangan_Janda_Duda","I"); 
	}


	/***********  SURAT KETERANGAN PENGHASILAN TIDAK TETAP (SKPTT) **************/
	
	function skptt_pdf($nik)
	{
		$data['header_pdf']	= $this->crud_model->get_header();
		$data['skptt_pdf']	= $this->crud_model->get_a_skptt($nik);
		$data['agama_pdf']	= $this->crud_model->get_a_agama_skptt($nik);
		$data['pekerjaan_pdf']	= $this->crud_model->get_a_pekerjaan_skptt($nik);
		$data['jk_pdf']	= $this->crud_model->get_a_jeniskelamin_skptt($nik);
		
		$this->load->library('fpdf');
		
		$header_pdf 	= $data['header_pdf'];
		$skptt_pdf 		= $data['skptt_pdf'];
		$aga_pdf 		= $data['agama_pdf'];
		$pek_pdf 		= $data['pekerjaan_pdf'];
		$jk_pdf 		= $data['jk_pdf'];
		
		$skptt_ttl		= $skptt_pdf['tmp_lahir'].', '.$this->app_model->tgl_indo($skptt_pdf['tgl_lahir']);
		$skptt_tglcetak	= $this->app_model->tgl_indo(date("Y-m-d"));
		
		$jsk='skptt';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skptt_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		if($skptt_pdf['propinsi'] !=''){
		// Selected Propinsi //
		$data['pro_pdf'] = $this->crud_model->selected_propinsi($skptt_pdf['nmr_surat'],$jsk);
		$pro_pdf = $data['pro_pdf'];
		$pro_pdf = $pro_pdf['nm_propinsi'];
		$pro_pdf = ucwords(strtolower($pro_pdf));

		// Selected Kota //		
		$data['kot_pdf'] = $this->crud_model->selected_kota($skptt_pdf['nmr_surat'],$jsk);
		$kot_pdf = $data['kot_pdf'];
		$kot_pdf = $kot_pdf['nm_kota'];	
		$kot_pdf = ucwords(strtolower($kot_pdf));
		
		// Selected Kecamatan //	
		$data['kec_pdf'] = $this->crud_model->selected_kecamatan($skptt_pdf['nmr_surat'],$jsk);
		$kec_pdf = $data['kec_pdf'];
		$kec_pdf = $kec_pdf['nm_kecamatan'];	
		$kec_pdf = ucwords(strtolower($kec_pdf));
		
		// Selected Kelurahan //	
		$data['kel_pdf'] = $this->crud_model->selected_kelurahan($skptt_pdf['nmr_surat'],$jsk);
		$kel_pdf = $data['kel_pdf'];
		$kel_pdf = $kel_pdf['nm_kelurahan'];	
		$kel_pdf = ucwords(strtolower($kel_pdf));
		}
		
		$this->fpdf->FPDF('P','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Image('uploads/logo.gif',20,15,25);
		$this->fpdf->Cell(180, 1, $header_pdf['s_kota'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',16);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kecamatan'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(180, 1,$header_pdf['s_kelurahan'], 5,0,'C');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(180, 5,$header_pdf['s_alamat'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_tlp_fax'], 0,0,'C');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,$header_pdf['s_url'], 0,0,'C');
		$this->fpdf->SetLineWidth(1);
		$this->fpdf->Line(20,50,190,50);
		$this->fpdf->SetLineWidth(0);
		$this->fpdf->Line(19.5,51,190.5,51);
		$this->fpdf->SetFont('Times','BU',16);
		$this->fpdf->Ln(16);
		
		$this->fpdf->Cell(180, 5,'SURAT KETERANGAN', 0,0,'C');
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(180, 5,'Nomor :   '.$header_pdf['no_skptt'].'/ '.$skptt_pdf['nomor'].' - '.$header_pdf['kd_kelurahan'], 0,0,'C');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(60, 5,'Yang bertanda tangan dibawah ini :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'a. Nama       :  '.$ttd_pdf['ttd_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		if($skptt_pdf['ttd_jenis'] =='1'){
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   LURAH '.$header_pdf['lok_lurah'], 0,0,'L');
		}else{
		$this->fpdf->Cell(60, 5,'b. Jabatan    :   '.$ttd_pdf['ttd_jab'], 0,0,'L');	
		}
		
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(60, 5,'dengan ini menerangkan bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skptt_pdf['skptt_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'2.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skptt_ttl, 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'3.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$jk_pdf['jk_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'4.   Kewarganegaraan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skptt_pdf['kew_id'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'6.   No KTP', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skptt_pdf['nik'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'7.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(50, 5,'8.   Alamat', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skptt_pdf['propinsi']!=''){
			$this->fpdf->Cell(110, 5,$skptt_pdf['alamat'].' RT '.$skptt_pdf['rt'].' / RW '.$skptt_pdf['rw'].' '.$kel_pdf, 0,0,'L');
		}else if($skptt_pdf['rt']=='' && $skptt_pdf['rw']==''){
			$this->fpdf->Cell(110, 5,$skptt_pdf['alamat'], 0,0,'L');
		}else{
			$this->fpdf->Cell(110, 5,$skptt_pdf['alamat'].' RT '.$skptt_pdf['rt'].' / RW '.$skptt_pdf['rw'], 0,0,'L');
		}
		$this->fpdf->Ln(6);
		
		if($skptt_pdf['propinsi']!=''){
			$this->fpdf->Cell(50, 5,'', 0,0,'L');
			$this->fpdf->Cell(5, 5,'', 0,0,'L');
			$this->fpdf->Cell(110, 5,$kec_pdf.' '.$kot_pdf.' '.$pro_pdf.' '.$skptt_pdf['kodepos'], 0,0,'L');
			$this->fpdf->Ln(6);
		}
		
		$this->fpdf->Cell(50, 5,'9.   Maksud', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Ln(12);
		
		$this->fpdf->Cell(18, 5,'      Membuat ', 0,0,'J');
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Cell(80, 5,'      Surat Keterangan Penghasilan Tidak Tetap', 0,0,'J');
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(40, 5,'       ini adalah untuk menerangkan bahwa ', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(100, 5,'      nama tersebut diatas adalah benar warga kami, dan bahwasanya benar yang bersangkutan memi-', 0,0,'J');
		$this->fpdf->Ln();
		$this->fpdf->Cell(100, 5,'      liki penghasilan tidak tetap berdasarkan Surat Pernyataan yang dibuat (terlampir).', 0,0,'J');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Multicell(170, 5,'Demikian Surat Keterangan ini dibuat atas dasar yang sebenarnya, untuk dipergunakan sebagaimana mestinya, ');
		$this->fpdf->Ln(14);
		
		$this->fpdf->Cell(133, 5,'Bogor,', 0,0,'R');
		$this->fpdf->Cell(2, 5,$skptt_tglcetak, 0,0,'L');
		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Times','B',11);
		if($skptt_pdf['ttd_jenis'] =='1'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'LURAH', 0,0,'C');
			$this->fpdf->Ln();
		}else if($skptt_pdf['ttd_jenis'] =='2'){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'An. LURAH', 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln();
			$this->fpdf->Cell(110, 5,'', 0,0,'R');
			$this->fpdf->Cell(60, 5,$ttd_pdf['ttd_jab'], 0,0,'C');

		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'', 0,0,'C');
			$this->fpdf->Ln();
		}
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Ln(20);
		
		if($skptt_pdf['ttd_jenis'] !='' && $skptt_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',11);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(115, 5,'', 0,0,'J');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
			$this->fpdf->Ln(8);
		}
		$this->fpdf->Output("Surat_Keterangan_Penghasilan_Tidak_Tetap","I"); 
	}

	/***********  SURAT KETERANGAN UNTUK NIKAH (NA) **************/
	
	function skun_na_pdf($nik)
	{
		$data['header_pdf']	= $this->crud_model->get_header();
		$data['skun_na_pdf'] = $this->crud_model->get_a_skun_na($nik);
		
		$data['agama1_pdf']		= $this->crud_model->get_a_agama1_skun_na($nik);
		$data['agama2_pdf']		= $this->crud_model->get_a_agama2_skun_na($nik);
		$data['agama3_pdf']		= $this->crud_model->get_a_agama3_skun_na($nik);
		
		$data['pekerjaan1_pdf']	= $this->crud_model->get_a_pekerjaan1_skun_na($nik);
		$data['pekerjaan2_pdf']	= $this->crud_model->get_a_pekerjaan2_skun_na($nik);
		$data['pekerjaan3_pdf']	= $this->crud_model->get_a_pekerjaan3_skun_na($nik);
		
		$data['jk1_pdf']	= $this->crud_model->get_a_jeniskelamin1_skun_na($nik);
		$data['jk2_pdf']	= $this->crud_model->get_a_jeniskelamin2_skun_na($nik);
		$data['jk3_pdf']	= $this->crud_model->get_a_jeniskelamin3_skun_na($nik);
		
		$data['sta_nikah_pdf']	= $this->crud_model->get_status_skun_na($nik);

		$skun_na_tglcetak=$this->app_model->tgl_indo(date("Y-m-d"));

		$this->load->library('fpdf');
		
		$skun_na_pdf 	= $data['skun_na_pdf'];
		$header_pdf 	= $data['header_pdf'];
		
		$aga1_pdf 	= $data['agama1_pdf'];
		$aga2_pdf 	= $data['agama2_pdf'];
		$aga3_pdf 	= $data['agama3_pdf'];
		
		$pek1_pdf 	= $data['pekerjaan1_pdf'];
		$pek2_pdf 	= $data['pekerjaan2_pdf'];
		$pek3_pdf 	= $data['pekerjaan3_pdf'];
		
		$jk1_pdf 	= $data['jk1_pdf'];
		$jk2_pdf 	= $data['jk2_pdf'];
		$jk3_pdf 	= $data['jk3_pdf'];
		$stanikah = $data['sta_nikah_pdf'];
		
		$skun_na_ttl1=$skun_na_pdf['tmp_lahir1'].', '.$this->app_model->tgl_indo($skun_na_pdf['tgl_lahir1']);
		$skun_na_ttl2=$skun_na_pdf['tmp_lahir2'].', '.$this->app_model->tgl_indo($skun_na_pdf['tgl_lahir2']);
		$skun_na_ttl3=$skun_na_pdf['tmp_lahir3'].', '.$this->app_model->tgl_indo($skun_na_pdf['tgl_lahir3']);
		
		$jsk='skun_na';
		$data['ttd_pdf'] = $this->crud_model->get_ttdsurat($skun_na_pdf['nmr_surat'],$jsk);
		$ttd_pdf 	= $data['ttd_pdf'];
		
		$s_kelurahan = $header_pdf['s_kelurahan'];
		$s_kelurahan = ucwords(strtolower($s_kelurahan));
		
		$s_kecamatan = $header_pdf['s_kecamatan'];
		$s_kecamatan = ucwords(strtolower($s_kecamatan));
		
		$this->fpdf->FPDF('L','mm','A4');
		$this->fpdf->SetMargins(18,15,30);
		$this->fpdf->open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Cell(75, 5,$s_kelurahan, 0,0,'J');
		$this->fpdf->Cell(65, 5,'Lampiran 7 PMA Tahun 1991', 0,0,'J');
		$this->fpdf->Cell(75, 5,$s_kelurahan, 0,0,'J');
		$this->fpdf->Cell(140, 5,'Lampiran 7 PMA Tahun 1991', 0,0,'J');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(75, 5,$s_kecamatan, 0,0,'J');
		$this->fpdf->Cell(65, 5,'Pasal 3', 0,0,'J');
		$this->fpdf->Cell(75, 5,$s_kecamatan, 0,0,'J');
		$this->fpdf->Cell(140, 5,'Pasal 8 ayat(1) huruf b.', 0,0,'J');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(75, 5,'Kota Bogor', 0,0,'J');
		$this->fpdf->Cell(65, 5,'Model N1', 0,0,'J');		
		$this->fpdf->Cell(75, 5,'Kota Bogor', 0,0,'J');
		$this->fpdf->Cell(140, 5,'Model N2', 0,0,'J');
		$this->fpdf->Ln(12);
		$this->fpdf->SetFont('Times','BU',10);
		$this->fpdf->Cell(130, 5,'SURAT KETERANGAN UNTUK NIKAH', 0,0,'C');
		$this->fpdf->Cell(160, 5,'SURAT KETERANGAN ASAL USUL', 0,0,'C');
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(130, 5,'Nomor :   '.$header_pdf['no_spn'].' / '.$skun_na_pdf['nomor'] .' - ' , 0,0,'C');
		$this->fpdf->Cell(160, 5,'Nomor :   '.$header_pdf['no_spn'].' / '.$skun_na_pdf['nomor'] .' - ', 0,0,'C');
		$this->fpdf->Ln(12);
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Cell(140, 5,'Yang bertanda tangan dibawah ini, menerangkan dengan sesungguhnya', 0,0,'L');
		$this->fpdf->Cell(130, 5,'I.  Yang bertanda tangan dibawah ini, menerangkan dengan sesungguhnya bahwa :', 0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(60, 5,'1.   Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$skun_na_pdf['skun_na_nama1'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     1. Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['skun_na_nama1'], 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'2.   Jenis Kelamin', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$jk1_pdf['jk_nama'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     2. Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_ttl1, 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'3.   Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$skun_na_ttl1, 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     3. Warga Negara', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['kew_id1'], 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'4.   Warga Negara', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$skun_na_pdf['kew_id1'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     4. Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga1_pdf['aga_nama'], 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'5.   Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$aga1_pdf['aga_nama'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     5. Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$pek1_pdf['pek_nama'], 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'6.   Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$pek1_pdf['pek_nama'], 0,0,'L');
		
		$this->fpdf->Cell(130, 5,'II. Adalah benar anak kandung dari pernikahan seorang pria :', 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'7.   Tempat Tinggal', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$skun_na_pdf['alamat1'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     1. Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['skun_na_nama2'], 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'8.   Bin / Binti', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$skun_na_pdf['bin_binti'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     2. Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_ttl2, 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'9.   Status Perkawinan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$stanikah['sta_nama'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     3. Warga Negara', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['kew_id2'], 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(140, 5,'      a.   Jika pria terangkan jejaka Duda', 0,0,'L');
		$this->fpdf->Cell(44, 5,'     4. Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga2_pdf['aga_nama'], 0,0,'L');
		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'           atau beristri dan berapa istrinya', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		
		if($skun_na_pdf['jk1']=='1' && $skun_na_pdf['status1']=='1'){
			$this->fpdf->Cell(75, 5,'Jejaka', 0,0,'L');
		}else if($skun_na_pdf['jk1']=='1'){
			$this->fpdf->Cell(75, 5,'Duda', 0,0,'L');
		}else{
		$this->fpdf->Cell(75, 5,'-', 0,0,'L');
		}
		
		$this->fpdf->Cell(44, 5,'     5. Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$pek2_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'      b.   Jika wanita terangkan', 0,0,'L');
		$this->fpdf->Cell(5, 5,'', 0,0,'L');
		$this->fpdf->Cell(75, 5,'', 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     6. Tempat Tinggal', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['alamat2'], 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'           perawan atau janda', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		if($skun_na_pdf['jk1']=='2' && $skun_na_pdf['status1']=='1'){
		$this->fpdf->Cell(75, 5,'Perawan', 0,0,'L');
		}else if($skun_na_pdf['jk1']=='2'){
			$this->fpdf->Cell(75, 5,'Janda', 0,0,'L');
		}else{
		$this->fpdf->Cell(75, 5,'-', 0,0,'L');
		}
		
		$this->fpdf->Cell(44, 5,'', 0,0,'L');
		$this->fpdf->Cell(5, 5,'', 0,0,'L');
		$this->fpdf->Cell(60, 5,'', 0,0,'L');		
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(60, 5,'10.   Nama Istri/Suami terdahulu', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$skun_na_pdf['status2'], 0,0,'L');
		
		$this->fpdf->Cell(44, 5,'     Dengan seorang wanita :', 0,0,'L');
		$this->fpdf->Cell(5, 5,'', 0,0,'L');
		$this->fpdf->Cell(60, 5,'', 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(140, 5,'', 0,0,'L');
		$this->fpdf->Cell(44, 5,'     1. Nama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['skun_na_nama3'], 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(140, 5,'Demikian Surat Keterangan ini dibuat dengan mengingat sumpah jabatan dan dapat');
		$this->fpdf->Cell(44, 5,'     2. Tempat & Tanggal Lahir', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_ttl3, 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(140, 5,'dipergunakan seperlunya.');
		$this->fpdf->Cell(44, 5,'     3. Warga Negara', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['kew_id3'], 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(140, 5,'');
		$this->fpdf->Cell(44, 5,'     4. Agama', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$aga3_pdf['aga_nama'], 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(140, 5,'Bogor, '.$skun_na_tglcetak.'                          ', 0,0,'R');
		$this->fpdf->Cell(44, 5,'     5. Pekerjaan', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(75, 5,$pek3_pdf['pek_nama'], 0,0,'L');
		$this->fpdf->Ln(4);
		
		$this->fpdf->Cell(140, 5,'');
		$this->fpdf->Cell(44, 5,'     6. Tempat Tinggal', 0,0,'L');
		$this->fpdf->Cell(5, 5,':', 0,0,'L');
		$this->fpdf->Cell(60, 5,$skun_na_pdf['alamat2'], 0,0,'L');
		$this->fpdf->Ln(8);
		
		$this->fpdf->Cell(140, 5,'', 0,0,'L');
		$this->fpdf->Cell(44, 5,'Demikian surat keterangan ini dibuat dengan mengingat sumpah jabatan dan dapat ', 0,0,'L');
		$this->fpdf->Cell(5, 5,'', 0,0,'L');
		$this->fpdf->Cell(60, 5,'', 0,0,'L');
		$this->fpdf->Ln(4);
				
		$this->fpdf->Cell(140, 5,'', 0,0,'R');
		$this->fpdf->Cell(44, 5,'dipergunakan seperlunya.', 0,0,'L');
		$this->fpdf->Cell(5, 5,'', 0,0,'L');
		$this->fpdf->Cell(60, 5,'', 0,0,'L');
		$this->fpdf->Ln(1);
		
		//$this->fpdf->Cell(140, 5,'_________________                         ', 0,0,'R');
		if($skun_na_pdf['ttd_jenis'] !='' && $skun_na_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(70, 5,'', 0,0,'J');
			$this->fpdf->SetFont('Times','B',10);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',10);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(70, 5,'', 0,0,'J');
			$this->fpdf->Cell(60, 5,'___________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(70, 5,'', 0,0,'J');
			$this->fpdf->Cell(60, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
		}else{
			$this->fpdf->Cell(72, 5,'', 0,0,'J');
			$this->fpdf->Cell(60, 5,'__________________', 0,0,'C');
		}
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(270, 5,'Bogor, '.$skun_na_tglcetak.'                          ', 0,0,'R');
		$this->fpdf->Ln(13);
		
		
		if($skun_na_pdf['ttd_jenis'] !='' && $skun_na_pdf['ttd_kode'] !=''){
			$this->fpdf->Cell(205, 5,'', 0,0,'C');
			$this->fpdf->SetFont('Times','B',10);
			$this->fpdf->Cell(50, 5,$ttd_pdf['ttd_nama'], 0,0,'C');
			$this->fpdf->SetFont('Times','',10);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(205, 5,'', 0,0,'C');
			$this->fpdf->Cell(50, 5,'________________________', 0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(205, 5,'', 0,0,'C');
			$this->fpdf->Cell(50, 5,'NIP. '.$ttd_pdf['ttd_nip'], 0,0,'C');
			$this->fpdf->Ln(8);
		}else{
			$this->fpdf->Cell(208, 5,'', 0,0,'C');
			$this->fpdf->Cell(50, 5,'__________________', 0,0,'C');
		}
		$this->fpdf->Output("Surat_Keterangan_Untuk_Nikah_NA","I"); 
	}
}
