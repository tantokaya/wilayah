<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#pen_kode").focus();
	
	$("#pen_kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataPendidikan();
	});
	
	function CariDataPendidikan(){
		var pen_kode = $("#pen_kode").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoPendidikan",
			data	: "pen_kode="+pen_kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#pen_nama").val(data.pen_nama);
			}
		});
	}
	
	$("#simpan").click(function(){
		var pen_kode		= $("#pen_kode").val();
		var pen_nama	= $("#pen_nama").val();
		
		var string = $("#form").serialize();
		
		if(pen_kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#pen_kode").focus();
			return false();
		}
		if(pen_nama.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Pendidikan tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#pen_nama").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pendidikan/simpan",
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
	<td width="150">Kode Pendidikan</td>
    <td width="5">:</td>
    <td><input type="text" name="pen_kode" id="pen_kode" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[2,10]'" value="<?php echo $pen_kode;?>" /></td>
</tr>
<tr>    
	<td>Nama Pendidikan</td>
    <td>:</td>
    <td><input type="text" name="pen_nama" id="pen_nama"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $pen_nama;?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/pendidikan/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/pendidikan/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>