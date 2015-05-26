<script type="text/javascript">
$(document).ready(function(){
	$("#tgl_lahir").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth: true,
      	changeYear: true,
		yearRange: '1900:2050'
    });
	
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	//--------- Untuk Propinsi Mengambil Kecamatan ---------//
	//--------- START PROPINSI---------//
	$("#propinsi").change(function(){  
		AmbilPropinsi();
	});
	
	function AmbilPropinsi(){  
	var propinsi = $("#propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/biodata/propinsi",  
			data:{propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#kota").html(data);
			$("#kecamatan").html("<option value=''>-PILIH-</option>");
			$("#kelurahan").html("<option value=''>-PILIH-</option>");
			}
		});  
	}

	//--------- END PROPINSI ---------//
	
	//--------- Untuk Kota Mengambil Kecamatan ---------//
	//--------- START KOTA---------//
	$("#kota").change(function(){  
		AmbilKota();
	});

	function AmbilKota(){  
	var kota = $("#kota").val();
	var propinsi = $("#propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/biodata/kota",  
			data:{kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#kecamatan").html(data);
			$("#kelurahan").html("<option value=''>-PILIH-</option>");
			}
		});  
	}
	//--------- END KOTA---------//	
		
	//--------- Untuk Kecamatan Mengambil Kelurahan ---------//
	//--------- START KECAMATAN---------//
	$("#kecamatan").change(function(){  
		AmbilKecamatan();
	});

	function AmbilKecamatan(){  
	var kecamatan = $("#kecamatan").val();
	var kota = $("#kota").val();
	var propinsi = $("#propinsi").val();
	var nik = $("#nik").val();
		$.ajax({  
			url:"<?php echo site_url(); ?>/biodata/kecamatan",  
			data:{kecamatan: kecamatan,kota: kota,propinsi: propinsi,nik:nik},
			type:"POST", 
			success:function(data){  
			$("#kelurahan").html(data);
			}
		});  
	}
	//--------- END KECAMATAN---------//	
	
	$("#nik").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataBiodata();
	});
	
	function CariDataBiodata(){
		var nik = $("#nik").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBiodata",
			data	: "nik="+nik,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#bio_nama").val(data.bio_nama);
			}
		});
	}
	
	$("#simpan").click(function(){
		var nik		= $("#nik").val();
		var bio_nama	= $("#bio_nama").val();
		
		var string = $("#form").serialize();
		
		if(nik.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#nik").focus();
			return false();
		}
		if(bio_nama.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Biodata tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#bio_nama").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/biodata/simpan",
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
	<td width="150">NIK</td>
    <td width="5">:</td>
    <td><input type="text" name="nik" id="nik" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[2,10]'" value="<?php echo $nik;?>" /></td>
</tr>
<tr>    
	<td width="150">No Kartu Keluarga</td>
    <td width="5">:</td>
    <td><input type="text" name="no_kk" id="no_kk" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[2,10]'" value="<?php echo $no_kk;?>" /></td>
</tr>
<tr>    
	<td>Nama Lengkap</td>
    <td>:</td>
    <td><input type="text" name="bio_nama" id="bio_nama"  size="40" maxlength="40" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" value="<?php echo $bio_nama;?>"/></td>
</tr>
<tr>    
	<td>Tempat Lahir</td>
    <td>:</td>
    <td><input type="text" name="bio_tmp_lahir" id="bio_tmp_lahir"  size="25" maxlength="25" class="easyui-validatebox" data-options="required:true,validType:'length[3,25]'" value="<?php echo $bio_tmp_lahir;?>"/>
	&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Lahir
    &nbsp;&nbsp;:
    <input type="text" name="bio_tgl_lahir" id="tgl_lahir"  size="10" maxlength="10" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $bio_tgl_lahir;?>"/></td>
</tr>
<tr>    
	<td>Agama</td>
    <td>:</td>
    <td>
        <select name="bio_agama" id="agama">
        <?php 
			if(empty($agama)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_agama->result() as $t){
				if($agama==$t->aga_kode){
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
	<td>Pendidikan</td>
    <td>:</td>
    <td>
        <select name="bio_pendidikan" id="bio_pendidikan">
        <?php 
			if(empty($bio_pendidikan)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_pendidikan->result() as $t){
				if($bio_pendidikan==$t->pen_kode){
		?>
			<option value="<?php echo $t->pen_kode;?>" selected="selected"><?php echo $t->pen_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->pen_kode;?>"><?php echo $t->pen_nama;?></option>
        <?php }
		} ?>
        </select>
        </td>
</tr>
<tr>    
        <td>Jenis Kelamin</td>
        <td>:</td>
        <!--<td><input type="text" name="jk" id="bio_jk"  size="10"class="detail" maxlength="10" value="<?php echo $jk;?>"  readonly="readonly"/></td>-->
		<td>
		<select name="bio_jk" id="jns_kel">
        <?php 
			if(empty($jns_kel)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_jk->result() as $t){
				if($jns_kel==$t->jk_kode){
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
        <td>Pekerjaan</td>
        <td>:</td>
        <!--<td><input type="text" name="pek_id" id="bio_pekerjaan"  size="10"class="detail" maxlength="10" value="<?php echo $pek_id;?>" readonly="readonly"/></td>-->
		<td>
		<select name="bio_pekerjaan" id="pekerjaan">
        <?php 
			if(empty($pekerjaan)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_pek->result() as $t){
				if($pekerjaan==$t->pek_kode){
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
	<td>Status</td>
    <td>:</td>
    <td>
        <select name="bio_status" id="status">
        <?php 
			if(empty($status)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_status->result() as $t){
				if($status==$t->sta_kode){
		?>
			<option value="<?php echo $t->sta_kode;?>" selected="selected"><?php echo $t->sta_nama;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->sta_kode;?>"><?php echo $t->sta_nama;?></option>
        <?php }
		} ?>
        </select>
        </td>
</tr>
<tr>
	<td>Provinsi</td>
	<td>:</td>
	<td>
	<select name="bio_propinsi" id="propinsi" style="width:280px;">
        <?php 
			if(empty($propinsi)){
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
	<select name="bio_kecamatan" id="kecamatan" style="width:280px;">
		<?php 
			if(empty($kecamatan)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kecamatan->result() as $t){
				if($bio_kecamatan==$t->kd_kecamatan){
		?>
			<option value="<?php echo $t->kd_kecamatan;?>" selected="selected"><?php echo $t->nm_kecamatan;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->kd_kecamatan;?>"><?php echo $t->nm_kecamatan;?></option>
        <?php }
		} ?>
    </select>
	</td>
</tr>
<tr>
	<td>Kelurahan</td>
	<td>:</td>
	<td>
	<select name="bio_kelurahan" id="kelurahan" style="width:280px;">
		<?php 
			if(empty($kelurahan)){
		?>
			<option value="">-PILIH-</option>
        <?php
			}
			foreach($l_kelurahan->result() as $t){
				if($bio_kelurahan==$t->kd_kelurahan){
		?>
			<option value="<?php echo $t->kd_kelurahan;?>" selected="selected"><?php echo $t->nm_kelurahan;?></option>
			<?php }else { ?>
			<option value="<?php echo $t->kd_kelurahan;?>"><?php echo $t->nm_kelurahan;?></option>
        <?php }
		} ?>
    </select>
	</td>
</tr>
<tr>    
	<td>Alamat</td>
    <td>:</td>
    <td><textarea name="bio_alamat" id="bio_alamat" style="width:320px; height:80px;" class="easyui-validatebox"><?php echo $bio_alamat;?></textarea></td>
</tr>
<tr>    
	<td>RT / RW</td>
    <td>:</td>
    <td><input placeholder="RT" type="text" name="bio_rt" id="bio_rt"  size="5" maxlength="3" class="easyui-validatebox" data-options="required:true,validType:'length[2,3]'" value="<?php echo $bio_rt;?>"/>
	&nbsp; / &nbsp;:
    <input placeholder="RW" type="text" name="bio_rw" id="bio_rw"  size="5" maxlength="3" class="easyui-validatebox" data-options="required:true,validType:'length[2,3]'" value="<?php echo $bio_rw;?>"/>
	</td>
</tr>
<tr>    
	<td>Kode Pos</td>
    <td>:</td>
    <td>
	<input type="text" name="bio_kodepos" id="bio_kodepos"  size="10" maxlength="5" class="easyui-validatebox" data-options="required:true,validType:'length[5,5]'" value="<?php echo $bio_kodepos;?>"/>
	</td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/biodata/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/biodata/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>