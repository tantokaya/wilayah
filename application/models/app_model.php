<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_Model extends CI_Model {

	/**
	 * @author : Hartanto Kurniawan,S.Kom
	 * @keterangan : Controller untuk halaman biodata
	 **/
	 
	
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	
	public function getAllDataLimited($table,$limit,$offset)
	{
		return $this->db->get($table, $limit, $offset);
	}
	
	public function getSelectedDataLimited($table,$data,$limit,$offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}
	function getImage($username){
		$query = $this->db->query("select foto from admins where username = '$username'");
		foreach ($query->result() as $row){
			return $row->foto;
		}
	}
	//select table
	public function getSelectedData($table,$data)
	{
		return $this->db->get_where($table, $data);
	}
	
	//update table
	function updateData($table,$data,$field_key)
	{
		$this->db->update($table,$data,$field_key);
	}
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	
	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}
	
	//Query manual
	function manualQuery($q)
	{
		return $this->db->query($q);
	}
	
	public function NamaSupp($id){
		$t = "SELECT * FROM supplier WHERE kode_supplier='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->nama_supplier;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
		
///// AGAMA //////
	public function NamaAgama($id){
		$t = "SELECT * FROM agama WHERE aga_kode='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->aga_nama;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
///// PENDIDIKAN ///////
	public function NamaPendidikan($id){
		$t = "SELECT * FROM pendidikan WHERE pen_kode='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->pen_nama;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}

///// PEKERJAAN ///////
	public function NamaPekerjaan($id){
		$t = "SELECT * FROM pekerjaan WHERE pek_kode='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->pek_nama;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
///// KEWARGANEGARAAN ///////
	public function NamaKewarganegaran($id){
		$t = "SELECT * FROM kewarganegaraan WHERE kew_kode='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->kew_nama;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}	
	
///// BIODATA ///////
	public function NamaBiodata($id){
		$t = "SELECT * FROM biodata WHERE nik='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->bio_nama;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}		
	
	
	public function CariLevel($id){
		$t = "SELECT * FROM level WHERE id_level='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->level;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function ItemBeli($id){
		$t = "SELECT kodebeli FROM d_beli WHERE kodebeli='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlBeli($id){
		$t = "SELECT sum(jmlbeli * hargabeli) as jml FROM d_beli WHERE kodebeli='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function ItemJual($id){
		$t = "SELECT kodejual FROM d_jual WHERE kodejual='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlJual($id){
		$t = "SELECT sum(jmljual * hargajual) as jml FROM d_jual WHERE kodejual='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokAwal($kode){
		$t = "SELECT kode_barang,stok_awal FROM barang WHERE kode_barang='$kode'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->stok_awal;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlBeli($kode){
		$t = "SELECT kode_barang,sum(jmlbeli) as jml FROM d_beli WHERE kode_barang='$kode' GROUP BY kode_barang";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlJual($kode){
		$t = "SELECT kode_barang,sum(jmljual) as jml FROM d_jual WHERE kode_barang='$kode' GROUP BY kode_barang";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function GrafikBeli($bln,$thn){
		$t = "SELECT month(a.tglbeli) as bln, year(a.tglbeli) as th, count(*) as jml 
			FROM h_beli as a
			JOIN d_beli as b
			ON a.kodebeli=b.kodebeli 
			WHERE month(a.tglbeli)='$bln' AND year(a.tglbeli)='$thn'
			GROUP BY month(a.tglbeli),year(a.tglbeli)";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function get_GrafikMaleSKL(){
		$t = "SELECT COUNT(*) as male FROM `skl` 
			WHERE jk3='L'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->male;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function get_GrafikFemaleSKL(){
		$t = "SELECT COUNT(*) as female FROM `skl` 
			WHERE jk3='P'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->female;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikMale(){
		$t = "SELECT COUNT(*) as male FROM `biodata` 
			WHERE bio_jk='1'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->male;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikFemale(){
		$t = "SELECT COUNT(*) as female FROM `biodata` 
			WHERE bio_jk='2'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->female;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkdu($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skdu
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skdu
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSku($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM sku
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM sku
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSktt($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktt
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktt
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSktmp($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktmp
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktmp
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkpck($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skpck
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skpck
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkbm($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skbm
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skbm
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkir($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skir
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skir
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkb($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skb
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skb
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkbn($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skbn
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skbn
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSktkt($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktkt
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktkt
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSktot($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktot
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM sktot
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkau($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skau
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skau
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkun($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skun
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skun
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkun_NA($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skun_na
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skun_na
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkpm($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skpm
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skpm
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSiotm($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM siotm
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM siotm
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkdk($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skdk
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skdk
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkpnh($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skpnh
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skpnh
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkaw($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skaw
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skaw
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkppsp($bln,$thn){
		if($bln==''){
		$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
			FROM skppsp
			WHERE year(tgl_pengajuan)='$thn'
			GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skppsp
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkrt($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skrt
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skrt
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkbmr($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skbmr
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skbmr
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkjd($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skjd
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skjd
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikSkptt($bln,$thn){
		if($bln==''){
		$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
			FROM skptt
			WHERE year(tgl_pengajuan)='$thn'
			GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skptt
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikAngkaKelahiran($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skl
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skl
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikAngkaKematian($bln,$thn){
		if($bln==''){
			$t = "SELECT year(tgl_pengajuan) as th, count(*) as jml 
				FROM skk
				WHERE year(tgl_pengajuan)='$thn'
				GROUP BY year(tgl_pengajuan)";
		}else{
			$t = "SELECT month(tgl_pengajuan) as bln, year(tgl_pengajuan) as th, count(*) as jml 
				FROM skk
				WHERE month(tgl_pengajuan)='$bln' AND year(tgl_pengajuan)='$thn'
				GROUP BY month(tgl_pengajuan),year(tgl_pengajuan)";
		}
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function GrafikJual($bln,$thn){
		$t = "SELECT month(a.tgljual) as bln, year(a.tgljual) as th, count(*) as jml 
			FROM h_jual as a
			JOIN d_jual as b
			ON a.kodejual=b.kodejual 
			WHERE month(a.tgljual)='$bln' AND year(a.tgljual)='$thn'
			GROUP BY month(a.tgljual),year(a.tgljual)";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokAkhir($kode){
		$awal = $this->app_model->CariStokAwal($kode);
		$beli = $this->app_model->CariJmlBeli($kode);
		$jual = $this->app_model->CariJmlJual($kode);
		$hasil = ($awal+$beli)-$jual;
		return $hasil;
	}
	
	public function CariNamaPengguna(){
		$id = $this->session->userdata('username');
		$t = "SELECT * FROM admins WHERE username='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->nama_lengkap;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function CariFotoPengguna(){
		$id = $this->session->userdata('username');
		$t = "SELECT * FROM admins WHERE username='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->foto;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function TotalBeli($tgl1,$tgl2){
		$t = "SELECT sum(a.jmlbeli * a.hargabeli) as jml 
			FROM d_beli as a
			JOIN h_beli as b
			ON a.kodebeli=a.kodebeli 
			WHERE b.tglbeli BETWEEN '$tgl1' AND '$tgl2'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function TotalJual($tgl1,$tgl2){
		$t = "SELECT sum(a.jmljual * a.hargajual) as jml 
				FROM d_jual as a
				JOIN h_jual as b
				ON a.kodejual=b.kodejual 
				WHERE b.tgljual BETWEEN '$tgl1' AND '$tgl2'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	
		
	public function MaxKodeSkdu(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skdu";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSku(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM sku";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSktt(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM sktt";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}

	public function MaxKodeSktmp(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM sktmp";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkpck(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skpck";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,3,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkbm(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skbm";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkir(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skir";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkb(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skb";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkk(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skk";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	public function MaxKodeSkl(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skl";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	public function MaxKodeSkbn(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skbn";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSktkt(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM sktkt";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSktot(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM sktot";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,5,5))+1;
				$hasil = 'SKTOT'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'SKTOT'.'00001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkun(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skun";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,4,5))+1;
				$hasil = 'SKUN'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'SKUN'.'00001';
		}
		return $hasil;
	}
	public function MaxKodeSkna(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skun_na";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	public function MaxKodeSkau(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skau";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,5,5))+1;
				$hasil = 'SKAU'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'SIOTM'.'00001';
		}
		return $hasil;
	}
	public function MaxKodeSkpm(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skpm";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	public function MaxKodeSiotm(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM siotm";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
		
	public function MaxKodeSkpnh(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skpnh";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	public function MaxKodeSkdk(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skdk";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	public function MaxKodeSkaw(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skaw";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}	
	public function MaxKodeSkppsp(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skppsp";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}	
	public function MaxKodeSkrt(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skrt";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkbmr(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skbmr";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkjd(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skjd";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
	public function MaxKodeSkptt(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(nmr_surat) as no FROM skptt";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,1,10))+1;
				$hasil = ''.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = ''.'0000000001';
		}
		return $hasil;
	}
	
		
	//Konversi tanggal
	public function tgl_sql($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	public function tgl_sqlG($date){
		$exp = explode('/',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	
	public function tgl_str($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}	
	public function umur_str($dates){
		$exp = explode('-',$dates);
		if(count($exp) == 3) {
			$dates = (int)date("Y")-(int)$exp[0];
		}
		return $dates;
	}
	public function ambilTgl($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[2];
		return $tgl;
	}
	
	public function ambilBln($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[1];
		$bln = $this->app_model->getBulan($tgl);
		$hasil = substr($bln,0,3);
		return $hasil;
	}
	
	public function tgl_indo($tgl){
			$jam = substr($tgl,11,10);
			$tgl = substr($tgl,0,10);
			$tanggal = substr($tgl,8,2);
			$bulan = $this->app_model->getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun.' '.$jam;		 
	}	

	public function getBulan($bln){
		switch ($bln){
			case 1: 
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	} 
	
	public function hari_ini($hari){
		date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
		$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		//$hari = date("w");
		$hari_ini = $seminggu[$hari];
		return $hari_ini;
	}
	
	//query login
	public function getLoginData($usr,$psw)
	{
		$u = mysql_real_escape_string($usr);
		$p = md5(mysql_real_escape_string($psw));
		$q_cek_login = $this->db->get_where('admins', array('username' => $u, 'password' => $p));
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
					foreach($q_cek_login->result() as $qad)
					{
						$sess_data['logged_in'] = 'aingLoginYeuh';
						$sess_data['username'] = $qad->username;
						$sess_data['nama_lengkap'] = $qad->nama_lengkap;
						$sess_data['foto'] = $qad->foto;
						$sess_data['level'] = $qad->level;
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/home');
			}
		}
		else
		{
			$this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
			header('location:'.base_url().'index.php/login');
		}
	}
	public function get_all_male()
	{
		$text = "SELECT COUNT(*) as male FROM `biodata` WHERE bio_jk='1'";
		$d = $this->app_model->manualQuery($text);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->male;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function get_male($usia)
	{
		$u = explode('-',$usia);
		if($u[0]==75){
			$us1 = (int)date("Y")-(int)$u[0];
			$text = "SELECT COUNT(*) as male FROM `biodata` 
			WHERE YEAR(bio_tgl_lahir) < '$us1' AND bio_jk='1'";
		}else{
			$us1 = (int)date("Y")-(int)$u[0];
			$us2 = (int)date("Y")-(int)$u[1];
			$text = "SELECT COUNT(*) as male FROM `biodata` 
			WHERE YEAR(bio_tgl_lahir) BETWEEN '$us2' AND '$us1' AND bio_jk='1'";
		}
		$d = $this->app_model->manualQuery($text);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->male;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function get_all_female()
	{
		$text = "SELECT COUNT(*) as female FROM `biodata` WHERE bio_jk='2'";
		$d = $this->app_model->manualQuery($text);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->female;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function get_female($usia)
	{
		$u = explode('-',$usia);
		if($u[0]==75){
			$us1 = (int)date("Y")-(int)$u[0];
			$text = "SELECT COUNT(*) as female FROM `biodata` 
			WHERE YEAR(bio_tgl_lahir) < '$us1' AND bio_jk='2'";
		}else{
			$us1 = (int)date("Y")-(int)$u[0];
			$us2 = (int)date("Y")-(int)$u[1];
			
			$text = "SELECT COUNT(*) as female FROM `biodata` 
			WHERE YEAR(bio_tgl_lahir) BETWEEN '$us2' AND '$us1' AND bio_jk='2'";
		}
		$d = $this->app_model->manualQuery($text);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->female;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function get_berlaku_sku($tgl_pengajuan)
	{
		$sku= strtotime('+3 month',strtotime($tgl_pengajuan));
		$hasil = date('d-m-Y',$sku);
		return $hasil;
	}
	public function get_berlaku_skdu($tgl_pengajuan)
	{
		$sku= strtotime('next year',strtotime($tgl_pengajuan));
		$hasil = date('d-m-Y',$sku);
		return $hasil;
	}
	public function get_kota($id)
	{
		$text = "SELECT * FROM kota where kd_propinsi='$id' ORDER BY nm_kota ASC";
		$d = $this->app_model->manualQuery($text);
		return $d;
	}
	public function get_kec($id, $ad)
	{
		$text = "SELECT * FROM kecamatan where kd_kota='$id' AND kd_propinsi='$ad' ORDER BY nm_kecamatan ASC";
		$d = $this->app_model->manualQuery($text);
		return $d;
	}
	public function get_kel($id,$ad,$dd)
	{
		$text = "SELECT * FROM kelurahan where kd_kecamatan='$id' AND kd_kota='$ad' AND kd_propinsi='$dd'  ORDER BY nm_kelurahan ASC";
		$d = $this->app_model->manualQuery($text);
		return $d;
	}
	public function cek_nik($nik) {
		$text = "SELECT * FROM biodata where nik='$nik'";
		$d = $this->app_model->manualQuery($text);
		if($d->num_rows() > 0)
			return FALSE;
		else
			return TRUE;
	}

}
	
/* End of file app_model.php */
/* Location: ./application/models/app_model.php */