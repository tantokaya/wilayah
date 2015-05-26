<div id="view">
<div style="float:left; padding-bottom:5px;">
<a href="<?php echo base_url();?>index.php/biodata/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Tambah Data</button>
</a>
<a href="<?php echo base_url();?>index.php/biodata">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/biodata">
Cari Kode NIK & Nama biodata : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
    <th>NIK</th>
	<th>Nama Lengkap</th>
	<th>Tempat Lahir</th>
	<th>Tanggal Lahir</th>
	<th>Jenis Kelamin</th>
	<th>Kelurahan</th>
	<th>Aksi</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		$tgl = $this->app_model->tgl_indo($db['bio_tgl_lahir']);
		?>    
    	<tr>
			<td align="center" width="5%"><?php echo $no; ?></td>
			<td align="center" width="10%" ><?php echo $db['nik']; ?></td>
            <td align="left" width="10%" ><?php echo $db['bio_nama']; ?></td>
			<td align="center" width="10%" ><?php echo $db['bio_tmp_lahir']; ?></td>
			<td align="center" width="10%" ><?php echo $tgl; ?></td>
			<td width="5%" align="center">
			<?php
			if($db['bio_jk']==1){echo 'L';}else{echo 'P';} 
			 
			?></td>
			<td align="center" width="10%" >
			<?php 
			foreach($this->app_model->get_kel($db['bio_kecamatan'],$db['bio_kota'],$db['bio_propinsi'])->result() as $kel)
			{
				if($db['bio_kelurahan']==$kel->kd_kelurahan)
				{echo $kel->nm_kelurahan;}
			} 
			?>
			</td>
            <td align="center" width="10%">
            <a href="<?php echo base_url();?>index.php/biodata/edit/<?php echo $db['nik'];?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a> &nbsp;&nbsp;| &nbsp;&nbsp;
            <a href="<?php echo base_url();?>index.php/biodata/hapus/<?php echo $db['nik'];?>"
            onClick="return confirm('Anda yakin ingin menghapus data ini?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Hapus'>
			</a>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="6" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>