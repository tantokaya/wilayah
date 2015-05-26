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
			url		: "<?php echo site_url(); ?>/skl/DataDetail",
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
	
//////////// NIK PERTAMA ////////////	
	$("#nik").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#nik").focus(function(e){
		var isi = $(e.target).val();
		CariNik();
	});
	
	$("#nik").keyup(function(){
		CariNik();
		
	});
	
	function CariNik(){
		var nik = $("#nik").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBiodata",
			data	: "nik="+nik,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#bio_nama").val(data.bio_nama);
				$("#bio_tmp_lahir").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir").val(data.bio_tgl_lahir);
				$("#bio_jk").val(data.bio_jk);				
				$("#bio_agama").val(data.bio_agama);
				$("#bio_kewar").val(data.bio_kew);
				$("#bio_pekerjaan").val(data.bio_pekerjaan);
				$("#bio_alamat").val(data.bio_alamat);
			}
		});
	};
	
//////////// NIK KEDUA ////////////	
	$("#nik2").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#nik2").focus(function(e){
		var isi = $(e.target).val();
		CariNik2();
	});
	
	$("#nik2").keyup(function(){
		CariNik2();
		
	});
	
	function CariNik2(){
		var nik = $("#nik2").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBiodata",
			data	: "nik="+nik,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#bio_nama2").val(data.bio_nama);
				$("#bio_tmp_lahir2").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir2").val(data.bio_tgl_lahir);
				$("#bio_jk2").val(data.bio_jk);
				$("#bio_agama2").val(data.bio_agama);
				$("#bio_kewar2").val(data.bio_kew);
				$("#bio_pekerjaan2").val(data.bio_pekerjaan);
				$("#bio_alamat2").val(data.bio_alamat);
			}
		});
	};
	
//////////// NIK KETIGA ////////////	
	$("#nik3").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#nik3").focus(function(e){
		var isi = $(e.target).val();
		CariNik3();
	});
	
	$("#nik3").keyup(function(){
		CariNik3();
		
	});
	
	function CariNik3(){
		var nik = $("#nik3").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBiodata",
			data	: "nik="+nik,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#bio_nama3").val(data.bio_nama);
				$("#bio_tmp_lahir3").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir3").val(data.bio_tgl_lahir);
				$("#bio_jk3").val(data.bio_jk);
				$("#bio_agama3").val(data.bio_agama);
				$("#bio_kewar3").val(data.bio_kew);
				$("#bio_pekerjaan3").val(data.bio_pekerjaan);
				$("#bio_alamat3").val(data.bio_alamat);
			}
		});
	};
	
	
	$("#simpan").click(function(){
		var nmr_surat	= $("#nmr_surat").val();
		var tgl		= $("#tgl").val();
		var nik		= $("#nik").val();
		
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
			url		: "<?php echo site_url(); ?>/skau/simpan",
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
		$("#nik").val('');
		$("#nik").focus();
	});

////////// CARI NIK PERTAMA ////////////	
	
	$("#cari_nik").click(function(){
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
	
///////////// CARI NIK KEDUA ////////////	
	
	$("#cari_nik2").click(function(){
		AmbilDaftarNik2();
		$("#dlg2").dialog('open');
		
	});
	
	$("#text_cari2").keyup(function(){
		AmbilDaftarNik2();
	});
	
	function AmbilDaftarNik2(){
		var cari = $("#text_cari2").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataNik2",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_nik2").html(data);
			}
		});
	}
	
