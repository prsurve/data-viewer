<?php include_once('config.php'); include_once('paginator.class.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title>Pagination with bootstrap</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css" />
</head>
<body>
<!--<div class="container">-->
	<?php
	
		$qryStr		=	"SELECT * FROM WORKLOAD";
		$workload_data	=	$db->query($qryStr);
		$count		=	$workload_data->num_rows;
		echo $qryStr->fetch_assoc();
		if(!$rownota = $workload_data->fetch_assoc()) {
        		echo 'Fail';
    		}
		
		$pages = new Paginator($count,9);
		echo '<div class="col-sm-6">';
		echo '<nav aria-label="Page navigation"><ul class="pagination">';
		echo $pages->display_pages();
		echo '</ul></nav>';
		echo '</div>';
		echo '<div class="col-sm-6 text-right">';
		echo "<span class=\"form-inline\">".$pages->display_jump_menu().$pages->display_items_per_page()."</span>";
		echo '</div>';
		echo '<div class="clearfix"></div>';
		$limit	= $pages->limit_start.','.$pages->limit_end;
		$qry 	=	$db->query($qryStr.' LIMIT '.$limit);
	
	?>

<!--	<table class="table table-bordered table-striped table-hover">-->
<!--		<thead>-->
<!--			<tr class="bg-primary">-->
<!--				<th>Sr#</th>-->
<!--				<th>Date</th>-->
<!--				<th>DATA</th>-->
<!--			</tr>-->
<!--		</thead>-->
<!--		<tbody>-->
<!--			--><?php //
//			if($count>0){
//				$n	=	1;
//				while($val	=	$qry->fetch_assoc()){
//			?>
<!--			<tr>-->
<!--				<td>--><?php //echo $n++; ?><!--</td>-->
<!--				<td>--><?php //echo $val['dt']; ?><!--</td>-->
<!--				<td>--><?php //echo $val['DATA']; ?><!--</td>-->
<!--			</tr>-->
<!--			--><?php //
//				}
//			}else{?>
<!--			<tr>-->
<!--				<td colspan="6">No Record(s) Found!</td>-->
<!--			</tr>-->
<!--			--><?php //} ?>
<!--		</tbody>-->
<!--	</table>-->
<!--	--><?php
//		echo '<div class="col-sm-6">';
//		echo '<nav aria-label="Page navigation"><ul class="pagination">';
//		echo $pages->display_pages();
//		echo '</ul></nav>';
//		echo '</div>';
//		echo '<div class="col-sm-6 text-right">';
//		echo "<p class=\"label label-default\">Page: $pages->current_page of $pages->num_pages</p>\n";
//		echo '</div>';
//		echo '<div class="clearfix"></div><hr>';
//		echo "<p class=\"code\">SELECT * FROM table LIMIT $pages->limit_start,$pages->limit_end (retrieve records $pages->limit_start-".($pages->limit_start+$pages->limit_end)." from table - $pages->total_items item total / $pages->items_per_page items per page)";
//	?>
<!--			-->
<!--	</div> <!--/.container-->-->
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>
