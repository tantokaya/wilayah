<script type="text/javascript">
$(function() {
	$("#dataTable.detail tr:even").addClass("stripe1");
	$("#dataTable.detail tr:odd").addClass("stripe2");
	$("#dataTable.detail tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);
});
function pilih(id){
	$("#dlg").dialog('close');
	$("#nik").val(id);
	$("#nik").focus();
	
}
</script>
<table id="dataTable" class="detail" width="100%">
<tr>
	<th>No</th>
    <th>Kode NIK</th>
    <th>Nama Lengkap</th>
	<th>JK</th>
    <th>Tempat Lahir</th>
    <th>Tanggal Lahir</th>
    <th>Pilih</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
			<td align="center" width="20"><?php echo $no; ?></td>
            <td align="center" width="100" ><?php echo $db['nik']; ?></td>
            <td width="100"><?php echo $db['bio_nama']; ?></td>
			<td width="10"><?php echo $db['bio_jk']; ?></td>
            <td align="left" width="80" ><?php echo $db['bio_tmp_lahir']; ?></td>
            <td align="right" width="20" ><?php echo $db['bio_tgl_lahir']; ?></td>
            <td align="center" width="80">
            <a href="javascript:pilih('<?php echo $db['nik'];?>')" >
        	<img src="<?php echo base_url();?>asset/images/add.png" title='Ambil'>
        	</a>
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