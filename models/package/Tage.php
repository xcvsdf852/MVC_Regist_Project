<?php 

if(isset($_GET['P'])){$P=$_GET['P'];}else{$P=1;}

if(isset($_GET['P_number'])){$P_number=$_GET['P_number'];}else{$P_number=10;}

if(isset($_GET['count_num'])){$count_num=$_GET['count_num'];}else{$count_num=1;}

if(isset($_GET['function'])){$function=$_GET['function'];}else{$function='GetSelect';}
?>


<table><tr>

<?php 

if($P-5>1){echo '<td><a href="javascript:'.$function.'(1,'.$P_number.');">首頁</a>...</td>';}

if($count_num%$P_number!=0){


if($P-5<=intval($count_num/$P_number)+1 && $P-5>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-5).','.$P_number.');">'.($P-5).'</a></td>';
	}

if($P-4<=intval($count_num/$P_number)+1&& $P-4>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-4).','.$P_number.');">'.($P-4).'</a></td>';
	}
	
if($P-3<=intval($count_num/$P_number)+1&& $P-3>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-3).','.$P_number.');">'.($P-3).'</a></td>';
	}

if($P-2<=intval($count_num/$P_number)+1&& $P-2>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-2).','.$P_number.');">'.($P-2).'</a></td>';
	}
if($P-1<=intval($count_num/$P_number)+1&& $P-1>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-1).','.$P_number.');">'.($P-1).'</a></td>';
	}
	
	
echo '<td>'.($P).'</td>';


if($P+1<=intval($count_num/$P_number)+1 && $P+1>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+1).','.$P_number.');">'.($P+1).'</a></td>';
	}

if($P+2<=intval($count_num/$P_number)+1&& $P+2>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+2).','.$P_number.');">'.($P+2).'</a></td>';
	}
	
if($P+3<=intval($count_num/$P_number)+1&& $P+3>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+3).','.$P_number.');">'.($P+3).'</a></td>';
	}

if($P+4<=intval($count_num/$P_number)+1&& $P+4>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+4).','.$P_number.');">'.($P+4).'</a></td>';
	}
if($P+5<=intval($count_num/$P_number)+1&& $P+5>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+5).','.$P_number.');">'.($P+5).'</a></td>';
	}

if($P+5<intval($count_num/$P_number)+1){echo '<td>...<a href="javascript:'.$function.'('.(intval($count_num/$P_number)+1).','.$P_number.');">末頁</a></td>';}
}else{
	
	
if($P-5<intval($count_num/$P_number)+1 && $P-5>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-5).','.$P_number.');">'.($P-5).'</a></td>';
	}

if($P-4<intval($count_num/$P_number)+1&& $P-4>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-4).','.$P_number.');">'.($P-4).'</a></td>';
	}
	
if($P-3<intval($count_num/$P_number)+1&& $P-3>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-3).','.$P_number.');">'.($P-3).'</a></td>';
	}

if($P-2<intval($count_num/$P_number)+1&& $P-2>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-2).','.$P_number.');">'.($P-2).'</a></td>';
	}
if($P-1<intval($count_num/$P_number)+1&& $P-1>=1){
		echo '<td><a href="javascript:'.$function.'('.($P-1).','.$P_number.');">'.($P-1).'</a></td>';
	}
	
	
echo '<td>'.($P).'</td>';


if($P+1<intval($count_num/$P_number)+1 && $P+1>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+1).','.$P_number.');">'.($P+1).'</a></td>';
	}

if($P+2<intval($count_num/$P_number)+1&& $P+2>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+2).','.$P_number.');">'.($P+2).'</a></td>';
	}
	
if($P+3<intval($count_num/$P_number)+1&& $P+3>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+3).','.$P_number.');">'.($P+3).'</a></td>';
	}

if($P+4<intval($count_num/$P_number)+1&& $P+4>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+4).','.$P_number.');">'.($P+4).'</a></td>';
	}
if($P+5<intval($count_num/$P_number)+1&& $P+5>=1){
		echo '<td><a href="javascript:'.$function.'('.($P+5).','.$P_number.');">'.($P+5).'</a></td>';
	}

if($P+5<intval($count_num/$P_number)+1){echo '<td>...<a href="javascript:'.$function.'('.(intval($count_num/$P_number)+1).','.$P_number.');">末頁</a></td>';}
	
	}
?>

</tr></table>

<script type="text/javascript">
/*
function GetSelect(P,P_number){
	location.replace('Order_tage.php?count_num=988&P='+P+'&P_number='+P_number);
	
	}*/
</script>