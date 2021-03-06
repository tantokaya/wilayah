<script type="text/javascript">
$(document).ready(function(){
	$("#cari_tgl").datepicker({
			dateFormat:"dd-mm-yy",
			changeMonth: true,
      			changeYear: true,
			yearRange: '2000:2050'
    });
});
</script>
<div id="view">
<div style="float:left; padding-bottom:5px;">
<a href="<?php echo base_url();?>index.php/sku/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Tambah Data</button>
</a>
<a href="<?php echo base_url();?>index.php/sku">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/sku">
Tanggal <input type="text" name="cari_tgl" id="cari_tgl" size="15" />
Cari No SK & Kode NIK : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
    <th>Tanggal</th>
    <th>Nomor Surat</th>
    <th>NIK</th>
    <th>Nama </th>
	<th>Jenis Usaha </th>
	<th>Lokasi Usaha </th>
    <th>Aksi</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		$tgl = $this->app_model->tgl_indo($db['tgl_surat']);
		
		?>    
    	<tr>
			<td align="center" width="20"><?php echo $no; ?></td>
	    <td align="center" width="100" ><?php echo $tgl; ?></td>		
            <td align="center" width="100" ><?php echo $db['nomor']; ?></td>
            <td align="center" width="100" ><?php echo $db['nik']; ?></td>
            <td align="center" width="100" ><?php echo $db['sku_nama']; ?></td>
			<td align="center" width="100" ><?php echo $db['jns_usaha']; ?></td>
			<td align="center" width="100" ><?php echo $db['lok_usaha']; ?></td>
            <td align="center" width="80">
            <?php
			if($this->session->userdata('level')=='01'){
			?>
            <a href="<?php echo base_url();?>index.php/sku/edit/<?php echo $db['nmr_surat'];?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>&nbsp;&nbsp;| &nbsp;&nbsp;
            <a href="<?php echo base_url();?>index.php/sku/hapus/<?php echo $db['nmr_surat'];?>"
            onClick="return confirm('Anda yakin ingin menghapus data ini?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Hapus'>
			</a>
            <?php } ?>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="8" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>