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
</td>


<td valign="top" width="40%">
<fieldset>
<table width="100%">
	<center><img width="249" height="245" style="padding:0; margin:0; " src="http://localhost/wilayah/asset/images/logo.gif"></center>
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