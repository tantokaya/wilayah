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
    <th>Usia</th>
    <th>Laki-Laki<br>[Jiwa]</th>
    <th>Perempuan<br>[Jiwa]</th>
    <th>Total<br>[Jiwa]</th>

</tr>
	<?php
		$no =1;
		for($u=$show_a;$u<=$show_b;$u+=5){
		$a = $u+4;
		if($u==75){
		$g=$u.'-00';
		$male = $this->app_model->get_male($g);
		$female = $this->app_model->get_female($g);
		$total = $male + $female;
		?>    
    	<tr>
			<td align="center" width="10%"><?php echo $no; ?></td>
            <td align="center" width="20%" ><?php echo $u.'+'; ?></td>
            <td align="center" width="20%" ><?php echo $male; ?></td>
            <td align="center" width="20%" ><?php echo $female; ?></td>
            <td align="center" width="20%" ><?php echo $total; ?></td>
            
		</tr>
    <?php
		}else{
		$g=$u.'-'.$a;
		$male = $this->app_model->get_male($g);
		$female = $this->app_model->get_female($g);
		$total = $male + $female;
	?>
		<tr>
			<td align="center" width="10%"><?php echo $no; ?></td>
            <td align="center" width="20%" ><?php echo $u.' - '.$a; ?></td>
            <td align="center" width="20%" ><?php echo $male; ?></td>
            <td align="center" width="20%" ><?php echo $female; ?></td>
            <td align="center" width="20%" ><?php echo $total; ?></td>
            
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
	<?php } ?>
</table>