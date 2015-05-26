		<?php 
$tahun = date('Y');
$bln = '';
	$skdu 	= $this->app_model->GrafikSkdu($bln,$tahun);
	$sku	= $this->app_model->GrafikSku($bln,$tahun);
	$sktt 	= $this->app_model->GrafikSktt($bln,$tahun);
	$sktmp 	= $this->app_model->GrafikSktmp($bln,$tahun);
	$skpck 	= $this->app_model->GrafikSkpck($bln,$tahun);
	$skbm 	= $this->app_model->GrafikSkbm($bln,$tahun);
	$skir 	= $this->app_model->GrafikSkir($bln,$tahun);
	$skb 	= $this->app_model->GrafikSkb($bln,$tahun);
	$skk 	= $this->app_model->GrafikAngkaKematian($bln,$tahun);
	$skl	= $this->app_model->GrafikAngkaKelahiran($bln,$tahun);
	$skbn 	= $this->app_model->GrafikSkbn($bln,$tahun);
	$sktkt 	= $this->app_model->GrafikSktkt($bln,$tahun);
	//$sktot 	= $this->app_model->GrafikSktot($bln,$tahun);
	$skau 	= $this->app_model->GrafikSkau($bln,$tahun);
	$skun 	= $this->app_model->GrafikSkun($bln,$tahun);
	$skun_na = $this->app_model->GrafikSkun_NA($bln,$tahun);
	$skpm 	= $this->app_model->GrafikSkpm($bln,$tahun);
	$siotm	= $this->app_model->GrafikSiotm($bln,$tahun);
	$skdk	= $this->app_model->GrafikSkdk($bln,$tahun);
	$skpnh	= $this->app_model->GrafikSkpnh($bln,$tahun);
	$skaw	= $this->app_model->GrafikSkaw($bln,$tahun);
	$skppsp	= $this->app_model->GrafikSkppsp($bln,$tahun);
	$skrt	= $this->app_model->GrafikSkrt($bln,$tahun);
	$skbmr	= $this->app_model->GrafikSkbmr($bln,$tahun);
	$skjd	= $this->app_model->GrafikSkjd($bln,$tahun);
	$skptt	= $this->app_model->GrafikSkptt($bln,$tahun);
?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'pie',
				
            },
            title: {
            text: 'Grafik Pembuatan Surat Keterangan Tahun <?php echo $tahun;?>'
			},
			subtitle: {
                text: '<?php echo $nama_program;?>'
            },
			tooltip: {
			},
            plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
				
            }
        },
            series: [{
            type: 'pie',
            name: 'Total Surat',
            data: [
                ['SKDU',   	<?php echo $skdu;?>],
				['SKU',   	<?php echo $sku;?>],
				['SKTT',   	<?php echo $sktt;?>],
				['SKTMP',   <?php echo $sktmp;?>],
				['SKPCK',   <?php echo $skpck;?>],
				['SKBM',   	<?php echo $skbm;?>],
				['SKIR',   	<?php echo $skir;?>],
				['SKB',   	<?php echo $skb;?>],
				['SKK',   	<?php echo $skk;?>],
				['SKL',   	<?php echo $skl;?>],
				['SKBN',   	<?php echo $skbn;?>],
				['SKTKT',  	<?php echo $sktkt;?>],
				['SKAU',  	<?php echo $skau;?>],
				['SKUN NA', <?php echo $skun_na;?>],
				['SKPM',  	<?php echo $skpm;?>],
				['SIOTM',  	<?php echo $siotm;?>],
				['SKDK',  	<?php echo $skdk;?>],
				['SKPNH',  	<?php echo $skpnh;?>],
				['SKAW',  	<?php echo $skaw;?>],
				['SKPPSP', 	<?php echo $skppsp;?>],
				['SKRT', 	<?php echo $skrt;?>],
				['SKBMR', 	<?php echo $skbmr;?>],
				['SKJD', 	<?php echo $skjd;?>],
				['SKPTT', 	<?php echo $skptt;?>]
            ]
        }]
        });
    });
    
});
</script>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
<div style="background:#FFFFFF;">
<table width='100%'>
	<tr>
		<th colspan='3' align='left'><strong>Keterangan :</strong></th>
	</tr>
	<tr>
		<td><strong>SKDU</strong> : Surat Keterangan Domisili Usaha</td>
		<td><strong>SKU</strong>  : Surat Keterangan Usaha</td>
		<td><strong>SKTT</strong> : Surat Keterangan Tempat Tinggal</td>
	</tr>
	<tr>
		<td><strong>SKTMP</strong>  : Surat Keterangan Tidak Mampu</td>
		<td><strong>SKPCK</strong> : Surat Keterangan Pengantar Kepolisian</td>
		<td><strong>SKBM</strong>  : Surat Keterangan Belum Menikah</td>
	</tr>
	<tr>
		<td><strong>SKIR</strong> : Surat Keterangan Ijin Keramaian</td>
		<td><strong>SKB</strong>  : Surat Keterangan Bepergian</td>
		<td><strong>SKK</strong> : Surat Keterangan Kematian</td>
	</tr>
	<tr>
		<td><strong>SKL</strong>  : Surat Keterangan Kelahiran</td>
		<td><strong>SKBN</strong> : Surat Keterangan Beda Nama</td>
		<td><strong>SKTKT</strong>  : Surat Keterangan Tidak Keberatan Tetangga</td>
	</tr>
	<tr>
		<td><strong>SKUN</strong> : Surat Keterangan Untuk Menikah</td>
		<td><strong>SKPM</strong>  : Surat Keterangan Persetujuan Mempelai</td>
		<td><strong>SIOTM</strong> : Surat Ijin Orang Tua Untuk Menikah</td>
	</tr>
	<tr>				
		<td><strong>SKDK</strong>  : Surat Keterangan Daftar Keluarga</td>
		<td><strong>SKPNH</strong> : Surat Keterangan Pengantar Naik Haji</td>
		<td><strong>SKAW</strong>  : Surat Keterangan Ahli Waris</td>
	</tr>
	<tr>				
		<td><strong>SKPPSP</strong> : Surat Keterangan Pengantar SPPT-PBB</td>
		<td><strong>SKRT</strong>  : Surat Keterangan Riwayat Tanah</td>
		<td><strong>SKBM</strong> : Surat Keterangan Belum Memiliki Rumah</td>
	</tr>
	<tr>			
		<td><strong>SKJD</strong>  : Surat Keterangan Cerai Hidup/Mati</td>
		<td><strong>SKPTT</strong> : Surat Keterangan Penghasilan Tidak Tetap</td>
		<td></td>
		
	</tr>
</table>
</div>
<table width="100%">
<tr>
	<td colspan="3" align="center">
	<a href="<?php echo base_url();?>index.php/grafik_sk">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton l-btn" data-options="iconCls:'icon-reload'">REFRESH</button>
	</a>
    <a href="<?php echo base_url();?>index.php/home">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
	