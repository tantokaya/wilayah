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
    <th>Kode NIK</th>
    <th>Nama Lengkap</th>
    <th>Tempat Lahir</th>
    <th>Tgl Lahir</th>
    <th>Alamat</th>
    <th>P/L</th>
    <th>Pekerjaan</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		$tgl = $this->load->app_model->tgl_indo($db['bio_tgl_lahir']);
		?>    
    	<tr>
			<td align="center" width="20"><?php echo $no; ?></td>
            <td align="center" width="30" ><?php echo $db['nik']; ?></td>
            <td width="100" ><?php echo $db['bio_nama']; ?></td>
            <td align="center" width="80" ><?php echo $db['bio_tmp_lahir']; ?></td>
            <td align="center" width="80" ><?php echo $tgl; ?></td>
            <td align="center" width="100" ><?php echo $db['bio_alamat']; ?></td>
            <td align="center" width="40" >
			<?php 
			if($db['bio_jk']=='1'){ echo 'L';}else{echo 'P';} ?>
			</td>
            <td align="center" width="60" >
			<?php foreach($l_pek->result() as $t){
					if($db['bio_pekerjaan']==$t->pek_kode){
						echo $t->pek_nama;
					}
				}
			?>
			</td>
            
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="7" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
