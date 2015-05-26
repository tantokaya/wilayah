<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	tampil_data();
	
	function tampil_data(){
		var nmr_surat = $("#nmr_surat").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/sktot/DataDetail",
			data	: "nmr_surat="+nmr_surat,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	$("#tgl2").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	$("#bio_tgl_lahir").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	
	$("#nmr_surat").focus();
	
	
	$("#nik1").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#nik1").focus(function(e){
		var isi = $(e.target).val();
		CariNik1();
	});
	
	$("#nik1").keyup(function(){
		CariNik1();
		
	});
	
	function CariNik1(){
		var nik1 = $("#nik1").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBiodata",
			data	: "nik1="+nik1,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#bio_nama1").val(data.bio_nama1);
				$("#bio_tmp_lahir1").val(data.bio_tmp_lahir1);
				$("#bio_tgl_lahir1").val(data.bio_tgl_lahir1);
				$("#bio_jk1").val(data.bio_jk1);
				$("#bio_kew1").val(data.bio_kew1);
				$("#bio_agama1").val(data.bio_agama1);
				$("#bio_pekerjaan1").val(data.bio_pekerjaan1);
				$("#bio_alamat1").val(data.bio_alamat1);
			}
		});
	};
	
	$("#simpan").click(function(){
		var nmr_surat	= $("#nmr_surat").val();
		var tgl		= $("#tgl").val();
		var nik1		= $("#nik1").val();
		
		var string = $("#form").serialize();
		
		if(nmr_surat.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nomor Surat tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#nmr_surat").focus();
			return false();
		}
		if(tgl.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Tanggal tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#tgl").focus();
			return false();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/sktot/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				tampil_data();
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
	
	$("#tambah_data").click(function(){
		$("#nik1").val('');
		$("#nik1").focus();
	});
	
	$("#cetak").click(function(){
		var nmr_surat	= $("#nmr_surat").val();
		window.open('<?php echo site_url();?>/sktot/cetak/'+nmr_surat);
		return false();
	});
	
	/////////// CARI BIODATA AYAH /////////////
	
	$("#cari_nik1").click(function(){
		AmbilDaftarNik();
		$("#dlg").dialog('open');
		
	});
	
	$("#text_cari").keyup(function(){
		AmbilDaftarNik();
		
		//$("#dlg").dialog('open');
	});
	
	function AmbilDaftarNik(){
		var cari = $("#text_cari").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataNik",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_nik").html(data);
			}
		});
	}
	
	/////////// CARI BIODATA IBU /////////////
	$("#cari_nik2").click(function(){
		AmbilDaftarNik2();
		$("#dlg2").dialog('open');
		
	});
	
	$("#text_cari2").keyup(function(){
		AmbilDaftarNik2();
		
		//$("#dlg").dialog('open');
	});
	
	function AmbilDaftarNik2(){
		var cari = $("#text_cari2").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataNik",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_nik2").html(data);
			}
		});
	}
});	
</script>
<form name="form" id="form">
<table width="100%">
<tr>
<td valign="top" width="50%">
    <fieldset>
    <table width="100%">
    <tr>    
        <td width="150">Nomor Surat</td>
        <td width="5">:</td>
        <td><input type="text" name="nmr_surat" id="nmr_surat" size="15" maxlength="15"  class="easyui-validatebox" data-options="required:true,validType:'length[3,15]'" value="<?php echo $nmr_surat;?>"  /></td>
    </tr>
    <tr>    
        <td>Tanggal Surat</td>
        <td>:</td>
        <td><input type="text" name="tgl_surat" id="tgl"  size="10" maxlength="10" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $tgl_surat;?>"/></td>
    </tr>
	
	<!---------------------------------------------------------  AYAH KANDUNG------------------------------------------------------------------->
   
   <tr><td><b>BioData Ayah</b></td></tr>
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik1" id="nik1" size="18" maxlength="18" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik1;?>"  />
        <button type="button" name="cari_nik" id="cari_nik1" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="sktot_nama1" id="bio_nama1"  size="50" class="detail" maxlength="50"  value="<?php echo $sktot_nama1;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir1" id="bio_tmp_lahir1"  size="20" class="detail" maxlength="20"   value="<?php echo $tmp_lahir1;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir1" id="bio_tgl_lahir"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir1;?>"   />
		</td>
    </tr>
	<tr>    
        <td>Agama</td>
        <td>:</td>
        <td><input type="text" name="aga_id1" id="bio_agama1"  size="10"class="detail" maxlength="10" value="<?php echo $aga_id1;?>"  /></td>
    </tr>
    
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><input type="text" name="jk1" id="bio_jk1"  size="10"class="detail" maxlength="10" value="<?php echo $jk1;?>"   /></td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td><input type="text" name="kew_id1" id="bio_kew1"  size="10"class="detail" maxlength="10" value="<?php echo $kew_id1;?>"  /></td>
    </tr>
	<tr>    
        <td>Pekerjaan</td>
        <td>:</td>
        <td><input type="text" name="pek_id1" id="bio_pekerjaan1"  size="10"class="detail" maxlength="10" value="<?php echo $pek_id1;?>"  /></td>
    </tr>
	<tr>    
        <td>Alamat</td>
        <td>:</td>
        <td><textarea name="alamat1" style="width:320px; height:80px;" id="bio_alamat1" class="detail" /><?php echo $alamat1;?></textarea></td>
    </tr>
