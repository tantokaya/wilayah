<?php 
if($this->session->userdata('level')=='01')

{
?>
<table class="list" width="100%">
	<thead>
    <td class="btn" colspan="6" style="color:#000;"><center><b>JENIS SURAT KETERANGAN</b></center></td>
    </thead>
    <tr>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skdu"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Domisili Usaha</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/sku"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Usaha</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/sktt"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Tempat Tinggal</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/sktmp"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Tidak Mampu</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skpck"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Pengantar Kepolisian</b></a>
        </td>
	</tr>   
    <tr>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skbm"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Belum Menikah</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skir"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Ijin Keramaian</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skb"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Bepergian</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skk"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Kematian</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skl"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Kelahiran</b></a>
        </td>
	</tr> 
    <tr>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skbn"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Beda Nama</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/sktkt"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Tidak Keberatan Tetangga</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skun_na"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Untuk Menikah [NA]</b></a>
        </td>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skpm"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Persetujuan Mempelai</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/siotm"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Ijin Orang Tua Untuk Menikah</b></a>
        </td>
	</tr> 
    <tr>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skdk"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Daftar Keluarga</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skpnh"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Pengantar Naik Haji</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skaw"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Ahli Waris</b></a>
        </td>
    	<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skppsp"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Pengantar SPPT-PBB</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skrt"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Riwayat Tanah</b></a>
        </td>
	</tr> 
    <tr>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skbmr"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Belum Memiliki Rumah</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skjd"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Cerai Hidup/Mati</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href="<?php echo base_url();?>index.php/skptt"><img src="<?php echo base_url();?>uploads/custom.png" /><br />
        <b> Surat Keterangan Penghasilan Tidak Tetap</b></a>
        </td>
		<td class="btn" align="center" width="20%"><a href=""></a>
        </td>
		<td class="btn" align="center" width="20%"><a href=""></a>
		</td>
	</tr>     
</table> 
<?php } ?>