<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#nik").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#tgl_1").datepicker({
			dateFormat:"dd-mm-yy"
    });
	$("#tgl_2").datepicker({
			dateFormat:"dd-mm-yy"
    });
	$("#cari").click(function(){
		var nik = $("#nik").val();
		var tgl_1 = $("#tgl_1").val();
		var tgl_2 = $("#tgl_2").val();
		
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		var string = "nik="+nik+"&pilih="+pilih+"&tgl_1="+tgl_1+"&tgl_2="+tgl_2;
		
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		 $("#tampil_data").html('');
		 $.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/lap_skl/lihat",
			data	: string,
			cache	: false,
			success	: function(data){
				var win = $.messager.progress({
				title:'Please waiting',
				msg:'Loading data...'
				});
				setTimeout(function(){
					$.messager.progress('close');
					$("#tampil_data").html(data);
				},2800)
			}		
		});
		return false();	
	});
	
	$("#cetak").click(function(){
		var kode = $("#nik").val();
		var tgl_1 = $("#tgl_1").val();
		var tgl_2 = $("#tgl_2").val();
		
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		if(pilih=='all'){
			var string = pilih;
		}else if(pilih=='tgl'){
			var string = pilih+"/"+tgl_1+"/"+tgl_2;
		}else{
			var string = pilih+"/"+kode;
		}
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		
		window.open('<?php echo site_url();?>/lap_skl/cetak/'+string);
		 
		return false();	
	});
	
});	
</script>
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="all" checked="checked" onclick="document.getElementById('tgl_1').disabled = true; document.getElementById('tgl_2').disabled = true; document.getElementById('nik').disabled = true;" />Semua Data</td>
    <td width="5"></td>
    <td></td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="tgl" onclick="document.getElementById('tgl_1').disabled = false; document.getElementById('tgl_2').disabled = false; document.getElementById('nik').disabled = true;"/>Tanggal</td>
    <td width="5"></td>
    <td><input type="text" name="tgl_1" id="tgl_1" size="12" maxlength="12" id="tgl_1" disabled />
    s.d <input type="text" name="tgl_2" id="tgl_2" size="12" maxlength="12" id="tgl_2" disabled />
    </td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="kode" onclick="document.getElementById('tgl_1').disabled = true; document.getElementById('tgl_2').disabled = true; document.getElementById('nik').disabled = false;"/>Kode NIK</td>
    <td width="5"></td>
    <td><input type="text" name="nik" id="nik" size="16" maxlength="16" disabled /><span style="font-weight:100; margin-left:20px;">Masukkan Kode NIK Ibu / Ayah</span></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">CARI</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
	<a href="<?php echo base_url();?>index.php/lap_skl">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton l-btn" data-options="iconCls:'icon-reload'">REFRESH</button>
	</a>
    <a href="<?php echo base_url();?>index.php/suratketerangan">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>
<fieldset>
<div id="tampil_data"></div>
</fieldset>   