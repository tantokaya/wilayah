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
	
	$("#bio_tgl_lahir1").datepicker({
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
	
	//$("#simpan").focus();
	
//////////// NIK CALON SUAMI ////////////

		
	$("#nik1").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#nik1").focus(function(e){
		var isi = $(e.target).val();
		CariNik();
	});
	
	$("#nik1").keyup(function(){
		CariNik();
		
	});
	
	function CariNik(){
		var nik = $("#nik1").val();
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
				$("#bio_tgl_lahir1").val(data.bio_tgl_lahir);
				$("#bio_jk1").val(data.bio_jk);
				$("#bio_kew1").val(data.bio_kew);
				$("#bio_agama1").val(data.bio_agama);
				$("#bio_pekerjaan1").val(data.bio_pekerjaan);
				$("#bio_alamat1").val(data.bio_alamat);
				$("#bio_rt1").val(data.bio_rt);
				$("#bio_rw1").val(data.bio_rw);
				$("#bio_propinsi1").val(data.bio_propinsi);
				$("#bio_kota1").html(data.bio_kota);
				$("#bio_kecamatan1").html(data.bio_kecamatan);
				$("#bio_kelurahan1").html(data.bio_kelurahan);
			}
		});
	}; 
	
//////////// NIK CALON ISTRI ////////////	
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
			url	: "<?php echo site_url(); ?>/ref_json/InfoBiodata",
			data	: "nik="+nik,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#no_kk2").val(data.no_kk);
				$("#bio_nama2").val(data.bio_nama);
				$("#bio_tmp_lahir2").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir2").val(data.bio_tgl_lahir);
				$("#bio_jk2").val(data.bio_jk);
				$("#bio_kew2").val(data.bio_kew);
				$("#bio_agama2").val(data.bio_agama);
				$("#bio_pekerjaan2").val(data.bio_pekerjaan);
				$("#bio_alamat2").val(data.bio_alamat);
				$("#bio_rt2").val(data.bio_rt);
				$("#bio_rw2").val(data.bio_rw);
				$("#bio_propinsi2").val(data.bio_propinsi);
				$("#bio_kota2").html(data.bio_kota);
				$("#bio_kecamatan2").html(data.bio_kecamatan);
				$("#bio_kelurahan2").html(data.bio_kelurahan);
				
			}
		});
	};
	

	$("#simpan").click(function(){
		var tgl		= $("#tgl").val();
		var nomor	= $("#nomor").val();
		var nik1	= $("#nik1").val();
		var nama1 = $("#bio_nama1").val();
		var tgl_lahir1 = $("#bio_tgl_lahir1").val();
		var tmp_lahir1 = $("#bio_tmp_lahir1").val();
		var jk1 = $("#bio_jk1").val();
		var kew1 = $("#bio_kew1").val();
		var agama1 = $("#bio_agama1").val();
		var pek1 = $("#bio_pekerjaan1").val();			
		var kodepos1 = $("#bio_kodepos1").val();
		var alamat1 = $("#bio_alamat1").val();
		var propinsi1 = $("#bio_propinsi1").val();
		var kota1 = $("#bio_kota1").val();
		var kecamatan1 = $("#bio_kecamatan1").val();
		var kelurahan1 = $("#bio_kelurahan1").val();
		
		var nik2	= $("#nik2").val();
		var nama2 = $("#bio_nama2").val();
		var tgl_lahir2 = $("#bio_tgl_lahir2").val();
		var tmp_lahir2 = $("#bio_tmp_lahir2").val();
		var jk2 = $("#bio_jk2").val();
		var kew2 = $("#bio_kew2").val();
		var agama2 = $("#bio_agama2").val();
		var pek2 = $("#bio_pekerjaan2").val();			
		var kodepos2 = $("#bio_kodepos2").val();
		var alamat2 = $("#bio_alamat2").val();
		var propinsi2 = $("#bio_propinsi2").val();
		var kota2 = $("#bio_kota2").val();
		var kecamatan2 = $("#bio_kecamatan2").val();
		var kelurahan2 = $("#bio_kelurahan2").val();
		
		var string = $("#form").serialize();
		
		if(nik1.length==0 || nik1.length<16){
			$.messager.alert('Info','Maaf, Kode NIK Calon Suami tidak lengkap !','warning');
			$("#nik1").focus();
			return false();
		}
		if(nama1.length==0){
			$.messager.alert('Info','Maaf, Nama Lengkap Calon Suami Belum Diisi !','warning');
			$("#bio_nama1").focus();
			return false();
		}
		if(tmp_lahir1.length==0){
			$.messager.alert('Info','Maaf, Tempat Lahir Calon Suami Belum Diisi !','warning');
			$("#bio_tmp_lahir1").focus();
			return false();
		}
		if(tgl_lahir1.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Calon Suami Belum Diisi !','warning');
			$("#bio_tgl_lahir1").focus();
			return false();
		}
		if(jk1.length1==0){
			$.messager.alert('Info','Maaf, Jenis Kelamin Calon Suami Belum di Pilih !','warning');
			$("#bio_jk1").focus();
			return false();
		}
		if(kew1.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Ayah Belum di Pilih !','warning');
			$("#bio_kew1").focus();
			return false();
		}
		if(pek1.length==0){
			$.messager.alert('Info','Maaf, Pekerjaan Calon Suami Belum di Pilih !','warning');
			$("#bio_pek1").focus();
			return false();
		}
		if(agama1.length==0){
			$.messager.alert('Info','Maaf, Agama Calon Suami Belum di Pilih !','warning');
			$("#bio_agama1").focus();
			return false();
		}
		if(propinsi1.length!=0 && kota1.length==0){
			$.messager.alert('Info','Maaf, Nama Kota Calon Suami Belum di Pilih !','warning');
			$("#bio_kota1").focus();
			return false();
		}
		if(kota1.length!=0 && kecamatan1.length==0){
			$.messager.alert('Info','Maaf, Nama Kecamatan Calon Suami Belum di Pilih !','warning');
			$("#bio_kecamatan1").focus();
			return false();
		}
		if(kecamatan1.length!=0 && kelurahan1.length==0){
			$.messager.alert('Info','Maaf, Nama Kelurahan Calon Suami Belum di Pilih !','warning');
			$("#bio_kelurahan1").focus();
			return false();
		}
		if(alamat1.length==0){
			$.messager.alert('Info','Maaf, Alamat Calon Suami Belum Diisi !','warning');
			$("#bio_alamat").focus();
			return false();
		}
		if(kodepos1.length>0 && kodepos1.length<5){
			$.messager.alert('Info','Maaf, Kodepos Calon Suami tidak lengkap !','warning');
			$("#bio_kodepos").focus();
			return false();
		}
		if(nik2.length==0 || nik2.length<16){
			$.messager.alert('Info','Maaf, Kode NIK Calon Istri tidak lengkap !','warning');
			$("#nik2").focus();
			return false();
		}
		if(nama2.length==0){
			$.messager.alert('Info','Maaf, Nama Lengkap Calon Istri Belum Diisi !','warning');
			$("#bio_nama2").focus();
			return false();
		}
		if(tmp_lahir2.length==0){
			$.messager.alert('Info','Maaf, Tempat Lahir Calon Istri Belum Diisi !','warning');
			$("#bio_tmp_lahir2").focus();
			return false();
		}
		if(tgl_lahir2.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Calon Istri Belum Diisi !','warning');
			$("#bio_tgl_lahir2").focus();
			return false();
		}
		if(jk2.length==0){
			$.messager.alert('Info','Maaf, Jenis Kelamin Calon Istri Belum di Pilih !','warning');
			$("#bio_jk2").focus();
			return false();
		}
		if(kew2.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Calon Istri Belum di Pilih !','warning');
			$("#bio_kew2").focus();
			return false();
		}
		if(pek2.length==0){
			$.messager.alert('Info','Maaf, Pekerjaan Calon Istri Belum di Pilih !','warning');
			$("#bio_pek2").focus();
			return false();
		}
		if(agama2.length==0){
			$.messager.alert('Info','Maaf, Agama Calon Istri Belum di Pilih !','warning');
			$("#bio_agama2").focus();
			return false();
		}
		if(propinsi2.length!=0 && kota2.length==0){
			$.messager.alert('Info','Maaf, Nama Kota Calon Istri Belum di Pilih !','warning');
			$("#bio_kota2").focus();
			return false();
		}
		if(kota2.length!=0 && kecamatan2.length==0){
			$.messager.alert('Info','Maaf, Nama Kecamatan Calon Istri Belum di Pilih !','warning');
			$("#bio_kecamatan2").focus();
			return false();
		}
		if(kecamatan2.length!=0 && kelurahan2.length==0){
			$.messager.alert('Info','Maaf, Nama Kelurahan Calon Istri Belum di Pilih !','warning');
			$("#bio_kelurahan2").focus();
			return false();
		}
		if(alamat2.length==0){
			$.messager.alert('Info','Maaf, Alamat Calon Istri Belum Diisi !','warning');
			$("#bio_alamat2").focus();
			return false();
		}
		if(kodepos2.length>0 && kodepos2.length<5){
			$.messager.alert('Info','Maaf, Kodepos Calon Istri tidak lengkap !','warning');
			$("#bio_kodepos2").focus();
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

		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/skpm/simpan",
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
		$("#nik1").val('');
		$("#nik1").focus();
	});

////////// CARI CALON SUAMI ////////////	
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
	/*$("#cari_nik").click(function(){
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
	}*/
	
///////////// CARI CALON ISTRI ////////////	
	
	$("#cari_nik2").click(function(){
		AmbilDaftarNik2();
		$("#dlg2").dialog('open');
		
	});
	
	$("#text_cari2").keyup(function(){
		AmbilDaftarNik2();
	});
	
	function AmbilDaftarNik2(){
		var cari2 = $("#text_cari2").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataNik2",
			data	: "cari2="+cari2,
			cache	: false,
			success	: function(data){
				$("#daftar_nik2").html(data);
			}
		});
	}

	$("#cetak").click(function(){  
	var nmr_surat	= $("#nmr_surat").val();
	
		$.ajax({  
			url:"<?php echo site_url(); ?>/skpm/checkdata",  
			data:"nmr_surat="+nmr_surat, 
			type:"POST", 
			dataType : "json",
			success:function(data){  
			if(data.success){  
				window.open('<?php echo site_url();?>/cetak/skpm_pdf/'+nmr_surat);
			}else{  
				$.messager.alert('Info','Isikan data terlebih dahulu, Kemudian Simpan !','warning');
				$("#simpan").focus();
			}  
			return false();
		},
		async: false 
		});  
	}); 

	  
	$("#bio_propinsi1").change(function(){  
		AmbilPropinsi1();
	});
	function AmbilPropinsi1(){  
	var propinsi = $("#bio_propinsi1").val();
	var nik = $("#nik1").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skpm/propinsi",  
			data:{propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kota1").html(data);
			$("#bio_kecamatan1").html("<option value=''>-PILIH-</option>");
			$("#bio_kelurahan1").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#bio_kota1").change(function(){  
		AmbilKota1();
	});

	function AmbilKota1(){  
	var kota = $("#bio_kota1").val();
	var propinsi = $("#bio_propinsi1").val();
	var nik = $("#nik1").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skpm/kota",  
			data:{kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kecamatan1").html(data);
			$("#bio_kelurahan1").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#bio_kecamatan1").change(function(){  
		AmbilKecamatan1();
	});

	function AmbilKecamatan1(){  
	var kecamatan = $("#bio_kecamatan1").val();
	var kota = $("#bio_kota1").val();
	var propinsi = $("#bio_propinsi1").val();
	var nik = $("#nik1").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skpm/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kelurahan1").html(data);
			}
		});  
	}
	$("#bio_propinsi2").change(function(){  
		AmbilPropinsi2();
	});
	function AmbilPropinsi(){  
	var propinsi = $("#bio_propinsi2").val();
	var nik = $("#nik2").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skpm/propinsi",  
			data:{propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kota2").html(data);
			$("#bio_kecamatan2").html("<option value=''>-PILIH-</option>");
			$("#bio_kelurahan2").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#bio_kota2").change(function(){  
		AmbilKota2();
	});

	function AmbilKota2(){  
	var kota = $("#bio_kota2").val();
	var propinsi = $("#bio_propinsi2").val();
	var nik = $("#nik2").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skpm/kota",  
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
	var kota = $("#bio_kota2").val();
	var propinsi = $("#bio_propinsi2").val();
	var nik = $("#nik2").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/skpm/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kelurahan2").html(data);
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
	
	<!---------------------------------------------------------  CALON SUAMI------------------------------------------------------------------->
   
   <tr><td><b>BioData Calon Suami</b></td></tr>
   
   <tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik1" id="nik1" size="18" maxlength="16" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik1;?>"  />
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
        <td><input type="text" name="skpm_nama1" id="bio_nama1"  size="50" class="detail" maxlength="50"  value="<?php echo $skpm_nama1;?>"/></td>
    </tr>
    <tr>    
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><input type="text" name="tmp_lahir1" id="bio_tmp_lahir1"  size="20" class="detail" maxlength="20"   value="<?php echo $tmp_lahir1;?>"/>
		&nbsp;&nbsp;&nbsp;&nbsp;Tgl Lahir &nbsp;&nbsp;&nbsp;&nbsp; : <input type="text" name="tgl_lahir1" id="bio_tgl_lahir1"   size="10"class="detail" maxlength="10" value="<?php echo $tgl_lahir1;?>"   />
		</td>
    </tr>
    <tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>
		<select name="jk1" id="bio_jk1">
        <?php 
			if(empty($bio_jk1)){
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
		<select name="kew_id1" id="bio_kew1">
        <?php 
			if(empty($bio_kew1)){
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
        <select name="aga_id1" id="bio_agama1">
        <?php 
			if(empty($bio_agama1)){
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
		<select name="pek_id1" id="bio_pekerjaan1">
        <?php 
			if(empty($bio_pekerjaan1)){
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
		<td>Provinsi</td>
		<td>:</td>
		<td>
		<select name="propinsi1" id="bio_propinsi1" style="width:280px;">
			<?php 
				if(empty($bio_propinsi1)){
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
		<select name="kota1" id="bio_kota1" style="width:280px;">
			<?php if(empty($bio_kota1)){ ?>
				<option value="">-PILIH-</option>
			<?
				}
				foreach($l_kota1->result() as $t){
					if($kota1==$t->kd_kota){
			?>
				<option value="<?php echo $t->kd_kota;?>" selected="selected"><?php echo $t->nm_kota;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->kd_kota;?>"><?php echo $t->nm_kota;?></option>
			<?php }} ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Kecamatan</td>
		<td>:</td>
		<td>
		<select name="kecamatan1" id="bio_kecamatan1" style="width:280px;">
			<?php 
				if(empty($bio_kecamatan1)){
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
		<select name="kelurahan1" id="bio_kelurahan1" style="width:280px;">
			<?php 
				if(empty($bio_kelurahan1)){
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
        <td>Alamat Calon Suami</td>
        <td>:</td>
        <td><textarea name="alamat1" style="width:320px; height:80px;" id="bio_alamat1" class="detail" /><?php echo $alamat1;?></textarea></td>
    </tr>
	<tr>    
	<td>RT / RW</td>
    <td>:</td>
    <td><input type="text" name="rt1" id="bio_rt1"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rt1;?>"/>
	&nbsp; / &nbsp;:
    <input type="text" name="rw1" id="bio_rw1"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rw1;?>"/>
	</td>
</tr>
<tr>    
	<td>Kode Pos</td>
    <td>:</td>
    <td>
	<input type="text" name="kodepos1" id="bio_kodepos1"  size="10" maxlength="5" class="easyui-validatebox" value="<?php echo $kodepos1;?>"/>
	</td>
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
	
	<!---------------------------------------------------------  CALON ISTRI ------------------------------------------------------------------->
	
	<tr><td><b>BioData Calon Istri</b></td></tr>
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
        <td><input type="text" name="skpm_nama2" id="bio_nama2"  size="50" class="detail" maxlength="50" value="<?php echo $skpm_nama2;?>"/></td>
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
		<select name="kew_id2" id="bio_kew2">
        <?php 
			if(empty($bio_kew2)){
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
		<td>Provinsi</td>
		<td>:</td>
		<td>
		<select name="propinsi2" id="bio_propinsi2" style="width:280px;">
			<?php 
				if(empty($bio_propinsi)){
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
		<select name="kota2" id="bio_kota2" style="width:280px;">
			<?php if(empty($bio_kota2)){ ?>
				<option value="">-PILIH-</option>
			<?
				}
				foreach($l_kota2->result() as $t){
					if($kota2==$t->kd_kota){
			?>
				<option value="<?php echo $t->kd_kota;?>" selected="selected"><?php echo $t->nm_kota;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->kd_kota;?>"><?php echo $t->nm_kota;?></option>
			<?php }} ?>
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
        <td>Alamat Calon Istri</td>
        <td>:</td>
        <td><textarea name="alamat2" style="width:320px; height:80px;" id="bio_alamat2" class="detail" /><?php echo $alamat2;?></textarea></td>
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
	<a href="<?php echo base_url();?>index.php/skpm/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
	</a>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/skpm/">
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
