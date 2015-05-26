<script type="text/javascript" src="<?php echo base_url();?>asset/js/highcharts/highcharts-3d.js"></script>
<?php 
$tahun = date('Y');
	$male 	= $this->app_model->GrafikMale() + $this->app_model->get_GrafikMaleSKL();
	$female	= $this->app_model->GrafikFemale() + $this->app_model->get_GrafikFemaleSKL();
?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'pie',
				options3d: {
				enabled: true,
                alpha: 45,
                beta: 0
            }
				
            },
            title: {
            text: '<?php echo $judul;?> Sampai Tahun <?php echo $tahun;?>'
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
				depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
				},
				showInLegend: true
				
            }
        },
            series: [{
            type: 'pie',
            name: 'Total Penduduk',
            data: [
                ['Laki-laki',   	<?php echo $male;?>],
				['Perempuan',   	<?php echo $female;?>],

            ]
        }]
        });
    });
    
});
</script>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
<br>
<br>
<table width="100%">
<tr>
	<td colspan="3" align="center">
	<a href="<?php echo base_url();?>index.php/grafik_penduduk">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton l-btn" data-options="iconCls:'icon-reload'">REFRESH</button>
	</a>
    <a href="<?php echo base_url();?>index.php/home">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  