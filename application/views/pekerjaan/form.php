<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#pek_kode").focus();
	
	$("#pek_kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataPekerjaan();
	});
	
	function CariDataPekerjaan(){
		var pek_kode = $("#pek_kode").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoPekerjaan",
			data	: "pek_kode="+pek_kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#pek_nama").val(data.pek_nama);
			}
		});
	}
	
	$("#simpan").click(function(){
		var pek_kode		= $("#pek_kode").val();
		var pek_nama	= $("#pek_nama").val();
		
		var string = $("#form").serialize();
		
		if(pek_kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#pek_kode").focus();
			return false();
		}
		if(pek_nama.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama pekerjaan tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#pek_nama").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pekerjaan/simpan",
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
	<td width="150">Kode pekerjaan</td>
    <td width="5">:</td>
    <td><input type="text" name="pek_kode" id="pek_kode" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[2,10]'" value="<?php echo $pek_kode;?>" /></td>
</tr>
<tr>    
	<td>Nama pekerjaan</td>
    <td>:</td>
    <td><input type="text" name="pek_nama" id="pek_nama"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $pek_nama;?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/pekerjaan/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/pekerjaan/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>