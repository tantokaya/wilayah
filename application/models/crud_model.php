<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function admin_login($admin_nama , $password)
	{
		$query = $this->db->get_where('admin', array('admin_nama'	=> $this->input->post('admin_nama'),
													'password'	=> $this->input->post('password')));
		if($query->num_rows()>0)
        {
            $row   = $query->row();
            $this->session->set_userdata('admin_login','1');
            $this->session->set_userdata('login_type','admin');
            $this->session->set_userdata('admin_id',$row->admin_id);
            $this->session->set_userdata('level',$row->level);
			return TRUE;
        }
		else return FALSE;
	}
	
	function get_settings()
	{
		$query	=	$this->db->get('settings' );
		return $query->result_array();
	}
	
	
	/////////PENGGUNA/////////////
	function get_pengguna()
	{
		$query	=	$this->db->get('admin' );
		return $query->result_array();
	}
	function get_pengguna_name($admin_id)
	{
		$query	=	$this->db->get_where('admin' , array('admin_id' => $admin_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['name'];
	}
	function get_pengguna_info($admin_id)
	{
		$query	=	$this->db->get_where('admin' , array('admin_id' => $admin_id));
		return $query->result_array();
	}
	
/////////PROPINSI/////////////
	function get_propinsi()
	{
		$query	=	$this->db->get('propinsi' );
		return $query->result_array();
	}
	
	public function tambah_propinsi($data)
	{
		$this->db->insert('propinsi', $data);
	}
	
	
	function get_propinsi_name($prop_id)
	{
		$query	=	$this->db->get_where('propinsi' , array('prop_id' => $prop_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['prop_nama'];
	}
	function get_propinsi_info($prop_id)
	{
		$query	=	$this->db->get_where('propinsi' , array('prop_id' => $prop_id));
		return $query->result_array();
	}
	
/////////KABUPATEN/////////////
	function get_kabupaten()
	{
		$query	=	$this->db->get('kabupaten' );
		return $query->result_array();
	}
	
	public function tambah_kabupaten($data)
	{
		$this->db->insert('kabupaten', $data);
	}
	
	
	function get_kabupaten_name($kab_id)
	{
		$query	=	$this->db->get_where('kabupaten' , array('kab_id' => $kab_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['kab_nama'];
	}
	function get_kabupaten_info($kab_id)
	{
		$query	=	$this->db->get_where('kabupaten' , array('kab_id' => $kab_id));
		return $query->result_array();
	}
	
	
	function get_kabupaten_by_propinsi($prop_id)
	{
	$this->db->where('prop_id',$prop_id);
	$result = $this->db->get('kabupaten');
	if($result->num_rows() > 0 ){
		return $result->result_array();
	}
		else{
			return array();
		}
	}
	
/////////KECAMATAN/////////////
	function get_kecamatan()
	{
		$query	=	$this->db->get('kecamatan' );
		return $query->result_array();
	}
	
	public function tambah_kecamatan($data)
	{
		$this->db->insert('kecamatan', $data);
	}
	
	
	function get_kecamatan_name($kec_id)
	{
		$query	=	$this->db->get_where('kecamatan' , array('kec_id' => $kec_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['kec_nama'];
	}
	function get_kecamatan_info($kec_id)
	{
		$query	=	$this->db->get_where('kecamatan' , array('kec_id' => $kec_id));
		return $query->result_array();
	}
	
/////////KELURAHAN/////////////
	function get_kelurahan()
	{
		$query	=	$this->db->get('kelurahan' );
		return $query->result_array();
	}
	
	public function tambah_kelurahan($data)
	{
		$this->db->insert('kelurahan', $data);
	}
	
	
	function get_kelurahan_name($kel_id)
	{
		$query	=	$this->db->get_where('kelurahan' , array('kel_id' => $kel_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['kel_nama'];
	}
	function get_kelurahan_info($kel_id)
	{
		$query	=	$this->db->get_where('kelurahan' , array('kel_id' => $kel_id));
		return $query->result_array();
	}
	
	
/////////AGAMA/////////////
	function get_agama()
	{
		$query	=	$this->db->get('agama' );
		return $query->result_array();
	}
	
	public function get_a_agama_link($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skdu r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_agama_sk_tmp_tinggal($nik)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, sktt r 
		WHERE r.aga_id = p.aga_kode AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_agama_sk_tdk_mampu($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, sktmp r 
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_agama_sk_pck($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skpck r 
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_agama_sk_blm_menikah($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skbm r 
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_agama_sk_pergi($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skb r 
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama_skk($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id1 as aga_id
		FROM agama p, skk r
		WHERE r.aga_id1 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama1_skl($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id1 as aga_id
		FROM agama p, skl r
		WHERE r.aga_id1 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama2_skl($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id2 as aga_id
		FROM agama p, skl r
		WHERE r.aga_id2 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama_skbn($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skbn r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama_sktkt($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, sktkt r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
/////////START AGAMA SKTOT/////////////
	
	public function get_a_agama1_sktot($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id1 as aga_id
		FROM agama p, sktot r
		WHERE r.aga_id1 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama2_sktot($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id2 as aga_id
		FROM agama p, sktot r
		WHERE r.aga_id2 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama3_sktot($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id3 as aga_id
		FROM agama p, sktot r
		WHERE r.aga_id3 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

/////////END AGAMA SKTOT/////////////	

/////////START AGAMA SKAU/////////////
	
	public function get_a_agama1_skau($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id1 as aga_id
		FROM agama p, skau r
		WHERE r.aga_id1 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama2_skau($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id2 as aga_id
		FROM agama p, skau r
		WHERE r.aga_id2 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama3_skau($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id3 as aga_id
		FROM agama p, skau r
		WHERE r.aga_id3 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

/////////END AGAMA SKAU/////////////	
/////////START AGAMA SKUN-NA/////////////
	
	public function get_a_agama1_skun_na($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id1 as aga_id
		FROM agama p, skun_na r
		WHERE r.aga_id1 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama2_skun_na($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id2 as aga_id
		FROM agama p, skun_na r
		WHERE r.aga_id2 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama3_skun_na($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id3 as aga_id
		FROM agama p, skun_na r
		WHERE r.aga_id3 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

/////////END AGAMA SKUN-NA/////////////	
	
	public function get_a_agama_skun($nik)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skun r 
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
/////////START AGAMA SKPM/////////////
	
	public function get_a_agama1_skpm($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id1 as aga_id
		FROM agama p, skpm r
		WHERE r.aga_id1 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama2_skpm($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id2 as aga_id
		FROM agama p, skpm r
		WHERE r.aga_id2 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

/////////END AGAMA SKPM/////////////

/////////START AGAMA SIOTM/////////////
	
	public function get_a_agama1_siotm($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id1 as aga_id
		FROM agama p, siotm r
		WHERE r.aga_id1 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama2_siotm($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id2 as aga_id
		FROM agama p, siotm r
		WHERE r.aga_id2 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama3_siotm($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id3 as aga_id
		FROM agama p, siotm r
		WHERE r.aga_id3 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama4_siotm($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id4 as aga_id
		FROM agama p, siotm r
		WHERE r.aga_id4 = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
/////////END AGAMA SIOTM/////////////
	public function get_a_agama_skdk($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skdk r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_agama_skpnh($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skpnh r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_agama_skaw($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skaw r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama_skppsp($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skppsp r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama_skrt($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skrt r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	public function get_a_agama_skbmr($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skbmr r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	
	public function get_a_agama_skjd($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skjd r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_agama_skptt($nmr_surat)
	{
		$sql = "SELECT p.aga_nama as aga_nama, r.aga_id as aga_id
		FROM agama p, skptt r
		WHERE r.aga_id = p.aga_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function tambah_agama($data)
	{
		$this->db->insert('agama', $data);
	}
	
	
	function get_tambah_agama_name($aga_id)
	{
		$query	=	$this->db->get_where('agama' , array('aga_id' => $aga_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['aga_nama'];
	}
	function get_agama_info($aga_id)
	{
		$query	=	$this->db->get_where('agama' , array('aga_id' => $aga_id));
		return $query->result_array();
	}
	

/////////BIODATA/////////////
	function get_biodata()
	{
		$query	=	$this->db->get('biodata' );
		return $query->result_array();
	}
	
	public function tambah_biodata($data)
	{
		$this->db->insert('biodata', $data);
	}
	
	
	function get_tambah_biodata_name($nik)
	{
		$query	=	$this->db->get_where('biodata' , array('nik' => $nik));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['bio_nama'];
	}
	function get_biodata_info($nik)
	{
		$query	=	$this->db->get_where('biodata' , array('nik' => $nik));
		return $query->result_array();
	}
	
////////Query manual//////////////
	function manualQuery($q)
	{
		return $this->db->query($q);
	}
	
	
/////////PENDIDIKAN/////////////
	function get_pendidikan()
	{
		$query	=	$this->db->get('pendidikan' );
		return $query->result_array();
	}
	
	public function tambah_pendidikan($data)
	{
		$this->db->insert('pendidikan', $data);
	}
	
	
	function get_tambah_pendidikan_name($pen_id)
	{
		$query	=	$this->db->get_where('pendidikan' , array('pen_id' => $pen_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['pen_nama'];
	}
	function get_pendidikan_info($pen_id)
	{
		$query	=	$this->db->get_where('pendidikan' , array('pen_id' => $pen_id));
		return $query->result_array();
	}
	
/////////KEWARGANEGARAAN/////////////
	function get_kewarganegaraan()
	{
		$query	=	$this->db->get('kewarganegaraan' );
		return $query->result_array();
	}
	
	public function get_a_kewarganegaraan_link($nik)
	{
		$sql = "SELECT p.kew_nama as kew_nama, r.kew_id as kew_id
		FROM kewarganegaraan p, skdu r 
		WHERE r.kew_id = p.kew_kode AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_kewarganegaraan_sku($nik)
	{
		$sql = "SELECT p.kew_nama as kew_nama, r.kew_id as kew_id
		FROM kewarganegaraan p, sku r 
		WHERE r.kew_id = p.kew_kode AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_kewarganegaraan_sk_tmp_tinggal($nik)
	{
		$sql = "SELECT p.kew_nama as kew_nama, r.kew_id as kew_id
		FROM kewarganegaraan p, sktt r 
		WHERE r.kew_id = p.kew_id AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_kewarganegaraan_sk_tdk_mampu($nik)
	{
		$sql = "SELECT p.kew_nama as kew_nama, r.kew_id as kew_id
		FROM kewarganegaraan p, sktmp r 
		WHERE r.kew_id = p.kew_kode AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_kewarganegaraan_sk_pck($nik)
	{
		$sql = "SELECT p.kew_nama as kew_nama, r.kew_id as kew_id
		FROM kewarganegaraan p, sk_pck r 
		WHERE r.kew_id = p.kew_id AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	
	
	public function get_a_kewarganegaraan_sk_blm_menikah($nik)
	{
		$sql = "SELECT p.kew_nama as kew_nama, r.kew_id as kew_id
		FROM kewarganegaraan p, sk_blm_menikah r 
		WHERE r.kew_id = p.kew_id AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_kewarganegaraan_sk_pergi($nik)
	{
		$sql = "SELECT p.kew_nama as kew_nama, r.kew_id as kew_id
		FROM kewarganegaraan p, sk_pergi r 
		WHERE r.kew_id = p.kew_id AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	
	
	public function tambah_kewarganegaraan($data)
	{
		$this->db->insert('kewarganegaraan', $data);
	}
	
	
	function get_tambah_kewarganegaraan_name($kew_id)
	{
		$query	=	$this->db->get_where('kewarganegaraan' , array('kew_id' => $kew_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['kew_nama'];
	}
	function get_kewarganegaraan_info($kew_id)
	{
		$query	=	$this->db->get_where('kewarganegaraan' , array('kew_id' => $kew_id));
		return $query->result_array();
	}

	public function get_a_kewarganegaraan($nik)
	{
		$sql = "SELECT * FROM kewarganegaraan WHERE nik =  '$nik'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}


/////////PEKERJAAN/////////////
	function get_pekerjaan()
	{
		$query	=	$this->db->get('pekerjaan' );
		return $query->result_array();
	}
	
	public function tambah_pekerjaan($data)
	{
		$this->db->insert('pekerjaan', $data);
	}

	public function get_a_pekerjaan_link($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skdu r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_sku($nik)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, sku r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	
	public function get_a_pekerjaan_sk_tmp_tinggal($nik)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, sktt r 
		WHERE r.pek_id = p.pek_id AND r.nik = '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_sk_tdk_mampu($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, sktmp r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_sk_pck($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skpck r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_sk_blm_menikah($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skbm r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_sk_ijin_ramai($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skir r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_sk_pergi($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skb r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_skk($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id2 as pek_id
		FROM pekerjaan p, skk r 
		WHERE r.pek_id2 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
		
	/////////START PEKERJAAN SKTOT/////////////
	public function get_a_pekerjaan1_sktot($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id1 as pek_id
		FROM pekerjaan p, sktot r 
		WHERE r.pek_id1 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan2_sktot($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id2 as pek_id
		FROM pekerjaan p, sktot r 
		WHERE r.pek_id2 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan3_sktot($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id3 as pek_id
		FROM pekerjaan p, sktot r 
		WHERE r.pek_id3 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	/////////END PEKERJAAN SKTOT/////////////
	/////////START PEKERJAAN SKAU/////////////
	public function get_a_pekerjaan1_skau($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id1 as pek_id
		FROM pekerjaan p, skau r 
		WHERE r.pek_id1 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan2_skau($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id2 as pek_id
		FROM pekerjaan p, skau r 
		WHERE r.pek_id2 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan3_skau($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id3 as pek_id
		FROM pekerjaan p, skau r 
		WHERE r.pek_id3 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	/////////END PEKERJAAN SKAU/////////////
	/////////START PEKERJAAN SKUN-NA/////////////
	public function get_a_pekerjaan1_skun_na($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id1 as pek_id
		FROM pekerjaan p, skun_na r 
		WHERE r.pek_id1 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan2_skun_na($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id2 as pek_id
		FROM pekerjaan p, skun_na r 
		WHERE r.pek_id2 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan3_skun_na($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id3 as pek_id
		FROM pekerjaan p, skun_na r 
		WHERE r.pek_id3 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	/////////END PEKERJAAN SKUN/////////////

	public function get_a_pekerjaan_skun($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skun r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	/////////START PEKERJAAN SKPM/////////////
	public function get_a_pekerjaan1_skpm($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id1 as pek_id
		FROM pekerjaan p, skpm r 
		WHERE r.pek_id1 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan2_skpm($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id2 as pek_id
		FROM pekerjaan p, skpm r 
		WHERE r.pek_id2 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	/////////END PEKERJAAN SKPM/////////////
	
	/////////START PEKERJAAN SIOTM/////////////
	public function get_a_pekerjaan1_siotm($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id1 as pek_id
		FROM pekerjaan p, siotm r 
		WHERE r.pek_id1 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan2_siotm($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id2 as pek_id
		FROM pekerjaan p, siotm r 
		WHERE r.pek_id2 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan3_siotm($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id3 as pek_id
		FROM pekerjaan p, siotm r 
		WHERE r.pek_id3 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan4_siotm($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id4 as pek_id
		FROM pekerjaan p, siotm r 
		WHERE r.pek_id4 = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	/////////END PEKERJAAN SIOTM/////////////	
	public function get_a_pekerjaan_skdk($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skdk r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	
	public function get_a_pekerjaan_skpnh($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skpnh r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan_skaw($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skaw r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan_skppsp($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skppsp r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	
	public function get_a_pekerjaan_skrt($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skrt r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function get_a_pekerjaan_skbmr($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skbmr r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan_skjd($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skjd r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_pekerjaan_skptt($nmr_surat)
	{
		$sql = "SELECT p.pek_nama as pek_nama, r.pek_id as pek_id
		FROM pekerjaan p, skptt r 
		WHERE r.pek_id = p.pek_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	
	function get_tambah_pekerjaan_name($pek_id)
	{
		$query	=	$this->db->get_where('pekerjaan' , array('pek_id' => $pek_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['pek_nama'];
	}
	function get_pekerjaan_info($pek_id)
	{
		$query	=	$this->db->get_where('pekerjaan' , array('pek_id' => $pek_id));
		return $query->result_array();
	}
//////////////////////// FUNCTION KELAHIRAN /////////////////////
	public function get_a_pkelahiran_skl($nmr_surat)
	{
		$sql = "SELECT p.pk_nama as pk_nama, r.pk_id as pk_kode
		FROM pk p, skl r 
		WHERE r.pk_id = p.pk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_tkelahiran_skl($nmr_surat)
	{
		$sql = "SELECT p.tk_nama as tk_nama, r.tk_id as tk_kode
		FROM tk p, skl r 
		WHERE r.tk_id = p.tk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_lahir_skl($nmr_surat)
	{
		$sql = "SELECT p.lahir_nama as lahir_nama, r.lahir_id as lahir_kode
		FROM lahir p, skl r 
		WHERE r.lahir_id = p.lahir_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
/////////////////////// JENIS KELAMIN////////////////////////////

	public function get_a_jeniskelamin_skk($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk1 as jk_kode
		FROM jk p, skk r 
		WHERE r.jk1 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skbn($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skbn r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skl($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk3 as jk_kode
		FROM jk p, skl r 
		WHERE r.jk3 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_sktt($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, sktt r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_sktmp($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, sktmp r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skdu($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skdu r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_sku($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, sku r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_sktkt($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, sktkt r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	//////////////START JENIS KELAMIN SKTOT//////////////////
	public function get_a_jeniskelamin1_sktot($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk1 as jk_kode
		FROM jk p, sktot r 
		WHERE r.jk1 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin2_sktot($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk2 as jk_kode
		FROM jk p, sktot r 
		WHERE r.jk2 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin3_sktot($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk3 as jk_kode
		FROM jk p, sktot r 
		WHERE r.jk3 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	//////////////END JENIS KELAMIN SKTOT//////////////////
	

	//////////////START JENIS KELAMIN SKAU//////////////////
	public function get_a_jeniskelamin1_skau($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk1 as jk_kode
		FROM jk p, skau r 
		WHERE r.jk1 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin2_skau($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk2 as jk_kode
		FROM jk p, skau r 
		WHERE r.jk2 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin3_skau($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk3 as jk_kode
		FROM jk p, skau r 
		WHERE r.jk3 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	//////////////END JENIS KELAMIN SKAU//////////////////
	
	public function get_status_skun_na($nmr_surat)
	{
		$sql = "SELECT p.sta_nama as sta_nama, r.status1 as sta_kode
		FROM sta_nikah p, skun_na r 
		WHERE r.status1 = p.sta_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	public function get_status_sktmp($nmr_surat)
	{
		$sql = "SELECT p.sta_nama as sta_nama, r.status as sta_kode
		FROM sta_nikah p, sktmp r 
		WHERE r.status = p.sta_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}


	//////////////START JENIS KELAMIN SKUN-NA//////////////////
	public function get_a_jeniskelamin1_skun_na($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk1 as jk_kode
		FROM jk p, skun_na r 
		WHERE r.jk1 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin2_skun_na($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk2 as jk_kode
		FROM jk p, skun_na r 
		WHERE r.jk2 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin3_skun_na($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk3 as jk_kode
		FROM jk p, skun_na r 
		WHERE r.jk3 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	//////////////END JENIS KELAMIN SKUN-NA//////////////////
	

	public function get_a_jeniskelamin_skun($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skun r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	//////////////START JENIS KELAMIN SKPM//////////////////
	public function get_a_jeniskelamin1_skpm($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk1 as jk_kode
		FROM jk p, skpm r 
		WHERE r.jk1 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin2_skpm($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk2 as jk_kode
		FROM jk p, skpm r 
		WHERE r.jk2 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	//////////////END JENIS KELAMIN SKPM//////////////////
	
	//////////////START JENIS KELAMIN SIOTM//////////////////
	public function get_a_jeniskelamin1_siotm($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk1 as jk_kode
		FROM jk p, siotm r 
		WHERE r.jk1 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin2_siotm($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk2 as jk_kode
		FROM jk p, siotm r 
		WHERE r.jk2 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin3_siotm($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk3 as jk_kode
		FROM jk p, siotm r 
		WHERE r.jk3 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin4_siotm($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk4 as jk_kode
		FROM jk p, siotm r 
		WHERE r.jk4 = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	//////////////END JENIS KELAMIN SIOTM//////////////////
	public function get_a_jeniskelamin_skdk($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skdk r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skpnh($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skpnh r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	public function get_a_jeniskelamin_skaw($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skaw r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skppsp($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skppsp r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skrt($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skrt r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skbmr($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skbmr r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skb($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skb r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skpck($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skpck r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skbm($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skbm r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function get_a_jeniskelamin_skjd($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skjd r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	
	
	public function get_a_jeniskelamin_skptt($nmr_surat)
	{
		$sql = "SELECT p.jk_nama as jk_nama, r.jk as jk_kode
		FROM jk p, skptt r 
		WHERE r.jk = p.jk_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

///////////////// HEADER SURAT ////////////////////	

	function get_header() {
		$sql = "SELECT * FROM seting ";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	

///////// A. SURAT KETERANGAN DOMISILI USAHA (SKDU) /////////////

	function get_skdu()
	{
		$query	=	$this->db->get('skdu' );
		return $query->result_array();
	}
   public function get_a_skdu($nmr_surat)
	{
		$sql = "SELECT * FROM skdu WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function tambah_skdu($data)
	{
		$this->db->insert('skdu', $data);
	}


	function get_tambah_skdu_name($srt_id)
	{
		$query	=	$this->db->get_where('skdu' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['skdu_nama'];
	}
	function get_skdu_info($srt_id)
	{
		$query	=	$this->db->get_where('skdu' , array('srt_id' => $srt_id));
		return $query->result_array();
	}	
	
///////// B. SURAT KETERANGAN USAHA (SKU) /////////////

 function get_sku()
	{
		$query	=	$this->db->get('sku' );
		return $query->result_array();
	}
   public function get_a_sku($nmr_surat)
	{
		$sql = "SELECT * FROM sku WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function tambah_sku($data)
	{
		$this->db->insert('sku', $data);
	}


	function get_tambah_sku_name($srt_id)
	{
		$query	=	$this->db->get_where('sku' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['sku_nama'];
	}
	function get_sku_info($srt_id)
	{
		$query	=	$this->db->get_where('sku' , array('srt_id' => $srt_id));
		return $query->result_array();
	}	

///////// C. SURAT KETERANGAN TEMPAT TINGGAL (sk_tmp_tinggal) /////////////

 function get_sk_tmp_tinggal()
	{
		$query	=	$this->db->get('sktt' );
		return $query->result_array();
	}
   
	public function get_a_sk_tmp_tinggal($nmr_surat)
	{
		$sql = "SELECT * FROM sktt WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	public function tambah_sk_tmp_tinggal($data)
	{
		$this->db->insert('sktt', $data);
	}


	function get_tambah_sk_tmp_tinggal_name($srt_id)
	{
		$query	=	$this->db->get_where('sktt' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['sktt_nama'];
	}
	function get_sk_tmp_tinggal_info($srt_id)
	{
		$query	=	$this->db->get_where('sktt' , array('srt_id' => $srt_id));
		return $query->result_array();
	}	

///////// D. SURAT KETERANGAN TIDAK MAMPU (SK_TDK_MAMPU) /////////////

 function get_sk_tdk_mampu()
	{
		$query	=	$this->db->get('sktmp' );
		return $query->result_array();
	}
   public function get_a_sktmp($nmr_surat)
	{
		$sql = "SELECT * FROM sktmp WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function tambah_sk_tdk_mampu($data)
	{
		$this->db->insert('sktmp', $data);
	}


	function get_tambah_sk_tdk_mampu_name($srt_id)
	{
		$query	=	$this->db->get_where('sktmp' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['sktmp_nama'];
	}
	function get_sk_tdk_mampu_info($srt_id)
	{
		$query	=	$this->db->get_where('sktmp' , array('srt_id' => $srt_id));
		return $query->result_array();
	}
	
///////// E. SURAT KETERANGAN PENGANTAR CATATAN KEPOLISIAN) /////////////

 function get_sk_pck()
	{
		$query	=	$this->db->get('skpck' );
		return $query->result_array();
	}
   public function get_a_sk_pck($nmr_surat)
	{
		$sql = "SELECT * FROM skpck WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function tambah_sk_pck($data)
	{
		$this->db->insert('skpck', $data);
	}


	function get_tambah_sk_pck_name($srt_id)
	{
		$query	=	$this->db->get_where('skpck' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['sk_pck_nama'];
	}
	function get_sk_pck_info($srt_id)
	{
		$query	=	$this->db->get_where('skpck' , array('srt_id' => $srt_id));
		return $query->result_array();
	}		
	
///////// F. SURAT KETERANGAN BELUM PERNAH MENIKAH /////////////

 function get_sk_blm_menikah()
	{
		$query	=	$this->db->get('skbm' );
		return $query->result_array();
	}
   public function get_a_sk_blm_menikah($nmr_surat)
	{
		$sql = "SELECT * FROM skbm WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function tambah_sk_blm_menikah($data)
	{
		$this->db->insert('skbm', $data);
	}


	function get_tambah_sk_blm_menikah_name($srt_id)
	{
		$query	=	$this->db->get_where('skbm' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['skbm_nama'];
	}
	function get_sk_blm_menikah_info($srt_id)
	{
		$query	=	$this->db->get_where('skbm' , array('srt_id' => $srt_id));
		return $query->result_array();
	}		


///////// G. SURAT KETERANGAN IZIN KERAMAIAN /////////////

 function get_sk_ijin_ramai()
	{
		$query	=	$this->db->get('skir' );
		return $query->result_array();
	}
   public function get_a_sk_ijin_ramai($nmr_surat)
	{
		$sql = "SELECT * FROM skir WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function tambah_sk_ijin_ramai($data)
	{
		$this->db->insert('skir', $data);
	}


	function get_tambah_sk_ijin_ramai_name($srt_id)
	{
		$query	=	$this->db->get_where('skir' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['skir_nama'];
	}
	function get_sk_ijin_ramai_info($srt_id)
	{
		$query	=	$this->db->get_where('skir' , array('srt_id' => $srt_id));
		return $query->result_array();
	}
	
	

///////// H. SURAT KETERANGAN UNTUK BEPERGIAN /////////////

 function get_sk_pergi()
	{
		$query	=	$this->db->get('sk_pergi' );
		return $query->result_array();
	}
   public function get_a_sk_pergi($nmr_surat)
	{
		$sql = "SELECT * FROM skb WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	public function tambah_sk_pergi($data)
	{
		$this->db->insert('sk_pergi', $data);
	}


	function get_tambah_sk_pergi_name($srt_id)
	{
		$query	=	$this->db->get_where('sk_pergi' , array('srt_id' => $srt_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['sk_pergi_nama'];
	}
	function get_sk_pergi_info($srt_id)
	{
		$query	=	$this->db->get_where('sk_pergi' , array('srt_id' => $srt_id));
		return $query->result_array();
	}	
///////// I. SURAT KETERANGAN KEMATIAN (SKK) /////////////

   public function get_a_skk($nmr_surat)
	{
		$sql = "SELECT * FROM skk WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
///////// I. SURAT KETERANGAN KELAHIRAN (SKL) /////////////

   public function get_a_skl($nmr_surat)
	{
		$sql = "SELECT * FROM skl WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	
///////// L. SURAT KETERANGAN BEDA NAMA (SKBN) /////////////

   public function get_a_skbn($nmr_surat)
	{
		$sql = "SELECT * FROM skbn WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

///////// M. SURAT KETERANGAN TIDAK KEBERATAN TETANGGA (SKTKT) /////////////

   public function get_a_sktkt($nmr_surat)
	{
		$sql = "SELECT * FROM sktkt WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
///////// N. SURAT KETERANGAN TENTANG ORANG TUA (SKTOT) /////////////

   public function get_a_sktot($nmr_surat)
	{
		$sql = "SELECT * FROM sktot WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
			
///////// O. SURAT KETERANGAN ASAL USUL (SKAW) /////////////

   public function get_a_skau($nmr_surat)
	{
		$sql = "SELECT * FROM skau WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
			

///////// P. SURAT KETERANGAN UNTUK MENIKAH (SKUN) /////////////

   public function get_a_skun($nmr_surat)
	{
		$sql = "SELECT * FROM skun WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

///////// *SURAT KETERANGAN UNTUK MENIKAH (SKNA) /////////////

   public function get_a_skun_na($nmr_surat)
	{
		$sql = "SELECT * FROM skun_na WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
		
///////// Q. SURAT KETERANGAN PERSETUJUAN MEMPELAI (SKPM) /////////////

   public function get_a_skpm($nmr_surat)
	{
		$sql = "SELECT * FROM skpm WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
		
///////// R. SURAT KETERANGAN IZIN ORANG TUA UNTUK MENIKAH (SIOTM) /////////////

   public function get_a_siotm($nmr_surat)
	{
		$sql = "SELECT * FROM siotm WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	

///////// S. SURAT KETERANGAN DAFTAR KELUARGA (SKDK) /////////////

   public function get_a_skdk($nmr_surat)
	{
		$sql = "SELECT * FROM skdk WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
///////// T. SURAT KETERANGAN PENGANTAR NAIK HAJI (SKPNH) /////////////

   public function get_a_skpnh($nmr_surat)
	{
		$sql = "SELECT * FROM skpnh WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
///////// U. SURAT KETERANGAN AHLI WARIS (SKAW) /////////////

   public function get_a_skaw($nmr_surat)
	{
		$sql = "SELECT * FROM skaw WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
///////// V. SURAT KETERANGAN PENGANTAR PENERBITAN SPPT PBB (SKPPSP) /////////////

   public function get_a_skppsp($nmr_surat)
	{
		$sql = "SELECT * FROM skppsp WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
///////// W. SURAT KETERANGAN RIWAYAT TANAH (SKRT) /////////////

   public function get_a_skrt($nmr_surat)
	{
		$sql = "SELECT * FROM skrt WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	
	
///////// X. SURAT KETERANGAN BELUM MEMILIKI RUMAH (SKBMR) /////////////

   public function get_a_skbmr($nmr_surat)
	{
		$sql = "SELECT * FROM skbmr WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}	
	
///////// Y. SURAT KETERANGAN JANDA/DUDA (SKJD) /////////////

   public function get_a_skjd($nmr_surat)
	{
		$sql = "SELECT * FROM skjd WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}


///////// Z. SURAT KETERANGAN PENGHASILAN TIDAK TETAP (SKPTT) /////////////

   public function get_a_skptt($nmr_surat)
	{
		$sql = "SELECT * FROM skptt WHERE nmr_surat =  '$nmr_surat'";
		$hasil = $this->db->query($sql);

		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

/////////SURAT KETERANGAN RT RW/////////////
	function get_skrtrw()
	{
		$query	=	$this->db->get('skrtrw' );
		return $query->result_array();
	}
	
	public function get_a_skrtrw($nik)
	{		
		$sql = "SELECT * FROM skrtrw WHERE nik =  '$nik'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
				
	public function tambah_skrtrw($data)
	{
		$this->db->insert('skrtrw', $data);
	}
	
	
	function get_tambah_skrtrw_name($nik)
	{
		$query	=	$this->db->get_where('skrtrw' , array('nik' => $nik));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['skr_nama'];
	}
	function get_skrtrw_info($nik)
	{
		$query	=	$this->db->get_where('skrtrw' , array('nik' => $nik));
		return $query->result_array();
	}	
	
	////////BACKUP RESTORE/////////
	function create_backup($type)
	{
		$this->load->dbutil();
		
		
		$options = array(
                'format'      => 'txt',             // gzip, zip, txt
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		
		 
		if($type == 'all')
		{
			$tables = array('');
			$file_name	=	'system_backup';
		}
		
		$backup =& $this->dbutil->backup(array_merge($options , $tables)); 


		$this->load->helper('download');
		force_download($file_name.'.sql', $backup);
	}
	
	
	/////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
	function restore_backup()
	{
		move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
		$this->load->dbutil();
		
		
		$prefs = array(
            'filepath'						=> 'uploads/backup.sql',
			'delete_after_upload'			=> TRUE,
			'delimiter'						=> ';'
        );
		$restore =& $this->dbutil->restore($prefs); 
		unlink($prefs['filepath']);
	}
	
	/////////DELETE DATA FROM TABLES///////////////
	function truncate($type)
	{
		if($type == 'all')
		{
			$this->db->truncate('student');
			$this->db->truncate('mark');
			$this->db->truncate('teacher');
			$this->db->truncate('subject');
			$this->db->truncate('class');
			$this->db->truncate('exam');
			$this->db->truncate('grade');
		}
		else
		{	
			$this->db->truncate($type);
		}
	}
	
	
	////////IMAGE URL//////////
	function get_image_url($type = '' , $id = '')
	{
		if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg'))
			$image_url	=	base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
		else
			$image_url	=	base_url().'uploads/user.jpg';
			
		return $image_url;
	}
	
	////////////SETTING PENANDATANGANAN SURAT KETERANGAN///////////////////
	function get_ttdsurat($nmr_surat, $jsk)
	{
		$sql = "SELECT p.ttd_nama as ttd_nama, p.ttd_jab as ttd_jab, p.ttd_nip as ttd_nip, r.ttd_kode as ttd_kode
		FROM penandatangan p, $jsk r
		WHERE r.ttd_kode = p.ttd_kode AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}

	//#########- BIODATA ALAMAT [PROPINSI-KOTA-KECAMATAN-KELURAHAN] -#########//
	
	function selected_propinsi($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_propinsi as nm_propinsi, r.propinsi as propinsi
		FROM propinsi p, $jsk r
		WHERE r.propinsi = p.kd_propinsi AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_propinsi1($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_propinsi as nm_propinsi, r.propinsi1 as propinsi1
		FROM propinsi p, $jsk r
		WHERE r.propinsi1 = p.kd_propinsi AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_propinsi2($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_propinsi as nm_propinsi, r.propinsi2 as propinsi2
		FROM propinsi p, $jsk r
		WHERE r.propinsi2 = p.kd_propinsi AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_propinsi3($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_propinsi as nm_propinsi, r.propinsi3 as propinsi3
		FROM propinsi p, $jsk r
		WHERE r.propinsi3 = p.kd_propinsi AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_propinsi4($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_propinsi as nm_propinsi, r.propinsi4 as propinsi4
		FROM propinsi p, $jsk r
		WHERE r.propinsi4 = p.kd_propinsi AND r.nmr_surat = '$nmr_surat'";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function selected_kota($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kota as nm_kota, r.kota as kota
		FROM kota p, $jsk r
		WHERE r.kota = p.kd_kota AND r.nmr_surat = '$nmr_surat' AND r.propinsi = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kota1($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kota as nm_kota, r.kota1 as kota1
		FROM kota p, $jsk r
		WHERE r.kota1 = p.kd_kota AND r.nmr_surat = '$nmr_surat' AND r.propinsi1 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kota2($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kota as nm_kota, r.kota2 as kota2
		FROM kota p, $jsk r
		WHERE r.kota2 = p.kd_kota AND r.nmr_surat = '$nmr_surat' AND r.propinsi2 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kota3($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kota as nm_kota, r.kota3 as kota3
		FROM kota p, $jsk r
		WHERE r.kota3 = p.kd_kota AND r.nmr_surat = '$nmr_surat' AND r.propinsi3 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kota4($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kota as nm_kota, r.kota4 as kota4
		FROM kota p, $jsk r
		WHERE r.kota4 = p.kd_kota AND r.nmr_surat = '$nmr_surat' AND r.propinsi4 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function selected_kecamatan($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kecamatan as nm_kecamatan, r.kecamatan as kecamatan
		FROM kecamatan p, $jsk r
		WHERE r.kecamatan = p.kd_kecamatan AND r.nmr_surat = '$nmr_surat' AND r.kota = p.kd_kota AND r.propinsi = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kecamatan1($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kecamatan as nm_kecamatan, r.kecamatan1 as kecamatan1
		FROM kecamatan p, $jsk r
		WHERE r.kecamatan1 = p.kd_kecamatan AND r.nmr_surat = '$nmr_surat' AND r.kota1 = p.kd_kota AND r.propinsi1 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kecamatan2($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kecamatan as nm_kecamatan, r.kecamatan2 as kecamatan2
		FROM kecamatan p, $jsk r
		WHERE r.kecamatan2 = p.kd_kecamatan AND r.nmr_surat = '$nmr_surat' AND r.kota2 = p.kd_kota AND r.propinsi2 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kecamatan3($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kecamatan as nm_kecamatan, r.kecamatan3 as kecamatan3
		FROM kecamatan p, $jsk r
		WHERE r.kecamatan3 = p.kd_kecamatan AND r.nmr_surat = '$nmr_surat' AND r.kota3 = p.kd_kota AND r.propinsi3 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kecamatan4($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kecamatan as nm_kecamatan, r.kecamatan4 as kecamatan4
		FROM kecamatan p, $jsk r
		WHERE r.kecamatan4 = p.kd_kecamatan AND r.nmr_surat = '$nmr_surat' AND r.kota4 = p.kd_kota AND r.propinsi4 = p.kd_propinsi";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function selected_kelurahan($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kelurahan as nm_kelurahan, r.kelurahan as kelurahan
		FROM kelurahan p, $jsk r
		WHERE r.kelurahan = p.kd_kelurahan AND r.nmr_surat = '$nmr_surat' AND r.kota = p.kd_kota AND r.propinsi = p.kd_propinsi AND r.kecamatan = p.kd_kecamatan";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	
	function selected_kelurahan_pemilik($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kelurahan as nm_kelurahan, r.kelurahan_pemilik as kelurahan_pemilik
		FROM kelurahan p, $jsk r
		WHERE r.kelurahan_pemilik = p.kd_kelurahan AND r.nmr_surat = '$nmr_surat' AND r.kota_pemilik = p.kd_kota AND r.propinsi_pemilik = p.kd_propinsi AND r.kecamatan_pemilik = p.kd_kecamatan";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kelurahan1($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kelurahan as nm_kelurahan, r.kelurahan1 as kelurahan1
		FROM kelurahan p, $jsk r
		WHERE r.kelurahan1 = p.kd_kelurahan AND r.nmr_surat = '$nmr_surat' AND r.kota1 = p.kd_kota AND r.propinsi1 = p.kd_propinsi AND r.kecamatan1 = p.kd_kecamatan";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kelurahan2($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kelurahan as nm_kelurahan, r.kelurahan2 as kelurahan2
		FROM kelurahan p, $jsk r
		WHERE r.kelurahan2 = p.kd_kelurahan AND r.nmr_surat = '$nmr_surat' AND r.kota2 = p.kd_kota AND r.propinsi2 = p.kd_propinsi AND r.kecamatan2 = p.kd_kecamatan";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kelurahan3($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kelurahan as nm_kelurahan, r.kelurahan3 as kelurahan3
		FROM kelurahan p, $jsk r
		WHERE r.kelurahan3 = p.kd_kelurahan AND r.nmr_surat = '$nmr_surat' AND r.kota3 = p.kd_kota AND r.propinsi3 = p.kd_propinsi AND r.kecamatan3 = p.kd_kecamatan";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
	function get_selected_kelurahan4($nmr_surat, $jsk)
	{
		$sql = "SELECT p.nm_kelurahan as nm_kelurahan, r.kelurahan4 as kelurahan4
		FROM kelurahan p, $jsk r
		WHERE r.kelurahan4 = p.kd_kelurahan AND r.nmr_surat = '$nmr_surat' AND r.kota4 = p.kd_kota AND r.propinsi4 = p.kd_propinsi AND r.kecamatan4 = p.kd_kecamatan";
		$hasil = $this->db->query($sql);
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return array();
		}
	}
}

