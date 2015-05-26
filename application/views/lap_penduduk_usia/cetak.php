<style type="text/css">
*{
font-family: Arial;
margin:0px;
padding:0px;
}
@page {
 margin-left:3cm 2cm 2cm 2cm;
}
table.grid{
width:29.7cm ;
font-size: 12px;
border-collapse:collapse;
}
table.grid th{
	padding:5px;
}
table.grid th{
background: #F0F0F0;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
text-align:center;
border:1px solid #000;
}
table.grid tr td{
	padding:2px;
	border-bottom:0.2mm solid #000;
	border:1px solid #000;
}
h1{
font-size: 18px;
}
h2{
font-size: 14px;
}
h3{
font-size: 12px;
}
p {
font-size: 10px;
}
center {
	padding:8px;
}
.atas{
display: block;
width:29.7cm ;
margin:0px;
padding:0px;
}
.kanan tr td{
	font-size:12px;
}
.attr{
font-size:9pt;
width: 100%;
padding-top:2pt;
padding-bottom:2pt;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
}
.pagebreak {
width:29.7cm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:29.7cm ;
font-size:13px;
}
.page {
width:29.7cm ;
font-size:12px;
padding:10px;
}
table.footer{
width:29.7cm ;
font-size: 12px;
border-collapse:collapse;
}
</style>

<?php

$kiri = '<h1>'.$instansi.'</h1>';
$kiri .= '<p>'.$alamat_instansi.'</p>';

$kanan = "<table class='kanan' width='100%'>
		  <tr>
		  	<td>Filter By</td>
			<td width='5'>:</td>
			<td><b>$filter</b></td>
		  </tr>
		  </table>";
function myheader($kiri,$kanan,$judul){
?>

<div class="atas">
<table width="100%">
<tr>
	<td width="60%" valign="top">
   		<img src='<?php echo base_url();?>asset/images/logoprint.png' style="padding:0; margin:0;" width="85" height="81"> <?php echo $kiri;?>
    </td>
	<td width="40%" valign="top">
    	<?php echo $kanan;?>
    </td>
</tr>    
</table>
<center><h1><?php echo $judul;?></h1></center>
</div>
<table class="grid" width="100%">
	<tr>
    	<th width="10%">No</th>
        <th width="20%">Usia</th>
        <th width="20%">Laki-laki<br>[Jiwa]</th>
        <th width="20%">Perempuan<br>[Jiwa]</th>
        <th width="20%">Total<br>[Jiwa]</th>
    </tr>        
<?php
}
function myfooter(){	
	echo "</table>";
}
	$no=1;
	$page =1;
	for($u=$show_a;$u<=$show_b;$u+=5){
		$a = $u+4;
		if(($no%25) == 1){
		if($no > 1){
			myfooter();
			echo "<div class=\"pagebreak\" align='right'>
			<div class='page' align='center'>Hal - $page</div>
			</div>";
			$page++;
		}
		myheader($kiri,$kanan,$judul);
		}
		if($u==75){
		$g=$u.'-00';
		$male = $this->app_model->get_male($g);
		$female = $this->app_model->get_female($g);
		$total = $male + $female;
	?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td align="center"><?php echo $u.'+';?></td>
			<td align="center"><?php echo $male;?></td>
			<td align="center"><?php echo $female;?></td>
			<td align="center"><?php echo $total;?></td>
		</tr>
	 <?php
		}else{
		$g=$u.'-'.$a;
		$male = $this->app_model->get_male($g);
		$female = $this->app_model->get_female($g);
		$total = $male + $female;
	?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td align="center"><?php echo $u.' - '.$a;?></td>
			<td align="center"><?php echo $male;?></td>
			<td align="center"><?php echo $female;?></td>
			<td align="center"><?php echo $total;?></td>
		</tr>
	<?php
		}
		$no++;
		}
		$all_male = $this->app_model->get_all_male();
		$all_female = $this->app_model->get_all_female();
		$all_total = $all_male + $all_female;
		
		$all_per_male = (($all_male/$all_total)*100);
		$all_per_female = (($all_female/$all_total)*100); 
		$all_per_total = $all_per_male + $all_per_female;
		if($show_a==0 && $show_b==75){
	?>
	<tr>
			<td align="center" width="30%" colspan="2">Total Seluruhnya</td>
            <td align="center" width="20%" ><?php echo $all_male; ?></td>
            <td align="center" width="20%" ><?php echo $all_female; ?></td>
            <td align="center" width="20%" ><?php echo $all_total; ?></td>
		</tr>
		<tr>
			<td align="center" width="30%" colspan="2">Total Persen Seluruhnya</td>
            <td align="center" width="20%" ><?php echo round($all_per_male,2).'%'; ?></td>
            <td align="center" width="20%" ><?php echo round($all_per_female,2).'%'; ?></td>
            <td align="center" width="20%" ><?php echo $all_per_total.'%'; ?></td>
		</tr>
    <?php
	}
myfooter();	
	echo "</table>";
?>
<div style="padding:10px"></div>
<table width="100%" class="footer">
<tr>
	<td width="70%"></td>
	<td width="30%" valign="top" align="center">
    Bogor, <?php echo $this->app_model->tgl_indo(date('Y-m-d'));?>
    <br /><br /><br /><br />
    <b><u><?php echo $this->session->userdata('username');?></u></b>
    </td>
</tr>
</table>    
<div class="page" align="center">Hal - <?php echo $page;?></div>