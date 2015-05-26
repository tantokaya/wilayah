<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#cari").click(function(){
		var umur = $("#umur").val();
		
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		var string = "&pilih="+pilih+"&umur="+umur;
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		 
		 $("#tampil_data").html('');
		 $.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/lap_penduduk_usia/lihat",
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
		var umur = $("#umur").val();
		
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		if(pilih=='all'){
			var string = pilih;
		}else if(pilih=='umur'){
			var string = pilih+"/"+umur;
		}
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		
		window.open('<?php echo site_url();?>/lap_penduduk_usia/cetak/'+string);
		 
		return false();	
	});
	
});	
</script>
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="all" checked="checked" onclick="document.getElementById('umur').disabled = true;" />Semua Data</td>
    <td width="5"></td>
    <td></td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="umur" onclick="document.getElementById('umur').disabled = false;"/>Usia</td>
    <td width="5"></td>
    <td>
	<select name="umur"  id="umur" disabled />
		<?php
			for($u=0;$u<=75;$u+=5)
			{
				$a = $u+4;
				if($u==75){echo "<option value='$u-00'>$u+</option>";}
				else{echo "<option value='$u-$a'>$u - $a</option>";}
			}
		?>
	</select>

    </td>
</tr>

</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">CARI</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
	<a href="<?php echo base_url();?>index.php/lap_penduduk_usia">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton l-btn" data-options="iconCls:'icon-reload'">REFRESH</button>
	</a>
    <a href="<?php echo base_url();?>index.php/home">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>
<fieldset>
<div id="tampil_data"></div>
</fieldset>   