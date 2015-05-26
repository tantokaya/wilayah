<?php 
if($this->session->userdata('level')=='01')

{
?>
<table class="list" width="100%">
	<thead>
    <td class="btn" colspan="6" style="color:#000;"><center><b>LAPORAN PEMBUATAN PER-SURAT KETERANGAN</b></center></td>
    </thead>
    <tr>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skdu"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Domisili Usaha</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_sku"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Usaha</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_sktt"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Tempat Tinggal</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_sktmp"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Tidak Mampu</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skpck"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Pengantar Kepolisian</b></a>
        </td>
	</tr>   
    <tr>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skbm"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Belum Menikah</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skir"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Ijin Keramaian</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skb"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Bepergian</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skk"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Kematian</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skl"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Kelahiran</b></a>
        </td>
	</tr> 
    <tr>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skbn"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Beda Nama</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_sktkt"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Tidak Keberatan Tetangga</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skun_na"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Untuk Nikah [NA]</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skpm"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Persetujuan Mempelai</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_siotm"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Ijin Orang Tua Untuk Menikah</b></a>
        </td>
	</tr> 
    <tr><td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skdk"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Daftar Keluarga</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skpnh"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Pengantar Naik Haji</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skaw"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Ahli Waris</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skppsp"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Pengantar SPPT-PBB</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skrt"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Riwayat Tanah</b></a>
        </td>
	</tr> 
    <tr>    	
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skbmr"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Belum Memiliki Rumah</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skjd"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Janda/Duda</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/lap_skptt"><img src="<?php echo base_url();?>uploads/report.png" /><br />
        <b>Laporan Surat Keterangan Penghasilan Tidak Tetap</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href=""></a>
        </td>
		<td class="btn" align="center" width="20%"><a href=""></a>
		</td>
	</tr>     
</table> 
<?php } ?>