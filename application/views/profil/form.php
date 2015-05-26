<script language="text/javascript">
function nama() {
    var x = document.forms["profil"]["nama_lengkap"].value;
    if (x==null || x=="") {
        alert("Nama Lengkap Tidak Boleh Kosong !");
        return false;
    }
}
</script>
<form method="post" enctype="multipart/form-data" action="<?php echo base_url() . "index.php/profil/simpan"; ?>" onsubmit="return nama()" name="profil">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Username</td>
    <td width="5">:</td>
    <td><input type="text" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $username;?>"/></td>
</tr>
<tr>    
	<td>Nama Lengkap</td>
    <td>:</td>
    <td><input type="text" name="nama_lengkap" id="nama_lengkap"  size="20" maxlength="50" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $nama_lengkap;?>"/></td>
</tr>
<tr>    
	<td>Password</td>
    <td>:</td>
    <td><input type="password" name="pwd" id="pwd"  size="20" maxlength="20" value="<?php echo $pwd;?>"/>
    Kosongkan Password jika tidak diubah
    </td>
</tr>
<tr>    
	<td>Foto Profil<br><img src="<?php echo base_url();?>asset/foto_profil/<?php echo $foto;?>" width="92" height="92"></td>
    <td>:</td>
    <td><input type="file" name="foto" id="foto" value="<?php echo $foto;?>">
    </td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
<button type="submit" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'"  onClick="window.open('<?php echo base_url();?>index.php/home','_self');">KEMBALI</button>
    
    <input type="hidden" name="username" value="<?php echo $username;?>"/>
    </td>
</tr>
</table>  
</fieldset>   
<?php echo form_close(); ?>