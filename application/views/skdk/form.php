<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	$("#tgl2").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	
	$("#bio_tgl_lahir").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	$("#tgl1").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	$("#tgl2").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	$("#tgl3").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	$("#tgl4").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	$("#tgl5").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	$("#tgl6").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	
	$("#simpan").focus();
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
				$("#no_kk").val(data.no_kk);
				$("#bio_nama").val(data.bio_nama);
				$("#bio_tmp_lahir").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir").val(data.bio_tgl_lahir);
				$("#bio_jk").val(data.bio_jk);
				$("#bio_agama").val(data.bio_agama);
				$("#bio_kew").val(data.bio_kew);
				$("#bio_pekerjaan").val(data.bio_pekerjaan);
				$("#bio_alamat").val(data.bio_alamat);
				$("#bio_rt").val(data.bio_rt);
				$("#bio_rw").val(data.bio_rw);
				$("#bio_propinsi").val(data.bio_propinsi);
				$("#kota").html(data.bio_kota);
				$("#bio_kecamatan").html(data.bio_kecamatan);
				$("#bio_kelurahan").html(data.bio_kelurahan);
				$("#bio_kodepos").val(data.bio_kodepos);

			}
		});
	};
	
	$("#simpan").click(function(){
		var nomor = $("#nomor").val();
		var tgl = $("#tgl").val();
		var nik	= $("#nik").val();
		var nama = $("#bio_nama").val();
		var tgl_lahir = $("#bio_tgl_lahir").val();
		var tmp_lahir = $("#bio_tmp_lahir").val();
		var jk = $("#bio_jk").val();
		var kew = $("#bio_kew").val();
		var agama = $("#bio_agama").val();
		var pek = $("#bio_pekerjaan").val();			
		var ttd_jenis = $("#ttd_jenis").val();
		var ttd_nama = $("#ttd_nama").val();
		
		var kodepos = $("#bio_kodepos").val();
		var alamat = $("#bio_alamat").val();
		var propinsi = $("#bio_propinsi").val();
		var kota = $("#kota").val();
		var kecamatan = $("#bio_kecamatan").val();
		var kelurahan = $("#bio_kelurahan").val();
		
		var nm1 = $("#nm1").val();
		var tgl1 = $("#tgl1").val();
		var tmp1 = $("#tmp1").val();
		var hub1 = $("#hub1").val();
		var ket1 = $("#ket1").val();
		var ttd_jenis 	= $("#ttd_jenis").val();
		var ttd_nama 	= $("#ttd_nama").val();
		
		var string = $("#form").serialize();
		
		if(nik.length==0 || nik.length<16){
			$.messager.alert('Info','Maaf, Kode NIK tidak lengkap !','warning');
			$("#nik").focus();
			return false();
		}
		if(nama.length==0){
			$.messager.alert('Info','Maaf, Nama Lengkap Belum Diisi !','warning');
			$("#bio_nama").focus();
			return false();
		}
		if(tmp_lahir.length==0){
			$.messager.alert('Info','Maaf, Tempat Lahir Belum Diisi !','warning');
			$("#bio_tmp_lahir").focus();
			return false();
		}
		if(tgl_lahir.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Belum Diisi !','warning');
			$("#bio_tgl_lahir").focus();
			return false();
		}
		if(jk.length==0){
			$.messager.alert('Info','Maaf, Jenis Kelamin Belum di Pilih !','warning');
			$("#bio_jk").focus();
			return false();
		}
		if(kew.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Belum di Pilih !','warning');
			$("#bio_kew").focus();
			return false();
		}
		if(pek.length==0){
			$.messager.alert('Info','Maaf, Pekerjaan Belum di Pilih !','warning');
			$("#bio_pek").focus();
			return false();
		}
		if(agama.length==0){
			$.messager.alert('Info','Maaf, Agama Belum di Pilih !','warning');
			$("#bio_agama").focus();
			return false();
		}
		if(propinsi.length!=0 && kota.length==0){
			$.messager.alert('Info','Maaf, Nama Kota Belum di Pilih !','warning');
			$("#kota").focus();
			return false();
		}
		if(kota.length!=0 && kecamatan.length==0){
			$.messager.alert('Info','Maaf, Nama Kecamatan Belum di Pilih !','warning');
			$("#bio_kecamatan").focus();
			return false();
		}
		if(kecamatan.length!=0 && kelurahan.length==0){
			$.messager.alert('Info','Maaf, Nama Kelurahan Belum di Pilih !','warning');
			$("#bio_kelurahan").focus();
			return false();
		}
		if(alamat.length==0){
			$.messager.alert('Info','Maaf, Alamat Belum Diisi !','warning');
			$("#bio_alamat").focus();
			return false();
		}
		if(kodepos.length>0 && kodepos.length<5){
			$.messager.alert('Info','Maaf, Kodepos tidak lengkap !','warning');
			$("#bio_kodepos").focus();
			return false();
		}
		if(ttd_jenis.length!=0 && ttd_nama.length==0){
			$.messager.alert('Info','Maaf, Nama Penandatangan tidak boleh kosong !','warning');
			$("#ttd_nama").focus();
			return false();
		}
		if(tgl.length==0){
			$.messager.alert('Info','Maaf, Tanggal tidak boleh kosong !','warning');
			$("#tgl").focus();
			return false();
		}
		if(nomor.length==0){
			$.messager.alert('Info','Maaf, Nomor tidak boleh kosong !','warning');
			$("#nomor").focus();
			return false();
		}
		if(nm1.length==0){
			$.messager.alert('Info','Maaf, Nama Tanggungan Belum Diisi !','warning');
			$("#nm1").focus();
			return false();
		}
		if(tmp1.length==0){
			$.messager.alert('Info','Maaf, Tempat Belum Diisi !','warning');
			$("#tmp1").focus();
			return false();
		}
		if(tgl1.length==0){
			$.messager.alert('Info','Maaf, Tanggal Belum Diisi !','warning');
			$("#tgl1").focus();
			return false();
		}
		if(hub1.length==0){
			$.messager.alert('Info','Maaf, Hubungan Belum Diisi !','warning');
			$("#hub1").focus();
			return false();
		}
		if(ket1.length==0){
			$.messager.alert('Info','Maaf, Keterangan Belum Diisi !','warning');
			$("#ket1").focus();
			return false();
		}
		if(ttd_jenis.length==0){
			$.messager.alert('Info','Maaf, Penandatangan tidak boleh kosong !','warning');
			$("#nomor").focus();
			return false();
		}
		if(ttd_nama.length==0){
			$.messager.alert('Info','Maaf, Nama Penandatangan tidak boleh kosong !','warning');
			$("#nomor").focus();
			return false();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/skdk/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				$("#nmr_surat").val(data.substring(44, 54));
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

	$("#cari_nik").click(function(){
		AmbilDaftarNik();
		$("#dlg").dialog('open');		
	});
	
	$("#text_cari").keyup(function(){
		AmbilDaftarNik();
		
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

	$("#ttd_jenis").change(function(){  
		AmbilTTD();
	});
	
	function AmbilTTD(){  
	var ttd_jenis = $("#ttd_jenis").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skdk/ttd",  
			data:{ttd_jenis:ttd_jenis},
			type:"POST", 
			success:function(data){  
			$("#ttd_nama").html(data);
			}
		});  
	}
	$("#cetak").click(function(){  
	var nmr_surat	= $("#nmr_surat").val();
	
		$.ajax({  
			url:"<?php echo site_url(); ?>/skdk/checkdata",  
			data:"nmr_surat="+nmr_surat, 
			type:"POST", 
			dataType : "json",
			success:function(data){  
			if(data.success){  
				window.open('<?php echo site_url();?>/cetak/skdk_pdf/'+nmr_surat);
			}else{  
				$.messager.alert('Info','Isikan data terlebih dahulu, Kemudian Simpan !','warning');
				$("#simpan").focus();
			}  
			return false();
		},
		async: false 
		});  
	  });  
	  
	$("#bio_propinsi").change(function(){  
		AmbilPropinsi();
	});
	function AmbilPropinsi(){  
	var propinsi = $("#bio_propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skdk/propinsi",  
			data:{propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#kota").html(data);
			$("#bio_kecamatan").html("<option value=''>-PILIH-</option>");
			$("#bio_kelurahan").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#kota").change(function(){  
		AmbilKota();
	});

	function AmbilKota(){  
	var kota = $("#kota").val();
	var propinsi = $("#bio_propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skdk/kota",  
			data:{kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kecamatan").html(data);
			$("#bio_kelurahan").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#bio_kecamatan").change(function(){  
		AmbilKecamatan();
	});

	function AmbilKecamatan(){  
	var kecamatan = $("#bio_kecamatan").val();
	var kota = $("#kota").val();
	var propinsi = $("#bio_propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skdk/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kelurahan").html(data);
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
    <tr><?php if($this->uri->segment(2)=='edit'){?>    
        <!--<td width="150">Nomor</td>
        <td width="5">:</td>-->
        <td><input  style="display:none;" type="text" name="nmr_surat" id="nmr_surat" size="15" maxlength="15" class="easyui-validatebox" data-options="required:true,validType:'length[3,15]'" value="<?php echo $nmr_surat;?>"  /></td>
		<?php }?>
		<td><input style="display:none;" type="text" name="nmr_surat" id="nmr_surat" size="15" maxlength="15" class="easyui-validatebox" data-options="required:true,validType:'length[3,15]'" value="<?php echo $nmr_surat;?>"  /></td>
	</tr>
    <tr>    
        <td width="150">Nomor Surat</td>
        <td>:</td>
        <td><input type="text" name="nomor" id="nomor" size="18" maxlength="18" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nomor;?>"  />
        </td>
    </tr>
    <tr>    
        <td>Tanggal Surat</td>
        <td>:</td>
        <td><input readonly type="text" name="tgl_surat" id="tgl"  size="10" maxlength="10" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $tgl_surat;?>"/></td>
    </tr>
    
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik" id="nik" size="18" maxlength="16" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik;?>"  />
        <button type="button" name="cari_nik" id="cari_nik" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
	<tr>    
        <td width="150">No KK</td>
        <td>:</td>
        <td><input type="text" name="no_kk" id="no_kk" size="18" maxlength="18" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $no_kk;?>"  />
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skdk_nama" id="bio_nama"  size="50" class="detail" maxlength="50" value="<?php echo $skdk_nama;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir" id="bio_tmp_lahir"  size="20" class="detail" maxlength="20" value="<?php echo $tmp_lahir;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir" id="bio_tgl_lahir"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir;?>" />
		</td>
    </tr>
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>
		<select name="jk" id="bio_jk">
        <?php 
			if(empty($bio_jk)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_jk->result() as $t){
				if($jk==$t->jk_kode){
		?>
			<option value="<?php echo $t->jk_kode;?>" selected="selected"><?php echo $t->jk_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->jk_kode;?>"><?php echo $t->jk_nama;?></option>
        <?php }
		} ?>
        </select>
		</td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td>
		<select name="kew_id" id="bio_kew">
        <?php 
			if(empty($bio_kew)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kew->result() as $t){
				if($kew_id==$t->kew_kode){
		?>
			<option value="<?php echo $t->kew_kode;?>" selected="selected"><?php echo $t->kew_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->kew_kode;?>"><?php echo $t->kew_nama;?></option>
        <?php }
		} ?>
        </select>
		</td>
    </tr>
	<tr>    
        <td>Agama</td>
        <td>:</td>
       <td>
        <select name="aga_id" id="bio_agama">
        <?php 
			if(empty($bio_agama)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_agama->result() as $t){
				if($aga_id==$t->aga_kode){
		?>
			<option value="<?php echo $t->aga_kode;?>" selected="selected"><?php echo $t->aga_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->aga_kode;?>"><?php echo $t->aga_nama;?></option>
        <?php }
		} ?>
        </select>
        </td>
    </tr>
	<tr>    
        <td>Pekerjaan</td>
        <td>:</td>
       <td>
		<select name="pek_id" id="bio_pekerjaan">
        <?php 
			if(empty($bio_pekerjaan)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_pekerjaan->result() as $t){
				if($pek_id==$t->pek_kode){
		?>
			<option value="<?php echo $t->pek_kode;?>" selected="selected"><?php echo $t->pek_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->pek_kode;?>"><?php echo $t->pek_nama;?></option>
        <?php }
		} ?>
        </select>
		</td>
    </tr>
	<tr>
		<td>Provinsi</td>
		<td>:</td>
		<td>
		<select name="propinsi" id="bio_propinsi" style="width:280px;">
			<?php 
				if(empty($bio_propinsi)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_propinsi->result() as $t){
					if($propinsi==$t->kd_propinsi){
			?>
				<option value="<?php echo $t->kd_propinsi;?>" selected="selected"><?php echo $t->nm_propinsi;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->kd_propinsi;?>"><?php echo $t->nm_propinsi;?></option>
			<?php }
			} ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Kabupaten / Kota</td>
		<td>:</td>
		<td>
		<select name="bio_kota" id="kota" style="width:280px;">
		<?php 
				if(empty($kota)){
			?>
				<option value="">-PILIH-</option>
		<?php
				}
				foreach($l_kota->result() as $t){
					if($bio_kota==$t->kd_kota){
			?>
				<option value="<?php echo $t->kd_kota;?>" selected="selected"><?php echo $t->nm_kota;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->kd_kota;?>"><?php echo $t->nm_kota;?></option>
		<?php }
			} ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Kecamatan</td>
		<td>:</td>
		<td>
		<select name="kecamatan" id="bio_kecamatan" style="width:280px;">
			<?php 
				if(empty($bio_kecamatan)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kecamatan->result() as $t){
					if($kecamatan==$t->kd_kecamatan){
			?>
				<option value="<?php echo $t->kd_kecamatan;?>" selected="selected"><?php echo $t->nm_kecamatan;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->kd_kecamatan;?>"><?php echo $t->nm_kecamatan;?></option>
			<?php }} ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Kelurahan</td>
		<td>:</td>
		<td>
		<select name="kelurahan" id="bio_kelurahan" style="width:280px;">
			<?php 
				if(empty($bio_kelurahan)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kelurahan->result() as $t){
					if($kelurahan==$t->kd_kelurahan){
			?>
				<option value="<?php echo $t->kd_kelurahan;?>" selected="selected"><?php echo $t->nm_kelurahan;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->kd_kelurahan;?>"><?php echo $t->nm_kelurahan;?></option>
			<?php }} ?>
		</select>
		</td>
	</tr>
	<tr>    
        <td>Alamat</td>
        <td>:</td>
        <td><textarea name="alamat" style="width:320px; height:80px;" id="bio_alamat"  class="detail" /><?php echo $alamat;?></textarea></td>
    </tr>
<tr>    
	<td>RT / RW</td>
    <td>:</td>
    <td><input type="text" name="rt" id="bio_rt"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rt;?>"/>
	&nbsp; / &nbsp;:
    <input type="text" name="rw" id="bio_rw"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rw;?>"/>
	</td>
</tr>
<tr>    
	<td>Kode Pos</td>
    <td>:</td>
    <td>
	<input type="text" name="kodepos" id="bio_kodepos"  size="10" maxlength="5" class="easyui-validatebox" value="<?php echo $kodepos;?>"/>
	</td>
</tr>
<tr>    
        <td>Digunakan Untuk Keperluan</td>
        <td>:</td>
        <td><textarea name="keperluan" style="width:320px; height:80px;" id="keperluan"  class="detail" /><?php echo $keperluan;?></textarea></td>
    </tr>
<tr>
		<td colspan="3"><br><strong>Keterangan Tanggungan : </strong></td>
	</tr>
	<tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="nm1" id="nm1"  size="30" class="detail" maxlength="50" value="<?php echo $nm1;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp1" id="tmp1"  size="12" class="detail" maxlength="20" value="<?php echo $tmp1;?>"/>
		&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp; : <input type="text" name="tgl1" id="tgl1" size="8" class="detail" maxlength="10" value="<?php echo $tgl1;?>" />
		</td>
    </tr>
	<tr>    
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td><input type="text" name="hub1" id="hub1"  size="30" class="detail" maxlength="50" value="<?php echo $hub1;?>"/></td>
    </tr>
	<tr>    
        <td>Keterangan</td>
        <td>:</td>
        <td><textarea name="ket1" style="width:320px; height:80px;" id="ket1"  class="detail" /><?php echo $ket1;?></textarea></td>
    </tr>
	<tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="nm2" id="nm2"  size="30" class="detail" maxlength="50" value="<?php echo $nm2;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp2" id="tmp2"  size="12" class="detail" maxlength="20" value="<?php echo $tmp2;?>"/>
		&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp; : <input type="text" name="tgl2" id="tgl2" size="8" class="detail" maxlength="10" value="<?php echo $tgl2;?>" />
		</td>
    </tr>
	<tr>    
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td><input type="text" name="hub2" id="hub2"  size="30" class="detail" maxlength="50" value="<?php echo $hub2;?>"/></td>
    </tr>
	<tr>    
        <td>Keterangan</td>
        <td>:</td>
        <td><textarea name="ket2" style="width:320px; height:80px;" id="ket2"  class="detail" /><?php echo $ket2;?></textarea></td>
    </tr>
	
</table>
    </fieldset>
</td>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%">
	<tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="nm3" id="nm3"  size="30" class="detail" maxlength="50" value="<?php echo $nm3;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp3" id="tmp3"  size="12" class="detail" maxlength="20" value="<?php echo $tmp3;?>"/>
		&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp; : <input type="text" name="tgl3" id="tgl3" size="8" class="detail" maxlength="10" value="<?php echo $tgl3;?>" />
		</td>
    </tr>
	<tr>    
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td><input type="text" name="hub3" id="hub3"  size="30" class="detail" maxlength="50" value="<?php echo $hub3;?>"/></td>
    </tr>
	<tr>    
        <td>Keterangan</td>
        <td>:</td>
        <td><textarea name="ket3" style="width:320px; height:80px;" id="ket3"  class="detail" /><?php echo $ket3;?></textarea></td>
    </tr>
	<tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="nm4" id="nm4"  size="30" class="detail" maxlength="50" value="<?php echo $nm4;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp4" id="tmp4"  size="12" class="detail" maxlength="20" value="<?php echo $tmp4;?>"/>
		&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp; : <input type="text" name="tgl4" id="tgl4" size="8" class="detail" maxlength="10" value="<?php echo $tgl4;?>" />
		</td>
    </tr>
	<tr>    
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td><input type="text" name="hub4" id="hub4"  size="30" class="detail" maxlength="50" value="<?php echo $hub4;?>"/></td>
    </tr>
	<tr>    
        <td>Keterangan</td>
        <td>:</td>
        <td><textarea name="ket4" style="width:320px; height:80px;" id="ket4"  class="detail" /><?php echo $ket4;?></textarea></td>
    </tr>
	<tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="nm5" id="nm5"  size="30" class="detail" maxlength="50" value="<?php echo $nm5;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp5" id="tmp5"  size="12" class="detail" maxlength="20" value="<?php echo $tmp5;?>"/>
		&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp; : <input type="text" name="tgl5" id="tgl5" size="8" class="detail" maxlength="10" value="<?php echo $tgl5;?>" />
		</td>
    </tr>
	<tr>    
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td><input type="text" name="hub5" id="hub5"  size="30" class="detail" maxlength="50" value="<?php echo $hub5;?>"/></td>
    </tr>
	<tr>    
        <td>Keterangan</td>
        <td>:</td>
        <td><textarea name="ket5" style="width:320px; height:80px;" id="ket5"  class="detail" /><?php echo $ket5;?></textarea></td>
    </tr>
	<tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="nm6" id="nm6"  size="30" class="detail" maxlength="50" value="<?php echo $nm6;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp6" id="tmp6"  size="12" class="detail" maxlength="20" value="<?php echo $tmp6;?>"/>
		&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp; : <input type="text" name="tgl6" id="tgl6" size="8" class="detail" maxlength="10" value="<?php echo $tgl6;?>" />
		</td>
    </tr>
	<tr>    
        <td>Hubungan Keluarga</td>
        <td>:</td>
        <td><input type="text" name="hub6" id="hub6"  size="30" class="detail" maxlength="50" value="<?php echo $hub6;?>"/></td>
    </tr>
	<tr>    
        <td>Keterangan</td>
        <td>:</td>
        <td><textarea name="ket6" style="width:320px; height:80px;" id="ket6"  class="detail" /><?php echo $ket6;?></textarea></td>
    </tr>
	<tr>    
        <td>Tanggal Pengajuan</td>
        <td>:</td>
        <td><input type="text" name="tgl_pengajuan" id="tgl2" size="10"class="detail" maxlength="10" value="<?php echo $tgl_pengajuan;?>"/></td>
    </tr>
	  <tr>    
        <td>Penandatangan</td>
        <td>:</td>
        <td>
		<select name="ttd_jenis" id="ttd_jenis" style="width:100px;">
			<option value="">-PILIH-</option>
			<option value="1" <?php if($ttd_jenis=='1'){echo "selected='selected'";}?>>LURAH</option>
			<option value="2"<?php if($ttd_jenis=='2'){echo "selected='selected'";}?>>An.LURAH</option>
        </select>
		</td>
    </tr>
   <tr>    
        <td>Nama Penandatangan</td>
        <td>:</td>
        <td>
		<select name="ttd_kode" id="ttd_nama" style="width:180px;">
		<?php 
			if(empty($ttd_nama)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_ttd_nama->result() as $t){
				if($ttd_kode==$t->ttd_kode){
		?>
			<option value="<?php echo $t->ttd_kode;?>" selected="selected"><?php echo $t->ttd_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->ttd_kode;?>"><?php echo $t->ttd_nama;?></option>
        <?php }
		} ?>
        </select>
		</td>
    </tr>
    </table>
    </fieldset>
</tr>
</table>    
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
	<a href="<?php echo base_url();?>index.php/skdk/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
	</a>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/skdk/">
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