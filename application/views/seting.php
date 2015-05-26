<p>Hai, Selamat datang <b><?php echo $this->session->userdata('nama_lengkap');?></b> di Seting Sistem Aplikasi <b><?php echo $nama_program;?></b></p>
<br />
<?php 
if($this->session->userdata('level')=='01'){
?>
<script language="text/javascript">
$(document).ready(function(){
$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});
});
</script>
<form method="post" action="<?php echo base_url() . "index.php/seting/simpan"; ?>" onsubmit="return nama()" name="seting">
<table width="100%">
<tr>
<td valign="top" width="60%">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Kode Kelurahan</td>
    <td width="5">:</td>
    <td><input type="text" size="20" name="kd_kelurahan" id="kd_kelurahan" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $kd_kelurahan; ?>"/></td>
	<input type="hidden" size="20" name="status" id="status" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $status; ?>"/>
</tr>
<tr>    
	<td>Nama Lurah</td>
    <td>:</td>
    <td><input type="text" name="nama_lurah" id="nama_lurah"  size="60" maxlength="70"  data-options="required:true,validType:'length[3,10]'" value="<?php echo $nama_lurah; ?>"/></td>
</tr>
<tr>    
	<td>NIP Lurah</td>
    <td>:</td>
    <td><input type="text" name="nip_lurah" id="nip_lurah"  size="30" maxlength="30"  data-options="required:true,validType:'length[3,10]'" value="<?php echo $nip_lurah; ?>"/></td>
</tr>
<tr>    
	<td>Jabatan Lurah</td>
    <td>:</td>
    <td><input type="text" name="lok_lurah" id="lok_lurah"  size="60" maxlength="70"  data-options="required:true,validType:'length[3,10]'" value="<?php echo $lok_lurah; ?>"/></td>
</tr>
<tr>    
	<td>Nama Kelurahan</td>
    <td>:</td>
    <td><input type="text" name="s_kelurahan" id="s_kelurahan"  size="40" maxlength="50"  data-options="required:true,validType:'length[3,10]'" value="<?php echo $s_kelurahan; ?>"/></td>
</tr>
<tr>    
    <td>Alamat Kelurahan</td>
    <td>:</td>
    <td><textarea name="s_alamat" style="width:320px; height:80px;" id="s_alamat"  class="detail" /><?php echo $s_alamat; ?></textarea></td>
</tr>
<tr>    
	<td>No Telp / Fax</td>
    <td>:</td>
    <td><input type="text" name="s_tlp_fax" id="s_tlp_fax"  size="60" maxlength="70"  data-options="required:true,validType:'length[3,80]'" value="<?php echo $s_tlp_fax; ?>"/></td>
</tr>
<tr>    
	<td>Website</td>
    <td>:</td>
    <td><input type="text" name="s_url" id="s_url"  size="40" maxlength="50"  data-options="required:true,validType:'length[3,10]'" value="<?php echo $s_url; ?>"/></td>
</tr>
<tr>    
	<td>Nama Kecamatan</td>
    <td>:</td>
    <td><input type="text" name="s_kecamatan" id="s_kecamatan"  size="40" maxlength="50"  data-options="required:true,validType:'length[3,10]'" value="<?php echo $s_kecamatan; ?>"/></td>
</tr>
</table>
</fieldset>
<fieldset>
<table>
	<center><img width="249" height="245" style="padding:0; margin:0; " src="http://localhost/wilayah/asset/images/logo.gif"></center>
</table>
</fieldset>
</td>


