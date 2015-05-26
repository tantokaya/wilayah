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
			dateFormat:"dd-mm-yy"
    });
	$("#tgl3").datepicker({
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
	$("#bio_tgl_lahir2").datepicker({
			dateFormat:"dd-mm-yy",
			changeMonth: true,
      		changeYear: true,
			yearRange: '1900:2050'
    });
		
	$("#simpan").focus();
/* -------- NIK IBU --------- */
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
				$("#no_kk1").val(data.no_kk);
				$("#bio_nama1").val(data.bio_nama);
				$("#bio_tmp_lahir1").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir").val(data.bio_tgl_lahir);
				$("#kewar").val(data.bio_kew);
				$("#agama").val(data.bio_agama);
				$("#pekerjaan").val(data.bio_pekerjaan);
				$("#bio_alamat").val(data.bio_alamat);				
				$("#bio_rt").val(data.bio_rt);
				$("#bio_rw").val(data.bio_rw);
				$("#bio_propinsi").val(data.bio_propinsi);
				$("#kota1").html(data.bio_kota);
				$("#bio_kecamatan").html(data.bio_kecamatan);
				$("#bio_kelurahan").html(data.bio_kelurahan);
				$("#bio_kodepos").val(data.bio_kodepos);

			}
		});
	};
	