///////////// CARI NIK KETIGA ////////////	
	
	$("#cari_nik3").click(function(){
		AmbilDaftarNik3();
		$("#dlg3").dialog('open');
		
	});
	
	$("#text_cari3").keyup(function(){
		AmbilDaftarNik2();
	});
	
	function AmbilDaftarNik3(){
		var cari = $("#text_cari3").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataNik3",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_nik3").html(data);
			}
		});
	}
	$("#cetak").click(function(){  
	var nmr_surat	= $("#nmr_surat").val();
	
		$.ajax({  
			url:"<?php echo site_url(); ?>/skau/checkdata",  
			data:"nmr_surat="+nmr_surat, 
			type:"POST", 
			dataType : "json",
			success:function(data){  
			if(data.success){  
				window.open('<?php echo site_url();?>/cetak/skau_pdf/'+nmr_surat);
			}else{  
			  alert('Isikan Data Terlebih Dahulu, Kemudian Simpan !');  
			}  
			return false();
		},
		async: false 
		});  
	  });  
	
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
	
	<!---------------------------------------------------------  NIK PERTAMA------------------------------------------------------------------->
   
   <tr><td><b>BioData Anak</b></td></tr>
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik1" id="nik" size="18" maxlength="16" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik1;?>"  />
        <button type="button" name="cari_nik" id="cari_nik" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skau_nama1" id="bio_nama"  size="50" class="detail" maxlength="50"  value="<?php echo $skau_nama1;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir1" id="bio_tmp_lahir"  size="20" class="detail" maxlength="20"   value="<?php echo $tmp_lahir1;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir1" id="bio_tgl_lahir"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir1;?>"   />
		</td>
    </tr>
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>
		<select name="jk1" id="bio_jk">
        <?php 
			if(empty($bio_jk)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_jk->result() as $t){
				if($jk1==$t->jk_kode){
		?>
			<option value="<?php echo $t->jk_kode;?>" selected="selected"><?php echo $t->jk_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->jk_kode;?>"><?php echo $t->jk_nama;?></option>
        <?php }
		} ?>
		</td>
	</tr>
	    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td>
		<select name="kew_id1" id="bio_kewar">
        <?php 
			if(empty($bio_kewar)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kew->result() as $t){
				if($kew_id1==$t->kew_kode){
		?>
			<option value="<?php echo $t->kew_kode;?>" selected="selected"><?php echo $t->kew_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->kew_kode;?>"><?php echo $t->kew_nama;?></option>
        <?php }
		} ?>
		</td>
    </tr>
	<tr>    
        <td>Agama</td>
        <td>:</td>
		<td>
        <select name="aga_id1" id="bio_agama">
        <?php 
			if(empty($bio_agama)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_agama->result() as $t){
				if($aga_id1==$t->aga_kode){
		?>
			<option value="<?php echo $t->aga_kode;?>" selected="selected"><?php echo $t->aga_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->aga_kode;?>"><?php echo $t->aga_nama;?></option>
        <?php }
		} ?>
        </td>
	</tr>
	<tr>    
        <td>Pekerjaan</td>
        <td>:</td>
        <td>
		<select name="pek_id1" id="bio_pekerjaan">
        <?php 
			if(empty($bio_pekerjaan)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_pekerjaan->result() as $t){
				if($pek_id1==$t->pek_kode){
		?>
			<option value="<?php echo $t->pek_kode;?>" selected="selected"><?php echo $t->pek_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->pek_kode;?>"><?php echo $t->pek_nama;?></option>
        <?php }
		} ?>
        </td>
    </tr>
	<tr>    
        <td>Alamat Ayah</td>
        <td>:</td>
        <td><textarea name="alamat1" style="width:320px; height:80px;" id="bio_alamat" class="detail" /><?php echo $alamat1;?></textarea></td>
    </tr>
	<tr>    
        <td>Tanggal Pengajuan</td>
        <td>:</td>
        <td><input type="text" name="tgl_pengajuan" id="tgl2" size="10"class="detail" maxlength="10" value="<?php echo $tgl_pengajuan;?>"/></td>
    </tr>
</table>
    </fieldset>
</td>
<td valign="top" width="50%">
    <fieldset>
    <table width="100%">
	
	<!---------------------------------------------------------  NIK KEDUA ------------------------------------------------------------------->
	
	<tr><td><b>BioData Ayah</b></td></tr>
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik2" id="nik2" size="18" maxlength="16" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik2;?>"  />
        <button type="button" name="cari_nik2" id="cari_nik2" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skau_nama2" id="bio_nama2"  size="50" class="detail" maxlength="50" value="<?php echo $skau_nama2;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir2" id="bio_tmp_lahir2"  size="20" class="detail" maxlength="20"   value="<?php echo $tmp_lahir2;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir2" id="bio_tgl_lahir2"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir2;?>"   />
		</td>
    </tr>
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>
		<select name="jk2" id="bio_jk2">
        <?php 
			if(empty($bio_jk2)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_jk->result() as $t){
				if($jk2==$t->jk_kode){
		?>
			<option value="<?php echo $t->jk_kode;?>" selected="selected"><?php echo $t->jk_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->jk_kode;?>"><?php echo $t->jk_nama;?></option>
        <?php }
		} ?>
		</td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td>
		<select name="kew_id2" id="bio_kewar2">
        <?php 
			if(empty($bio_kewar2)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kew->result() as $t){
				if($kew_id2==$t->kew_kode){
		?>
			<option value="<?php echo $t->kew_kode;?>" selected="selected"><?php echo $t->kew_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->kew_kode;?>"><?php echo $t->kew_nama;?></option>
        <?php }
		} ?>
		</td>
    </tr>
	<tr>    
        <td>Agama</td>
        <td>:</td>
        <td>
        <select name="aga_id2" id="bio_agama2">
        <?php 
			if(empty($bio_agama2)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_agama->result() as $t){
				if($aga_id2==$t->aga_kode){
		?>
			<option value="<?php echo $t->aga_kode;?>" selected="selected"><?php echo $t->aga_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->aga_kode;?>"><?php echo $t->aga_nama;?></option>
        <?php }
		} ?>
        </td>
    </tr>
	<tr>    
        <td>Pekerjaan</td>
        <td>:</td>
        <td>
		<select name="pek_id2" id="bio_pekerjaan2">
        <?php 
			if(empty($bio_pekerjaan2)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_pekerjaan->result() as $t){
				if($pek_id2==$t->pek_kode){
		?>
			<option value="<?php echo $t->pek_kode;?>" selected="selected"><?php echo $t->pek_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->pek_kode;?>"><?php echo $t->pek_nama;?></option>
        <?php }
		} ?>
        </td>
    </tr>
	<tr>    
        <td>Alamat Ayah</td>
        <td>:</td>
        <td><textarea name="alamat2" style="width:320px; height:80px;" id="bio_alamat2" class="detail" /><?php echo $alamat2;?></textarea></td>
    </tr>

	<!---------------------------------------------------------  NIK KETIGA ------------------------------------------------------------------->
	
