<?
$rowsArray=getRows($dataFile);

//set loop range
	if ($page){
	} else {
		$page=1;
	}
	$nbegin=($page-1)*$pageItem;
	$nstop=$nbegin+$pageItem-1;
	if (count($rowsArray)<=$nstop) {
		$nstop=count($rowsArray)-1;
		$lastpage=1;
	}
?>

<script language="Javascript">
<!--
function itemaction(arga,argb){
	if(argb=='d'){
		if (confirm("Are you sure to delete item?")) {
		} else {
			return false;
		}
	}
	document.f1.edititem.value=arga;
	document.f1.editaction.value=argb;
	document.f1.submit();
}
//-->
</script>

<!--list-->
Total: <?print(count($rowsArray))?>  - Page <?print($page)?><br><br>
<form name=f1 action=index.php method=post>
<input type=hidden name=edititem value=''>
<input type=hidden name=editaction value=''>
<table width="400" cellpadding="2" cellspacing="1" border="0" bgcolor="#000000">

<tr><td class=tablehead nowrap width="30">No.</td><td class=tablehead nowrap width="30">ID</td>
<?
if ($showArray) {					// show name column if nothing assigned
} else {
	$showArray[]=0;
}
for($j=0; $j<count($showArray);$j++) { 			// show column label
	$columnname=$nameArray[$showArray[$j]];
	print("<td class=tablehead width=\"100\" nowrap>$columnname</td>");
}
$colspan=2+count($showArray);

$indentcolumn=0;
reset($nameArray);
while ($col_name = current($nameArray)) {		// get indent index (Level) column
    if ($col_name == 'Level') {
	$indentcolumn=key($nameArray);
    }
    next($nameArray);
}

?>
<td class=tablehead nowrap width="150">Control</td></tr>
<?
$lastedititem=0;
//loop each row in range
// determine up down arrow
for($i=$nbegin; $i<=$nstop;$i++) {
	$j=$i+1;
	$itemArray=explode("\t",trim($rowsArray[$i]));			// get row data for display
	if($i==0)							// determine arrow show or not for first or last row
		$row1="disabled";
	else
		$row1="";
	if($i==count($rowsArray)-1)
		$rowend="disabled";
	else
		$rowend="";

	print "<tr bgColor=\"#FFFFFF\" onmouseover=\"javascript:this.bgColor='#f6d6c6'\" onmouseout=\"javascript:this.bgColor='#FFFFFF'\">
		<td nowrap>$j</td>\n";

	print ("<td nowrap>$itemArray[0]</td>");
	for($j=0; $j<count($showArray);$j++) {				// foreach show column
		$arrayMatch=0;
		if(is_array($typeArray[$showArray[$j]])) {		// if column type is array
			for($k=0; $k<count($typeArray[$showArray[$j]]);$k++) {	// foreach column type value
				if(eregi("&&",$typeArray[$showArray[$j]][$k])){		// if column type value is multliple for reference to another table row
					$tempArray=explode("&&",trim($typeArray[$showArray[$j]][$k]));
					if($tempArray[0]==$itemArray[$showArray[$j]+1]) {
						$columnvalue=$tempArray[1];
						$arrayMatch=1;
					}
				}
			}
			if ($arrayMatch<>1)				// if column type is simple array, simple copy
				$columnvalue=$itemArray[$showArray[$j]+1];
		} else {
			$columnvalue=$itemArray[$showArray[$j]+1];	// if column type not array, simple copy
		}
		$indent="";						// show indent if name column
		if($indentcolumn>0 && $j==0 && $itemArray[$indentcolumn+1]>1) {
			for($m=2;$m<=$itemArray[$indentcolumn+1];$m++) {
				$indent.="&nbsp;&nbsp;&nbsp;&nbsp; ";
			}
		}
		//$tempcolumnvalue=substrChi($indent.$columnvalue,80);
		$tempcolumnvalue=mb_substr($indent.$columnvalue,0,80,"UTF-8");
		print ("<td nowrap>$tempcolumnvalue</td>");		// print column value of the row i.e. cell
	}
	print "	<td nowrap><input type=button onClick=\"itemaction('$itemArray[0]','e');\" value=\"Edit\"> 
			<input type=button onClick=\"itemaction('$itemArray[0]','d');\" value=\"Del\"> 
			<input type=button onClick=\"itemaction('$itemArray[0]','i');\" value=\"Insert\"> 
			<input type=button onClick=\"itemaction('$itemArray[0]','c');\" value=\"Copy\"> 
			<input type=button onClick=\"itemaction('$itemArray[0]','r');\" value=\"&#9650;\" $row1> 
			<input type=button onClick=\"itemaction('$itemArray[0]','s');\" value=\"&#9660;\" $rowend> 
		</td></tr>\n\n";	
	$lastedititem=$itemArray[0];
}
	print "<tr bgColor=\"#FFFFFF\" onmouseover=\"javascript:this.bgColor='#f6d6c6'\" onmouseout=\"javascript:this.bgColor='#FFFFFF'\">
		<td colspan=$colspan></td><td align=center><input type=button onClick=\"itemaction('".$lastedititem."a','i');\" value=\"Insert\"></td></tr>\n\n";

print "</table><input type=hidden name=page value=$page><input type=hidden name=section value=$section>\n";
print "</form>\n";	

//pages total
	$pagetotal=ceil(count($rowsArray)/$pageItem);
	$next=$page+1;
	$previous=$page-1;
	print "<span class=\"engcontent\">Page &nbsp; ";
	if ($previous>0) {
		print "<a href=$link?page=$previous>Previous</a> &nbsp; ";
	}
	for($j=1; $j<=$pagetotal;$j++) {
		print "<a href=$link?page=$j>$j</a> &nbsp; ";
	}
	if ($next<=$pagetotal) {
		print "<a href=$link?page=$next>Next</a> &nbsp; </span>";
	}
?>