<td valign="top" width="40%">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td>No Surat Keterangan Domisili Usaha</td>
    <td>:</td>
    <td><input type="text" name="no_skdu" id="no_skdu"  size="7" maxlength="15"   value="<?php echo $no_skdu; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Usaha</td>
    <td>:</td>
    <td><input type="text" name="no_sku" id="no_sku"  size="7" maxlength="15"  value="<?php echo $no_sku; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Tmp Tinggal</td>
    <td>:</td>
    <td><input type="text" name="no_sktt" id="no_sktt"  size="7" maxlength="15"   value="<?php echo $no_sktt; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Tdk Mampu</td>
    <td>:</td>
    <td><input type="text" name="no_sktmp" id="no_sktmp"  size="7" maxlength="15"   value="<?php echo $no_sktmp; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Pengantar Kepolisian</td>
    <td>:</td>
    <td><input type="text" name="no_skpck" id="no_skpck"  size="7" maxlength="15"  value="<?php echo $no_skpck; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Belum Menikah</td>
    <td>:</td>
    <td><input type="text" name="no_skbm" id="no_skbm"  size="7" maxlength="15" value="<?php echo $no_skbm; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Ijin Keramaian</td>
    <td>:</td>
    <td><input type="text" name="no_skir" id="no_skir"  size="7" maxlength="15"  value="<?php echo $no_skir; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Bepergian</td>
    <td>:</td>
    <td><input type="text" name="no_skb" id="no_skb"  size="7" maxlength="15"  value="<?php echo $no_skb; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Kematian</td>
    <td>:</td>
    <td><input type="text" name="no_skk" id="no_skk"  size="7" maxlength="15" value="<?php echo $no_skk; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Kelahiran</td>
    <td>:</td>
    <td><input type="text" name="no_skl" id="no_skl"  size="7" maxlength="15" value="<?php echo $no_skl; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Beda Nama</td>
    <td>:</td>
    <td><input type="text" name="no_skbn" id="no_skbn"  size="7" maxlength="15" value="<?php echo $no_skbn; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Tdk Keberatan Ortu</td>
    <td>:</td>
    <td><input type="text" name="no_sktkt" id="no_sktkt"  size="7" maxlength="15" value="<?php echo $no_sktkt; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Pengantar Nikah</td>
    <td>:</td>
    <td><input type="text" name="no_spn" id="no_spn"  size="7" maxlength="15" value="<?php echo $no_spn; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Persetujuan Mempelai</td>
    <td>:</td>
    <td><input type="text" name="no_skpm" id="no_skpm"  size="7" maxlength="15" value="<?php echo $no_skpm; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Ijin Orangtua Untuk Menikah</td>
    <td>:</td>
    <td><input type="text" name="no_siotm" id="no_siotm"  size="7" maxlength="15" value="<?php echo $no_siotm; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Daftar Keluarga</td>
    <td>:</td>
    <td><input type="text" name="no_skdk" id="no_skdk"  size="7" maxlength="15" value="<?php echo $no_skdk; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Pengantar Naik Haji</td>
    <td>:</td>
    <td><input type="text" name="no_skpnh" id="no_skpnh"  size="7" maxlength="15" value="<?php echo $no_skpnh; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Ahli Waris</td>
    <td>:</td>
    <td><input type="text" name="no_skaw" id="no_skaw"  size="7" maxlength="15"  value="<?php echo $no_skaw; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Pengantar SPPT-PBB</td>
    <td>:</td>
    <td><input type="text" name="no_skppsp" id="no_skppsp"  size="7" maxlength="15" value="<?php echo $no_skppsp; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Riwayat Tanah</td>
    <td>:</td>
    <td><input type="text" name="no_skrt" id="no_skrt"  size="7" maxlength="15" value="<?php echo $no_skrt; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Belum Memiliki Rumah</td>
    <td>:</td>
    <td><input type="text" name="no_skbmr" id="no_skbmr"  size="7" maxlength="15" value="<?php echo $no_skbmr; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Cera Hidup / Mati</td>
    <td>:</td>
    <td><input type="text" name="no_skjd" id="no_skjd"  size="7" maxlength="15" value="<?php echo $no_skjd; ?>"/></td>
</tr>
<tr>    
	<td>No Surat Keterangan Penghasilan Tidak Tetap</td>
    <td>:</td>
    <td><input type="text" name="no_skptt" id="no_skptt"  size="7" maxlength="15" value="<?php echo $no_skptt; ?>"/></td>
</tr>

</table>
</fieldset>
</td>
</tr>
</table>

<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
<button type="submit" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'"  onClick="window.open('<?php echo base_url();?>index.php/home','_self');">KEMBALI</button>
   </td>
</tr>
</table>  
</fieldset>
</td>   
<?php echo form_close(); ?>
<?php } ?>