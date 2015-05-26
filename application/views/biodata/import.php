<form method="post" enctype="multipart/form-data" accept-charset="utf-8"  action="<?php echo base_url() . "index.php/biodata/do_upload"; ?>" >
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Upload File</td>
    <td width="5">:</td>
    <td><input type="file" class="easyui-validatebox" name="userfile"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
	<button type="submit" name="upload" id="upload" class="easyui-linkbutton" data-options="iconCls:'icon-save'">UPLOAD</button>
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'"  onClick="window.open('<?php echo base_url();?>index.php/biodata','_self');">BATAL</button>
    </td>
</tr>
</table>  
</fieldset>   
</form>