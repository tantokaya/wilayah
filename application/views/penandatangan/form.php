<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#ttd_nip").focus();
	
	$("#simpan").click(function(){
		var ttd_nip	= $("#ttd_nip").val();
		var ttd_nama = $("#ttd_nama").val();
		
		var string = $("#form").serialize();
		
		if(ttd_nip.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, NIP tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#ttd_nip").focus();
			return false();
		}
		if(ttd_nama.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama ttd tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#ttd_nama").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/penandatangan/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				CariSimpanan();
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server tidak merespon :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		return false();		
	});
	
});	
</script>
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">NIP</td>
    <td width="5">:</td>
    <td><input type="text" name="ttd_nip" id="ttd_nip" size="30" maxlength="30" class="easyui-validatebox" data-options="required:true,validType:'length[8,30]'" value="<?php echo $ttd_nip;?>" /></td>
</tr>
<tr>    
	<td>Nama Pejabat</td>
    <td>:</td>
    <td><input type="text" name="ttd_nama" id="ttd_nama"  size="50" maxlength="30" class="easyui-validatebox" data-options="required:true,validType:'length[3,30]'" value="<?php echo $ttd_nama;?>"/></td>
</tr>
<tr>    
	<td>Jabatan</td>
    <td>:</td>
    <td>
	    <select name="ttd_jab" id="ttd_jab" style="width:35%;" class="easyui-validatebox" data-options="required:true">
			<option value="">-PILIH-</option>
			<option value="Sekretaris" <?php if($ttd_jab=='Sekretaris'){echo "selected='selected'";}?>>Sekretaris</option>
			<option value="Kepala Seksi Pemerintahan" <?php if($ttd_jab=='Kepala Seksi Pemerintahan'){echo "selected='selected'";}?>>Kepala Seksi Pemerintahan</option>
			<option value="Kepala Seksi Kemasyarakatan"<?php if($ttd_jab=='Kepala Seksi Kemasyarakatan'){echo "selected='selected'";}?>>Kepala Seksi Kemasyarakatan</option>
			<option value="Kepala Seksi Ekonomi Pembangunan"<?php if($ttd_jab=='Kepala Seksi Ekonomi Pembangunan'){echo "selected='selected'";}?>>Kepala Seksi Ekonomi Pembangunan</option>
			<option value="Kepala Seksi Ketentraman dan Ketertiban"<?php if($ttd_jab=='Kepala Seksi Ketentraman dan Ketertiban'){echo "selected='selected'";}?>>Kepala Seksi Ketentraman dan Ketertiban</option>
        </select>
		
		
	<!-- <input type="text" name="ttd_jab" id="ttd_jab"  size="50" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[3,30]'" value="<?php echo $ttd_jab;?>"/> -->
	
	</td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
	<input type="hidden" value="<?php echo $ttd_kode;?>" name="ttd_kode" id="ttd_kode">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/penandatangan/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/penandatangan/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>