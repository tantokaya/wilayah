<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#aga_kode").focus();
	
	$("#aga_kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataAgama();
	});
	
	function CariDataAgama(){
		var aga_kode = $("#aga_kode").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoAgama",
			data	: "aga_kode="+aga_kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#aga_nama").val(data.aga_nama);
			}
		});
	}
	
	$("#simpan").click(function(){
		var aga_kode		= $("#aga_kode").val();
		var aga_nama	= $("#aga_nama").val();
		
		var string = $("#form").serialize();
		
		if(aga_kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#aga_kode").focus();
			return false();
		}
		if(aga_nama.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Agama tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#aga_nama").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/agama/simpan",
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
	<td width="150">Kode Agama</td>
    <td width="5">:</td>
    <td><input type="text" name="aga_kode" id="aga_kode" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[2,10]'" value="<?php echo $aga_kode;?>" /></td>
</tr>
<tr>    
	<td>Nama Agama</td>
    <td>:</td>
    <td><input type="text" name="aga_nama" id="aga_nama"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $aga_nama;?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/agama/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/agama/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>