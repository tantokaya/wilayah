<p>Selamat datang di menu backup <b> <?php echo $this->session->userdata('nama_lengkap');?></b> di Manajeman <b><?php echo $nama_program;?></b></p>
<br />
<?php 
if($this->session->userdata('level')=='01'){
?>
<table class="list" width="100%">
	<thead>
    <td class="btn" colspan="6" style="color:#000;"><center><b>Create Backup / Restore </b></center></td>
    </thead>
    <tr>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/backup/BackupDB"><img src="<?php echo base_url();?>asset/images/admin_.png" /><br />
        <b>Backup Database</b></a>
        </td> 
	</tr>       
</table> 

<?php } ?>