/* -------- NIK AYAH  --------- */
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
				$("#no_kk2").val(data.no_kk);
				$("#bio_nama2").val(data.bio_nama);
				$("#bio_tmp_lahir2").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir2").val(data.bio_tgl_lahir);
				$("#kewar2").val(data.bio_kew);
				$("#pekerjaan2").val(data.bio_pekerjaan);
				$("#bio_alamat2").val(data.bio_alamat);
				$("#agama2").val(data.bio_agama);
				$("#bio_alamat2").val(data.bio_alamat);
				$("#bio_rt2").val(data.bio_rt);
				$("#bio_rw2").val(data.bio_rw);
				$("#bio_propinsi2").val(data.bio_propinsi);
				$("#kota2").html(data.bio_kota);
				$("#bio_kecamatan2").html(data.bio_kecamatan);
				$("#bio_kelurahan2").html(data.bio_kelurahan);
				$("#bio_kodepos2").val(data.bio_kodepos);

			}
		});
	};
	
	$("#simpan").click(function(){
		var tgl	= $("#tgl").val();
		var nomor	= $("#nomor").val();
		var nik	= $("#nik").val();
		//var nama = $("#bio_nama").val();
		var tgl_lahir = $("#bio_tgl_lahir").val();
		//var tmp_lahir = $("#bio_tmp_lahir").val();
		var kew = $("#kewar").val();
		var agama = $("#agama").val();
		var kodepos = $("#bio_kodepos").val();
		var alamat = $("#bio_alamat").val();
		var propinsi = $("#bio_propinsi").val();
		var kota = $("#kota").val();
		var kecamatan = $("#bio_kecamatan").val();
		var kelurahan = $("#bio_kelurahan").val();
		
		var nik2 = $("#nik2").val();
		var nama2 = $("#bio_nama2").val();
		var tgl_lahir2 = $("#bio_tgl_lahir2").val();
		var tmp_lahir2 = $("#bio_tmp_lahir2").val();
		var kew2 = $("#kewar2").val();
		var agama2 = $("#agama2").val();
		var kodepos2 = $("#bio_kodepos2").val();
		var alamat2 = $("#bio_alamat2").val();
		var propinsi2 = $("#bio_propinsi2").val();
		var kota2 = $("#kota2").val();
		var kecamatan2 = $("#bio_kecamatan2").val();
		var kelurahan2 = $("#bio_kelurahan2").val();
		
		var pk = $("#pk_id").val();
		var tk = $("#tk_id").val();
		var nama3 = $("#skl_nama3").val();
		var tgl_lahir3 = $("#tgl3").val();
		var tmp_lahir3 = $("#tmp_lahir3").val();
		var jk3 = $("#jk3").val();
		var skl_kel = $("#skl_kel").val();
		var skl_kec = $("#skl_kec").val();
		var ttd_jenis = $("#ttd_jenis").val();
		var ttd_nama = $("#ttd_nama").val();
		var ttd_jenis 	= $("#ttd_jenis").val();
		var ttd_nama 	= $("#ttd_nama").val();
		
		var string = $("#form").serialize();
		
		if(nik.length==0 || nik.length<16){
			$.messager.alert('Info','Maaf, Kode NIK Ibu tidak lengkap !','warning');
			$("#nik").focus();
			return false();
		}
		// if(nama.length==0){
		// 	$.messager.alert('Info','Maaf, Nama Ibu Lengkap Belum Diisi !','warning');
		// 	$("#bio_nama").focus();
		// 	return false();
		// }
		// if(tmp_lahir.length==0){
		// 	$.messager.alert('Info','Maaf, Tempat Lahir Ibu Belum Diisi !','warning');
		// 	$("#bio_tmp_lahir").focus();
		// 	return false();
		// }
		if(tgl_lahir.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Ibu Belum Diisi !','warning');
			$("#bio_tgl_lahir").focus();
			return false();
		}
		if(kew.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Ibu Belum di Pilih !','warning');
			$("#kewar").focus();
			return false();
		}
		if(agama.length==0){
			$.messager.alert('Info','Maaf, Agama Ibu Belum di Pilih !','warning');
			$("#agama").focus();
			return false();
		}
		if(propinsi.length!=0 && kota1.length==0){
			$.messager.alert('Info','Maaf, Nama Kota Belum di Pilih !','warning');
			$("#kota1").focus();
			return false();
		}
		if(kota1.length!=0 && kecamatan.length==0){
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
			$.messager.alert('Info','Maaf, Alamat Ibu Belum Diisi !','warning');
			$("#bio_alamat").focus();
			return false();
		}
		if(kodepos.length>0 && kodepos.length<5){
			$.messager.alert('Info','Maaf, Kodepos tidak lengkap !','warning');
			$("#bio_kodepos").focus();
			return false();
		}
		if(nik2.length==0 || nik2.length<16){
			$.messager.alert('Info','Maaf, Kode NIK Ayah tidak lengkap !','warning');
			$("#nik").focus();
			return false();
		}
		if(nama2.length==0){
			$.messager.alert('Info','Maaf, Nama Ayah Lengkap Belum Diisi !','warning');
			$("#bio_nama2").focus();
			return false();
		}
		if(tmp_lahir2.length==0){
			$.messager.alert('Info','Maaf, Tempat Lahir Ayah Belum Diisi !','warning');
			$("#bio_tmp_lahir2").focus();
			return false();
		}
		if(tgl_lahir2.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Ayah Belum Diisi !','warning');
			$("#bio_tgl_lahir2").focus();
			return false();
		}
		if(kew2.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Ayah Belum di Pilih !','warning');
			$("#kewar2").focus();
			return false();
		}
		if(agama2.length==0){
			$.messager.alert('Info','Maaf, Agama Ayah Belum di Pilih !','warning');
			$("#agama2").focus();
			return false();
		}
		if(propinsi2.length!=0 && kota2.length2==0){
			$.messager.alert('Info','Maaf, Nama Kota Belum di Pilih !','warning');
			$("#kota2").focus();
			return false();
		}
		if(kota2.length!=0 && kecamatan2.length==0){
			$.messager.alert('Info','Maaf, Nama Kecamatan Belum di Pilih !','warning');
			$("#bio_kecamatan2").focus();
			return false();
		}
		if(kecamatan2.length!=0 && kelurahan2.length==0){
			$.messager.alert('Info','Maaf, Nama Kelurahan Belum di Pilih !','warning');
			$("#bio_kelurahan2").focus();
			return false();
		}
		if(alamat2.length==0){
			$.messager.alert('Info','Maaf, Alamat Ayah Belum Diisi !','warning');
			$("#bio_alamat2").focus();
			return false();
		}
		if(kodepos2.length>0 && kodepos2.length<5){
			$.messager.alert('Info','Maaf, Kodepos tidak lengkap !','warning');
			$("#bio_kodepos2").focus();
			return false();
		}
		if(ttd_jenis.length!=0 && ttd_nama.length==0){
			$.messager.alert('Info','Maaf, Nama Penandatangan tidak boleh kosong !','warning');
			$("#nmr_surat").focus();
			return false();
		}
		if(nama3.length==0){
			$.messager.alert('Info','Maaf, Nama Anak Harus Diisi !','warning');
			$("#skl_nama3").focus();
			return false();
		}
		if(tmp_lahir3.length==0){
			$.messager.alert('Info','Maaf, Tempat Lahir Anak Belum Diisi !','warning');
			$("#tmp_lahir3").focus();
			return false();
		}
		if(tgl_lahir3.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Anak Belum Diisi !','warning');
			$("#bio_tgl3").focus();
			return false();
		}
		if(jk3.length==0){
			$.messager.alert('Info','Maaf, Jenis Kelamin Anak Belum di Pilih !','warning');
			$("#jk3").focus();
			return false();
		}
		if(tk.length==0){
			$.messager.alert('Info','Maaf, Tempat Kelahiran Harus Diisi !','warning');
			$("#nmr_surat").focus();
			return false();
		}
		if(pk.length==0){
			$.messager.alert('Info','Maaf, Penolong Kelahiran Harus Diisi !','warning');
			$("#nmr_surat").focus();
			return false();
		}
		if(skl_kel.length==0){
			$.messager.alert('Info','Maaf, Kelurahan Harus Diisi !','warning');
			$("#skl_kel").focus();
			return false();
		}
		if(skl_kec.length==0){
			$.messager.alert('Info','Maaf, Kecamatan Harus Diisi !','warning');
			$("#skl_kec").focus();
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
			url		: "<?php echo site_url(); ?>/skl/simpan",
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

/* ------ CARI NIK IBU ----- */	
	
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

/* ------ CARI NIK AYAH ----- */	
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
	$("#cetak").click(function(){  
	var nmr_surat	= $("#nmr_surat").val();
	
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/checkdata",  
			data:"nmr_surat="+nmr_surat, 
			type:"POST", 
			dataType : "json",
			success:function(data){  
			if(data.success){  
				window.open('<?php echo site_url();?>/cetak/skl_pdf/'+nmr_surat);
			}else{  
				$.messager.alert('Info','Isikan data terlebih dahulu, Kemudian Simpan !','warning');
				$("#simpan").focus(); 
			}  
			return false();
		},
		async: false 
		});  
	  });  
		//--------- Untuk Nama Penandatangan ---------//
	$("#ttd_jenis").change(function(){  
		AmbilTTD();
	});
	
	function AmbilTTD(){  
	var ttd_jenis = $("#ttd_jenis").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/ttd",  
			data:{ttd_jenis:ttd_jenis},
			type:"POST", 
			success:function(data){  
			$("#ttd_nama").html(data);
			}
		});  
	}
		//##########--- Data Ibu --- #########//
	$("#bio_propinsi").change(function(){  
		AmbilPropinsi();
	});
	function AmbilPropinsi(){  
	var propinsi = $("#bio_propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/propinsi",  
			data:{propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#kota1").html(data);
			$("#bio_kecamatan").html("<option value=''>-PILIH-</option>");
			$("#bio_kelurahan").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#kota1").change(function(){  
		AmbilKota();
	});

	function AmbilKota(){  
	var kota = $("#kota1").val();
	var propinsi = $("#bio_propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/kota",  
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
	var kota = $("#kota1").val();
	var propinsi = $("#bio_propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kelurahan").html(data);
			}
		});  
	}
	//##########--- Data Ayah --- #########//
	$("#bio_propinsi2").change(function(){  
		AmbilPropinsi2();
	});
	function AmbilPropinsi2(){  
	var propinsi = $("#bio_propinsi2").val();
	var nik = $("#nik2").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/propinsi",  
			data:{propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#kota2").html(data);
			$("#bio_kecamatan2").html("<option value=''>-PILIH-</option>");
			$("#bio_kelurahan2").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#kota2").change(function(){  
		AmbilKota2();
	});

	function AmbilKota2(){  
	var kota = $("#kota2").val();
	var propinsi = $("#bio_propinsi2").val();
	var nik = $("#nik2").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/kota",  
			data:{kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kecamatan2").html(data);
			$("#bio_kelurahan2").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#bio_kecamatan2").change(function(){  
		AmbilKecamatan2();
	});

	function AmbilKecamatan2(){  
	var kecamatan = $("#bio_kecamatan2").val();
	var kota = $("#kota2").val();
	var propinsi = $("#bio_propinsi2").val();
	var nik = $("#nik2").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skl/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kelurahan2").html(data);
			}
		});  
	}

});	

	$("#drop").change(function(){
    if( $(this).val() === "LL" ||  $(this).val() === "L1" ) {
         $(".bram").slideUp("fast");   
    } else {
       $(".bram").slideDown("fast");     
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
    <tr><td><b>BioData Ibu</b></td></tr>
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
        <td><input type="text" name="no_kk1" id="no_kk1" size="18" maxlength="18" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $no_kk1;?>"  />
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skl_nama1" id="bio_nama1"  size="50" class="detail" maxlength="50" value="<?php echo $skl_nama1;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir1" id="bio_tmp_lahir1"  size="20" class="detail" maxlength="20" value="<?php echo $tmp_lahir1;?>"/></td>
    </tr>
	<tr>    
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><input type="text" name="tgl_lahir1" id="bio_tgl_lahir"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir1;?>" />
		</td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td>
		<select name="kew_id1" id="kewar">
        <?php 
			if(empty($kewar)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kew->result() as $t){
				if($kewar1==$t->kew_kode){
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
        <select name="aga_id1" id="agama">
        <?php 
			if(empty($agama)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_agama->result() as $t){
				if($agama1==$t->aga_kode){
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
		<td>Provinsi</td>
		<td>:</td>
		<td>
		<select name="propinsi1" id="bio_propinsi" style="width:280px;">
			<?php 
				if(empty($bio_propinsi)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_propinsi1->result() as $t){
					if($propinsi1==$t->kd_propinsi){
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
		<select name="bio_kota1" id="kota1" style="width:280px;">
		<?php 
				if(empty($kota1)){
			?>
				<option value="">-PILIH-</option>
		<?php
				}
				foreach($l_kota1->result() as $t){
					if($bio_kota1==$t->kd_kota){
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
		<select name="kecamatan1" id="bio_kecamatan" style="width:280px;">
			<?php 
				if(empty($bio_kecamatan)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kecamatan1->result() as $t){
					if($kecamatan1==$t->kd_kecamatan){
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
		<select name="kelurahan1" id="bio_kelurahan" style="width:280px;">
			<?php 
				if(empty($bio_kelurahan)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kelurahan1->result() as $t){
					if($kelurahan1==$t->kd_kelurahan){
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
    <td><textarea name="alamat1" id="bio_alamat" style="width:320px; height:80px;" class="easyui-validatebox"><?php echo $alamat1;?></textarea></td>
	</tr>
	<tr>    
	<td>RT / RW</td>
    <td>:</td>
    <td><input type="text" name="rt1" id="bio_rt"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rt1;?>"/>
	&nbsp; / &nbsp;:
    <input type="text" name="rw1" id="bio_rw"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rw1;?>"/>
	</td>
</tr>
<tr>    
	<td>Kode Pos</td>
    <td>:</td>
    <td>
	<input type="text" name="kodepos1" id="bio_kodepos"  size="10" maxlength="5" class="easyui-validatebox" value="<?php echo $kodepos1;?>"/>
	</td>
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
</td>
<td valign="top" width="50%">
    <fieldset class="">
    <table width="100%">
	<tr><td><b>BioData Ayah</b></td></tr>
	<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik2" id="nik2" size="18" maxlength="16" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik2;?>"  />
        <button type="button" name="cari_nik2" id="cari_nik2" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
	<tr>    
        <td width="150">No KK</td>
        <td>:</td>
        <td><input type="text" name="no_kk2" id="no_kk2" size="18" maxlength="18" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $no_kk2;?>"  />
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skl_nama2" id="bio_nama2"  size="50" class="detail" maxlength="50" value="<?php echo $skl_nama2;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir2" id="bio_tmp_lahir2"  size="20" class="detail" maxlength="20" value="<?php echo $tmp_lahir2;?>"/></td>
    </tr>
	<tr>    
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><input type="text" name="tgl_lahir2" id="bio_tgl_lahir2"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir2;?>" />
		</td>
    </tr>
    <tr>    
        <td>Kewarganegaraan</td>
        <td>:</td>
        <td>
		<select name="kew_id2" id="kewar2">
        <?php 
			if(empty($kewar)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kew->result() as $t){
				if($kewar2==$t->kew_kode){
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
        <select name="aga_id2" id="agama2">
        <?php 
			if(empty($agama)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_agama->result() as $t){
				if($agama2==$t->aga_kode){
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
		<td>Provinsi</td>
		<td>:</td>
		<td>
		<select name="propinsi2" id="bio_propinsi2" style="width:280px;">
			<?php 
				if(empty($bio_propinsi2)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_propinsi2->result() as $t){
					if($propinsi2==$t->kd_propinsi){
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
		<select name="bio_kota2" id="kota2" style="width:280px;">
		<?php 
				if(empty($kota2)){
			?>
				<option value="">-PILIH-</option>
		<?php
				}
				foreach($l_kota2->result() as $t){
					if($bio_kota2==$t->kd_kota){
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
		<select name="kecamatan2" id="bio_kecamatan2" style="width:280px;">
			<?php 
				if(empty($bio_kecamatan2)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kecamatan2->result() as $t){
					if($kecamatan2==$t->kd_kecamatan){
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
		<select name="kelurahan2" id="bio_kelurahan2" style="width:280px;">
			<?php 
				if(empty($bio_kelurahan2)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kelurahan2->result() as $t){
					if($kelurahan2==$t->kd_kelurahan){
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
    <td><textarea name="alamat2" id="bio_alamat2" style="width:320px; height:80px;" class="easyui-validatebox"><?php echo $alamat2;?></textarea></td>
	</tr>
	<tr>    
	<td>RT / RW</td>
    <td>:</td>
    <td><input type="text" name="rt2" id="bio_rt2"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rt2;?>"/>
	&nbsp; / &nbsp;:
    <input type="text" name="rw2" id="bio_rw2"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rw2;?>"/>
	</td>
</tr>
<tr>    
	<td>Kode Pos</td>
    <td>:</td>
    <td>
	<input type="text" name="kodepos2" id="bio_kodepos2"  size="10" maxlength="5" class="easyui-validatebox" value="<?php echo $kodepos2;?>"/>
	</td>
</tr>	
	<tr><td><b>BioData Anak</b></td></tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skl_nama3" id="skl_nama3"  size="50" class="detail" maxlength="50" value="<?php echo $skl_nama3;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir3" id="tmp_lahir3"  size="20" class="detail" maxlength="20" value="<?php echo $tmp_lahir3;?>"/></td>
    </tr>
	<tr>    
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><input type="text" name="tgl_lahir3" id="tgl3"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir3;?>"/>
		</td>
    </tr>
	<tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>
		<select name="jk3" id="jk3">
        <?php 
			if(empty($jk3)){
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
        </select>
		</td>
    </tr>
    <tr>    
        <td>Kelahiran</td>
        <td>:</td>
        <td>
		<select name="lahir_id" id="drop"  >
        <?php 
			if(empty($lahir_id)){
		?>
			<option value="LL">-PILIH-</option>
        <?php
			}
			foreach($l_lahir->result() as $t){
				if($lahir_id==$t->lahir_kode){
		?>
			<option value="<?php echo $t->lahir_kode;?>" selected="selected"><?php echo $t->lahir_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->lahir_kode;?>"><?php echo $t->lahir_nama;?></option>
        <?php }
		} ?>
        </select>
		</td>
    </tr>
	<tr class="bram" style="display:none;">    
        <td>Jika kembar, anak ini lahir yang ke- </td>
        <td>:</td>
        <td><input type="text" name="skl_kembar" id="skl_kembar" size="10" class="detail" maxlength="8" value="<?php echo $skl_kembar;?>"/></td>
    </tr>
	<tr>    
        <td>Tempat Kelahiran</td>
        <td>:</td>
        <td>
        <select name="tk_id" id="tk_id">
        <?php 
			if(empty($tk_id)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_tklahir->result() as $t){
				if($tk_id==$t->tk_kode){
		?>
			<option value="<?php echo $t->tk_kode;?>" selected="selected"><?php echo $t->tk_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->tk_kode;?>"><?php echo $t->tk_nama;?></option>
        <?php }
		} ?>
        </select>
        </td>
    </tr>
	<tr>    
        <td>Kelurahan</td>
        <td>:</td>
        <td><input type="text" name="skl_kel" id="skl_kel"  size="20" class="detail" maxlength="20" value="<?php echo $skl_kel;?>"/></td>
    </tr>
	<tr>    
        <td>Kecamatan</td>
        <td>:</td>
        <td><input type="text" name="skl_kec" id="skl_kec"  size="20" class="detail" maxlength="20" value="<?php echo $skl_kec;?>"/></td>
    </tr>
	<tr>    
        <td>Penolong Kelahiran</td>
        <td>:</td>
        <td>
        <select name="pk_id" id="pk_id">
        <?php 
			if(empty($pk_id)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_pklahir->result() as $t){
				if($pk_id==$t->pk_kode){
		?>
			<option value="<?php echo $t->pk_kode;?>" selected="selected"><?php echo $t->pk_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->pk_kode;?>"><?php echo $t->pk_nama;?></option>
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
	<input type="hidden" value="<?php echo $nmr_surat;?>">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
	<a href="<?php echo base_url();?>index.php/skl/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
	</a>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/skl/">
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