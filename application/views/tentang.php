<p>Hai, Selamat datang <b><?php echo $this->session->userdata('nama_lengkap');?></b> di Manajeman <b><?php echo $nama_program;?></b></p>
<br />
<?php 
if($this->session->userdata('level')=='01'){
?>
<b>Developed by :</b><br/><br/>
<img src="<?php echo base_url();?>uploads/ipteknet.gif" alt="" class="img-polaroid"  width="80"/><br/><br/>
<table class="list" width="100%">
	<thead>
    <td class="btn" colspan="4" style="color:#000;"><center><b>FITUR - FITUR  :</b></center></td>
    </thead>
    <tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/monitor.png"></td><td width="25%">Tampilan Yang Mudah Untuk di gunakan</td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/custom.png"></td><td width="25%">Mudah Untuk di Kustomisasi</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/graph.png"></td><td width="25%">Memonitor Kinerja Pelayanan </td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/search.png"></td><td width="25%">Mudah Melakukan Pencarian Data</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/support.png"></td><td width="25%">Professional Developer Support Ready </td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/parent2.png"></td><td width="25%">User, Account Panel</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/report.png"></td><td width="25%">Laporan sampai dengan bentuk Dashboard </td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/teacher2.png"></td><td width="25%">Admin, Account Panel</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/domain.png"></td><td width="25%">Domain Anda, Institusi Anda </td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/ui.png"></td><td width="25%">Modern Aesthetic UI, UX</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/icon.png"></td><td width="25%">Iconic User Interface Untuk Memudahkan Akses </td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/security.png"></td><td width="25%">Top Notch Security Provided From Script</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/php.png"></td><td width="25%">Powerfull Codeigniter PHP Framework Based</td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/book.png"></td><td width="25%">Manajemen Berkas Pelayanan</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/document.png"></td><td width="25%">Dokumentasi Detail</td>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/backup.png"></td><td width="25%">Database Backup, Restore Capability</td>
	</tr>
	<tr>
		<td class="btn"  width="25%"><img src="<?php echo base_url();?>uploads/id.png"></td><td width="25%">Otomatisasi Database Penduduk</td>
	</tr>
</table><br/><br/> 
<table class="list" width="100%">
	<thead>
		<td class="btn" style="color:#000;"><center><b>SISTEM REQUIREMENTS :</b></center></td>
    </thead>
	<tr>
		<td   width="100%">- Apache server for running php</td>
	</tr>
	<tr>
		<td   width="100%">- Php curl should be enabled</td>
	</tr>
</table>
<table class="list" width="100%">
	<thead>
		<td class="btn" colspan="2" style="color:#000;"><center><b>SECURITY :</b></center></td>
    </thead>
	<tr>
		<td class="btn" width="50%"><img src="<?php echo base_url();?>uploads/security1.png"></td><td width="50%">- Highly secured agains security threats </br> - Sql-injection, xss attack, csrf protected</td>
	</tr>
	
</table>
<table class="list" width="100%">
	<thead>
		<td class="btn" colspan="2" style="color:#000;"><center><b>STABILITY :</b></center></td>
    </thead>
	<tr>
		<td class="btn" width="50%"><img src="<?php echo base_url();?>uploads/stability1.png" width="200"></td><td width="50%">- Very stable and secure database managed by IPTEKNET with automatic backup facility. So no need to hesitate </td>
	</tr>
	
</table>
<?php } ?>