<tr><td><b>BioData Ibu</b></td></tr>
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik3" id="nik3" size="18" maxlength="16" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik3;?>"  />
        <button type="button" name="cari_nik3" id="cari_nik3" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skau_nama3" id="bio_nama3"  size="50" class="detail" maxlength="50" value="<?php echo $skau_nama3;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir3" id="bio_tmp_lahir3"  size="20" class="detail" maxlength="20"   value="<?php echo $tmp_lahir3;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir3" id="bio_tgl_lahir3"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir3;?>"   />
		</td>
    </tr>
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>
		<select name="jk3" id="bio_jk3">
        <?php 
			if(empty($bio_jk3)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_jk->result() as $t){
				if($jk3==$t->jk_kode){
		?>
			<option value="<?php echo $t->jk_kode;?>" selected="selected"><?php echo $t->jk_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->jk_kode;?>"><?php echo $t->jk_nama;?></option>
        <?php }
		} ?>
		</td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td>
		<select name="kew_id3" id="bio_kewar3">
        <?php 
			if(empty($bio_kewar3)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kew->result() as $t){
				if($kew_id3==$t->kew_kode){
		?>
			<option value="<?php echo $t->kew_kode;?>" selected="selected"><?php echo $t->kew_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->kew_kode;?>"><?php echo $t->kew_nama;?></option>
        <?php }
		} ?>
		</td>
    </tr>
	<tr>    
        <td>Agama</td>
        <td>:</td>
        <td>
        <select name="aga_id3" id="bio_agama3">
        <?php 
			if(empty($bio_agama3)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_agama->result() as $t){
				if($aga_id3==$t->aga_kode){
		?>
			<option value="<?php echo $t->aga_kode;?>" selected="selected"><?php echo $t->aga_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->aga_kode;?>"><?php echo $t->aga_nama;?></option>
        <?php }
		} ?>
        </td>
    </tr>
	<tr>    
        <td>Pekerjaan</td>
        <td>:</td>
        <td>
		<select name="pek_id3" id="bio_pekerjaan3">
        <?php 
			if(empty($bio_pekerjaan3)){
		?>
        <option value="">-PILIH-</option>
        <?php
			}
			foreach($l_pekerjaan->result() as $t){
				if($pek_id3==$t->pek_kode){
		?>
			<option value="<?php echo $t->pek_kode;?>" selected="selected"><?php echo $t->pek_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->pek_kode;?>"><?php echo $t->pek_nama;?></option>
        <?php }
		} ?>
        </td>
    </tr>
	<tr>    
        <td>Alamat Ibu</td>
        <td>:</td>
        <td><textarea name="alamat3" style="width:320px; height:80px;" id="bio_alamat3" class="detail" /><?php echo $alamat3;?></textarea></td>
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
	<a href="<?php echo base_url();?>index.php/skau/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
	</a>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/skau/">
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
<div id="dlg3" class="easyui-dialog" title="Daftar Biodata Penduduk" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari3" id="text_cari3" size="50" />
	<div id="daftar_nik3"></div>
</div>

