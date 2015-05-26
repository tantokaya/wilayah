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
	
	$("#bio_tgl_lahir3").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:2050'
    });
	
	$("#simpan").focus();
	
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
				$("#bio_nama1").val(data.bio_nama);
				$("#bio_tmp_lahir1").val(data.bio_tmp_lahir);
				$("#bio_tgl_lahir1").val(data.bio_tgl_lahir);
				$("#bio_jk1").val(data.bio_jk);				
				$("#bio_agama1").val(data.bio_agama);
				$("#bio_kew1").val(data.bio_kew);
				$("#bio_pekerjaan1").val(data.bio_pekerjaan);
				$("#bio_alamat1").val(data.bio_alamat);
				$("#bio_rt1").val(data.bio_rt);
				$("#bio_rw1").val(data.bio_rw);
				$("#bio_propinsi1").val(data.bio_propinsi);
				$("#kota1").html(data.bio_kota);
				$("#bio_kecamatan1").html(data.bio_kecamatan);
				$("#bio_kelurahan1").html(data.bio_kelurahan);
				$("#bio_status").val(data.bio_status);
				$("#bio_kodepos1").val(data.bio_kodepos);

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
				$("#bio_kew2").val(data.bio_kew);
				$("#bio_pekerjaan2").val(data.bio_pekerjaan);
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
				$("#bio_kew3").val(data.bio_kew);
				$("#bio_pekerjaan3").val(data.bio_pekerjaan);
				$("#bio_alamat3").val(data.bio_alamat);
				$("#bio_rt3").val(data.bio_rt);
				$("#bio_rw3").val(data.bio_rw);
				$("#bio_propinsi3").val(data.bio_propinsi);
				$("#kota3").html(data.bio_kota);
				$("#bio_kecamatan3").html(data.bio_kecamatan);
				$("#bio_kelurahan3").html(data.bio_kelurahan);
				$("#bio_kodepos3").val(data.bio_kodepos);
			}
		});
	};
	
	
	$("#simpan").click(function(){
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
		var kota1 = $("#kota1").val();
		var kecamatan1 = $("#bio_kecamatan1").val();
		var kelurahan1 = $("#bio_kelurahan1").val();
		var status1 = $("#bio_status").val();
		var status2 = $("#status2").val();
		
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
		var kota2 = $("#kota2").val();
		var kecamatan2 = $("#bio_kecamatan2").val();
		var kelurahan2 = $("#bio_kelurahan2").val();
		
		var nik3	= $("#nik3").val();
		var nama3 = $("#bio_nama3").val();
		var tgl_lahir3 = $("#bio_tgl_lahir3").val();
		var tmp_lahir3 = $("#bio_tmp_lahir3").val();
		var jk3 = $("#bio_jk3").val();
		var kew3 = $("#bio_kew3").val();
		var agama3 = $("#bio_agama3").val();
		var pek3 = $("#bio_pekerjaan3").val();			
		var kodepos3 = $("#bio_kodepos3").val();
		var alamat3 = $("#bio_alamat3").val();
		var propinsi3 = $("#bio_propinsi3").val();
		var kota3 = $("#kota3").val();
		var kecamatan3 = $("#bio_kecamatan3").val();
		var kelurahan3 = $("#bio_kelurahan3").val();
		var ttd_jenis 	= $("#ttd_jenis").val();
		var ttd_nama 	= $("#ttd_nama").val();
		
		var string = $("#form").serialize();
		
		if(nik1.length==0 || nik1.length<16){
			$.messager.alert('Info','Maaf, Kode NIK Anak tidak lengkap !','warning');
			$("#nik1").focus();
			return false();
		}
		if(nama1.length==0){
			$.messager.alert('Info','Maaf, Nama Lengkap Anak Belum Diisi !','warning');
			$("#bio_nama1").focus();
			return false();
		}
		if(tmp_lahir1.length==0){
			$.messager.alert('Info','Maaf, Tempat Lahir Anak Belum Diisi !','warning');
			$("#bio_tmp_lahir1").focus();
			return false();
		}
		if(tgl_lahir1.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Anak Belum Diisi !','warning');
			$("#bio_tgl_lahir1").focus();
			return false();
		}
		if(jk1.length1==0){
			$.messager.alert('Info','Maaf, Jenis Kelamin Anak Belum di Pilih !','warning');
			$("#bio_jk1").focus();
			return false();
		}
		if(kew1.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Anak Belum di Pilih !','warning');
			$("#bio_kew1").focus();
			return false();
		}
		if(pek1.length==0){
			$.messager.alert('Info','Maaf, Pekerjaan Anak Belum di Pilih !','warning');
			$("#bio_pek1").focus();
			return false();
		}
		if(agama1.length==0){
			$.messager.alert('Info','Maaf, Agama Anak Belum di Pilih !','warning');
			$("#bio_agama1").focus();
			return false();
		}
		if(propinsi1.length!=0 && kota1.length==0){
			$.messager.alert('Info','Maaf, Nama Kota Anak Belum di Pilih !','warning');
			$("#bio_kota1").focus();
			return false();
		}
		if(kota1.length!=0 && kecamatan1.length==0){
			$.messager.alert('Info','Maaf, Nama Kecamatan Anak Belum di Pilih !','warning');
			$("#bio_kecamatan1").focus();
			return false();
		}
		if(kecamatan1.length!=0 && kelurahan1.length==0){
			$.messager.alert('Info','Maaf, Nama Kelurahan Anak Belum di Pilih !','warning');
			$("#bio_kelurahan1").focus();
			return false();
		}
		if(alamat1.length==0){
			$.messager.alert('Info','Maaf, Alamat Anak Belum Diisi !','warning');
			$("#bio_alamat").focus();
			return false();
		}		
		if(status1.length==0){
			$.messager.alert('Info','Maaf, Status Anak Belum Diisi !','warning');
			$("#bio_status").focus();
			return false();
		}
		if(kodepos1.length>0 && kodepos1.length<5){
			$.messager.alert('Info','Maaf, Kodepos Anak tidak lengkap !','warning');
			$("#bio_kodepos").focus();
			return false();
		}
		if(nik2.length==0 || nik2.length<16){
			$.messager.alert('Info','Maaf, Kode NIK Ayah tidak lengkap !','warning');
			$("#nik2").focus();
			return false();
		}
		if(nama2.length==0){
			$.messager.alert('Info','Maaf, Nama Lengkap Ayah Belum Diisi !','warning');
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
		if(jk2.length==0){
			$.messager.alert('Info','Maaf, Jenis Kelamin Ayah Belum di Pilih !','warning');
			$("#bio_jk2").focus();
			return false();
		}
		if(kew2.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Ayah Belum di Pilih !','warning');
			$("#bio_kew2").focus();
			return false();
		}
		if(pek2.length==0){
			$.messager.alert('Info','Maaf, Pekerjaan Ayah Belum di Pilih !','warning');
			$("#bio_pek2").focus();
			return false();
		}
		if(agama2.length==0){
			$.messager.alert('Info','Maaf, Agama Ayah Belum di Pilih !','warning');
			$("#bio_agama2").focus();
			return false();
		}
		if(propinsi2.length!=0 && kota2.length==0){
			$.messager.alert('Info','Maaf, Nama Kota Ayah Belum di Pilih !','warning');
			$("#bio_kota2").focus();
			return false();
		}
		if(kota2.length!=0 && kecamatan2.length==0){
			$.messager.alert('Info','Maaf, Nama Kecamatan Ayah Belum di Pilih !','warning');
			$("#bio_kecamatan2").focus();
			return false();
		}
		if(kecamatan2.length!=0 && kelurahan2.length==0){
			$.messager.alert('Info','Maaf, Nama Kelurahan Ayah Belum di Pilih !','warning');
			$("#bio_kelurahan2").focus();
			return false();
		}
		if(alamat2.length==0){
			$.messager.alert('Info','Maaf, Alamat Ayah Belum Diisi !','warning');
			$("#bio_alamat2").focus();
			return false();
		}
		if(kodepos2.length>0 && kodepos2.length<5){
			$.messager.alert('Info','Maaf, Kodepos Ayah tidak lengkap !','warning');
			$("#bio_kodepos2").focus();
			return false();
		}
		if(nik3.length==0 || nik3.length<16){
			$.messager.alert('Info','Maaf, Kode NIK Ibu tidak lengkap !','warning');
			$("#nik3").focus();
			return false();
		}
		if(nama3.length==0){
			$.messager.alert('Info','Maaf, Nama Lengkap Ibu Belum Diisi !','warning');
			$("#bio_nama3").focus();
			return false();
		}
		if(tmp_lahir3.length==0){
			$.messager.alert('Info','Maaf, Tempat Lahir Ibu Belum Diisi !','warning');
			$("#bio_tmp_lahir3").focus();
			return false();
		}
		if(tgl_lahir3.length==0){
			$.messager.alert('Info','Maaf, Tanggal Lahir Ibu Belum Diisi !','warning');
			$("#bio_tgl_lahir3").focus();
			return false();
		}
		if(jk3.length==0){
			$.messager.alert('Info','Maaf, Jenis Kelamin Ibu Belum di Pilih !','warning');
			$("#bio_jk3").focus();
			return false();
		}
		if(kew3.length==0){
			$.messager.alert('Info','Maaf, Kewarganegaraan Ibu Belum di Pilih !','warning');
			$("#bio_kew3").focus();
			return false();
		}
		if(pek3.length==0){
			$.messager.alert('Info','Maaf, Pekerjaan Ibu Belum di Pilih !','warning');
			$("#bio_pek3").focus();
			return false();
		}
		if(agama3.length==0){
			$.messager.alert('Info','Maaf, Agama Ibu Belum di Pilih !','warning');
			$("#bio_agama3").focus();
			return false();
		}
		if(propinsi3.length!=0 && kota3.length==0){
			$.messager.alert('Info','Maaf, Nama Kota Ibu Belum di Pilih !','warning');
			$("#bio_kota3").focus();
			return false();
		}
		if(kota3.length!=0 && kecamatan3.length==0){
			$.messager.alert('Info','Maaf, Nama Kecamatan Ibu Belum di Pilih !','warning');
			$("#bio_kecamatan3").focus();
			return false();
		}
		if(kecamatan3.length!=0 && kelurahan3.length==0){
			$.messager.alert('Info','Maaf, Nama Kelurahan Ibu Belum di Pilih !','warning');
			$("#bio_kelurahan3").focus();
			return false();
		}
		if(alamat3.length==0){
			$.messager.alert('Info','Maaf, Alamat Ibu Belum Diisi !','warning');
			$("#bio_alamat3").focus();
			return false();
		}
		if(kodepos3.length>0 && kodepos3.length<5){
			$.messager.alert('Info','Maaf, Kodepos Ibu tidak lengkap !','warning');
			$("#bio_kodepos3").focus();
			return false();
		}
		if(ttd_jenis.length!=0 && ttd_nama.length==0){
			$.messager.alert('Info','Maaf, Nama Penandatangan tidak boleh kosong !','warning');
			$("#nmr_surat").focus();
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
			url	: "<?php echo site_url(); ?>/skun_na/simpan",
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

////////// CARI NIK PERTAMA ////////////	
	
	$("#cari_nik1").click(function(){
		AmbilDaftarNik1();
		$("#dlg1").dialog('open');
		
	});
	
	$("#text_cari1").keyup(function(){
		AmbilDaftarNik1();
		
	});
	
	function AmbilDaftarNik1(){
		var cari = $("#text_cari1").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataNik1",
			data	: "cari1="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_nik1").html(data);
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
			data	: "cari2="+cari,
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
		AmbilDaftarNik3();
	});
	
	function AmbilDaftarNik3(){
		var cari = $("#text_cari3").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataNik3",
			data	: "cari3="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_nik3").html(data);
			}
		});
	}
	$("#cetak").click(function(){  
	var nmr_surat	= $("#nmr_surat").val();
	
		$.ajax({  
			url:"<?php echo site_url(); ?>/skun_na/checkdata",  
			data:"nmr_surat="+nmr_surat, 
			type:"POST", 
			dataType : "json",
			success:function(data){  
			if(data.success){  
				window.open('<?php echo site_url();?>/cetak/skun_na_pdf/'+nmr_surat);
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
			url:"<?php echo site_url(); ?>/skdu/ttd",  
			data:{ttd_jenis:ttd_jenis},
			type:"POST", 
			success:function(data){  
			$("#ttd_nama").html(data);
			}
		});  
	}
	
	  
	$("#bio_propinsi1").change(function(){  
		AmbilPropinsi1();
	});
	function AmbilPropinsi1(){  
	var propinsi = $("#bio_propinsi1").val();
	var nik = $("#nik1").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/siotm/propinsi",  
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
			url:"<?php echo site_url(); ?>/siotm/kota",  
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
			url:"<?php echo site_url(); ?>/siotm/kecamatan",  
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
			url:"<?php echo site_url(); ?>/siotm/propinsi",  
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
			url:"<?php echo site_url(); ?>/siotm/kota",  
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
			url:"<?php echo site_url(); ?>/siotm/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kelurahan2").html(data);
			}
		});  
	}
	$("#bio_propinsi3").change(function(){  
		AmbilPropinsi3();
	});
	function AmbilPropinsi3(){  
	var propinsi = $("#bio_propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/siotm/propinsi",  
			data:{propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kota3").html(data);
			$("#bio_kecamatan3").html("<option value=''>-PILIH-</option>");
			$("#bio_kelurahan3").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#bio_kota3").change(function(){  
		AmbilKota3();
	});

	function AmbilKota3(){  
	var kota = $("#bio_kota3").val();
	var propinsi = $("#bio_propinsi3").val();
	var nik = $("#nik3").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/siotm/kota",  
			data:{kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kecamatan3").html(data);
			$("#bio_kelurahan3").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	$("#bio_kecamatan3").change(function(){  
		AmbilKecamatan3();
	});

	function AmbilKecamatan3(){  
	var kecamatan = $("#bio_kecamatan3").val();
	var kota = $("#bio_kota3").val();
	var propinsi = $("#bio_propinsi3").val();
	var nik = $("#nik3").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/siotm/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#bio_kelurahan3").html(data);
			}
		});  
	}
	

});	
	$("#bio_status").change(function(){
    if( $(this).val() === "1" ||  $(this).val() === "" ||  $(this).val() === "2" ) {
         $(".is").slideUp("fast");   
    } else {
       $(".is").slideDown("fast");     
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
	
	<!---------------------------------------------------------  NIK PERTAMA------------------------------------------------------------------->
   
   <tr><td><b>BioData Anak</b></td></tr>
<tr>    
        <td width="150">Kode NIK</td>
        <td width="5">:</td>
        <td><input type="text" name="nik1" id="nik1" size="18" maxlength="16" class="easyui-validatebox" data-options="required:true,validType:'length[3,18]'" value="<?php echo $nik1;?>"  />
        <button type="button" name="cari_nik1" id="cari_nik1" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
        </td>
    </tr>
    <tr>    
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><input type="text" name="skun_na_nama1" id="bio_nama1"  size="50" class="detail" maxlength="50"  value="<?php echo $skun_na_nama1;?>"/></td>
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
        <td>Alamat Anak</td>
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
        <td>Bin / Binti</td>
        <td>:</td>
        <td><input type="text" name="bin_binti" size="30"class="detail" maxlength="30" data-options="required:true,validType:'length[3,30]'"  value="<?php echo $bin_binti;?>" /></td>
    </tr>
	<tr>    
	<td>Status</td>
    <td>:</td>
    <td>
        <select name="status1" id="bio_status">
        <?php 
			if(empty($bio_status)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_status->result() as $t){
				if($status1==$t->sta_kode){
		?>
			<option value="<?php echo $t->sta_kode;?>" selected="selected"><?php echo $t->sta_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->sta_kode;?>"><?php echo $t->sta_nama;?></option>
        <?php }
		} ?>
        </select>
        </td>
	</tr>

	<tr class="is" style="display:none;">    
        <td>Nama Istri / Suami terdahulu</td>
        <td>:</td>
        <td><input type="text" name="status2" id="status2" size="30"class="detail" maxlength="30" data-options="required:true,validType:'length[3,30]'"  value="<?php echo $status2;?>" /></td>
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
        <td><input type="text" name="skun_na_nama2" id="bio_nama2"  size="50" class="detail" maxlength="50" value="<?php echo $skun_na_nama2;?>"/></td>
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
        <td>Alamat Ayah</td>
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
        <td><input type="text" name="skun_na_nama3" id="bio_nama3"  size="50" class="detail" maxlength="50" value="<?php echo $skun_na_nama3;?>"/></td>
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
		<select name="kew_id3" id="bio_kew3">
        <?php 
			if(empty($bio_kew3)){
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
		<td>Provinsi</td>
		<td>:</td>
		<td>
		<select name="propinsi3" id="bio_propinsi3" style="width:280px;">
			<?php 
				if(empty($bio_propinsi3)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_propinsi3->result() as $t){
					if($propinsi3==$t->kd_propinsi){
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
		<select name="bio_kota3" id="kota3" style="width:280px;">
		<?php 
				if(empty($kota3)){
			?>
				<option value="">-PILIH-</option>
		<?php
				}
				foreach($l_kota3->result() as $t){
					if($bio_kota3==$t->kd_kota){
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
		<select name="kecamatan3" id="bio_kecamatan3" style="width:280px;">
			<?php 
				if(empty($bio_kecamatan3)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kecamatan3->result() as $t){
					if($kecamatan3==$t->kd_kecamatan){
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
		<select name="kelurahan3" id="bio_kelurahan3" style="width:280px;">
			<?php 
				if(empty($bio_kelurahan3)){
			?>
				<option value="">-PILIH-</option>
			<?php
				}
				foreach($l_kelurahan3->result() as $t){
					if($kelurahan3==$t->kd_kelurahan){
			?>
				<option value="<?php echo $t->kd_kelurahan;?>" selected="selected"><?php echo $t->nm_kelurahan;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->kd_kelurahan;?>"><?php echo $t->nm_kelurahan;?></option>
			<?php }} ?>
		</select>
		</td>
	</tr>
	<tr>    
        <td>Alamat Ibu</td>
        <td>:</td>
        <td><textarea name="alamat3" style="width:320px; height:80px;" id="bio_alamat3" class="detail" /><?php echo $alamat3;?></textarea></td>
    </tr>	
	<tr>    
	<td>RT / RW</td>
    <td>:</td>
    <td><input type="text" name="rt3" id="bio_rt3"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rt3;?>"/>
	&nbsp; / &nbsp;:
    <input type="text" name="rw3" id="bio_rw3"  size="5" maxlength="3" class="easyui-validatebox" value="<?php echo $rw3;?>"/>
	</td>
</tr>
<tr>    
	<td>Kode Pos</td>
    <td>:</td>
    <td>
	<input type="text" name="kodepos3" id="bio_kodepos3"  size="10" maxlength="5" class="easyui-validatebox" value="<?php echo $kodepos3;?>"/>
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
	<a href="<?php echo base_url();?>index.php/skun_na/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
	</a>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/skun_na/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-logout'">TUTUP</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>


<div id="dlg1" class="easyui-dialog" title="Daftar Biodata Penduduk" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari1" id="text_cari1" size="50" />
	<div id="daftar_nik1"></div>
</div>
<div id="dlg2" class="easyui-dialog" title="Daftar Biodata Penduduk" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari2" id="text_cari2" size="50" />
	<div id="daftar_nik2"></div>
</div>
<div id="dlg3" class="easyui-dialog" title="Daftar Biodata Penduduk" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari3" id="text_cari3" size="50" />
	<div id="daftar_nik3"></div>
</div>

