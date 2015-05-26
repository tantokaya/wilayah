<script type="text/javascript">
$(function() {
	$("#dataTable tr:even").addClass("stripe1");
	$("#dataTable tr:odd").addClass("stripe2");
	$("#dataTable tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);
});
</script>
<style type="text/css">
.stripe1 {
    background-color:#FBEC88;
}
.stripe2 {
    background-color:#FFF;
}
.highlight {
	-moz-box-shadow: 1px 1px 2px #fff inset;
	-webkit-box-shadow: 1px 1px 2px #fff inset;
	box-shadow: 1px 1px 2px #fff inset;		  
	border:             #aaa solid 1px;
	background-color: #fece2f;
}
</style>
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
    <th>Kode SKTT</th>
	<th>Tanggal</th>
	<th>NIK</th>
    <th>Nama Lengkap</th>
    <th>Alamat</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		$tgl = $this->app_model->tgl_indo($db['tgl_pengajuan']);
		?>    
    	<tr>
			<td align="center" width="8%"><?php echo $no; ?></td>
            <td align="center" width="12%"><?php echo $db['nmr_surat']; ?></td>
            <td align="center" width="15%"><?php echo $tgl; ?></td>
			<td align="center" width="15%"><?php echo $db['nik']; ?></td>
            <td align="center" width="20%"><?php echo $db['sktt_nama']; ?></td>
            <td align="center" width="30%" ><?php echo $db['alamat']; ?></td>
        </tr>
    <?php
		$no++;
		}
	}else{
		$g_total =0;
	?>
    	<tr>
        	<td colspan="9" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}

?>
<tr>
	<td colspan="8" align="center">TOTAL <?php echo $totaldata;?></td>
</tr>    
</table>