</table>
    </fieldset>
</td>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%">
	
	<!---------------------------------------------------------  IBU KANDUNG ------------------------------------------------------------------->
	
	<tr><td><b>BioData Ibu</b></td></tr>
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik2" id="nik" size="18" maxlength="18" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik2;?>"  />
        <button type="button" name="cari_nik" id="cari_nik2" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="sktot_nama2" id="bio_nama"  size="50" class="detail" maxlength="50" value="<?php echo $sktot_nama2;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir2" id="bio_tmp_lahir"  size="20" class="detail" maxlength="20"   value="<?php echo $tmp_lahir2;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir2" id="bio_tgl_lahir"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir2;?>"  />
		</td>
    </tr>
	<tr>    
        <td>Agama</td>
        <td>:</td>
        <td><input type="text" name="aga_id2" id="bio_agama"  size="10"class="detail" maxlength="10" value="<?php echo $aga_id2;?>" /></td>
    </tr>
    
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><input type="text" name="jk2" id="bio_jk"  size="10"class="detail" maxlength="10" value="<?php echo $jk2;?>" /></td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td><input type="text" name="kew_id2" id="bio_kew"  size="10"class="detail" maxlength="10" value="<?php echo $kew_id2;?>"  /></td>
    </tr>
	<tr>    
        <td>Pekerjaan</td>
        <td>:</td>
        <td><input type="text" name="pek_id2" id="bio_pekerjaan"  size="10"class="detail" maxlength="10" value="<?php echo $pek_id2;?>" /></td>
    </tr>
	<tr>    
        <td>Alamat</td>
        <td>:</td>
        <td><textarea name="alamat2" style="width:320px; height:80px;" id="bio_alamat" class="detail" /><?php echo $alamat2;?></textarea></td>
    </tr>
	<td></td>
	<!---------------------------------------------------------  ANAK KANDUNG ------------------------------------------------------------------->
	
	<tr><td><b>BioData Anak</b></td></tr>
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik3" id="nik" size="18" maxlength="18" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik3;?>"  />
        <button type="button" name="cari_nik" id="cari_nik3" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="sktot_nama3" id="bio_nama"  size="50" class="detail" maxlength="50" value="<?php echo $sktot_nama3;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir3" id="bio_tmp_lahir"  size="20" class="detail" maxlength="20"   value="<?php echo $tmp_lahir3;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir3" id="bio_tgl_lahir"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir3;?>"  />
		</td>
    </tr>
	<tr>    
        <td>Agama</td>
        <td>:</td>
        <td><input type="text" name="aga_id3" id="bio_agama"  size="10"class="detail" maxlength="10" value="<?php echo $aga_id3;?>" /></td>
    </tr>
    
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><input type="text" name="jk3" id="bio_jk"  size="10"class="detail" maxlength="10" value="<?php echo $jk3;?>" /></td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td><input type="text" name="kew_id3" id="bio_kew"  size="10"class="detail" maxlength="10" value="<?php echo $kew_id3;?>"  /></td>
    </tr>
	<tr>    
        <td>Pekerjaan</td>
        <td>:</td>
        <td><input type="text" name="pek_id3" id="bio_pekerjaan"  size="10"class="detail" maxlength="10" value="<?php echo $pek_id3;?>" /></td>
    </tr>
	<tr>    
        <td>Alamat</td>
        <td>:</td>
        <td><textarea name="alamat3" style="width:320px; height:80px;" id="bio_alamat" class="detail" /><?php echo $alamat3;?></textarea></td>
    </tr>
	<tr>    
        <td>Tanggal Pengajuan</td>
        <td>:</td>
        <td><input type="text" name="tgl_pengajuan" id="tgl2" size="10"class="detail" maxlength="10" value="<?php echo $tgl_pengajuan;?>"/></td>
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
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
	<a href="<?php echo base_url();?>index.php/sktot/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
	</a>
    <a href="<?php echo base_url();?>index.php/cetak/sktot_pdf/<?php echo $nmr_surat; ?>" target="_blank"><button type="button" name="cetak"  class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button></a>
    <a href="<?php echo base_url();?>index.php/sktot/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-logout'">TUTUP</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>


<div id="dlg" class="easyui-dialog" title="Daftar Biodata Penduduk" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari" id="text_cari" size="50" />
	<div id="daftar_nik"></div>
</div>
<div id="dlg2" class="easyui-dialog" title="Daftar Biodata Penduduk" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari2" id="text_cari2" size="50" />
	<div id="daftar_nik2"></div>
</div>