<script>
<!--
function checkform() {
	if (document.f1.upfile.value.length==0) {
		alert("Please choose a file to upload");
		return false;
	}

}
//-->
</script>
<form name=f1 action="./?section=<?print($section);?>" method=post enctype="multipart/form-data" onSubmit="return checkform();">
<input type=file name=upfile> <input type=hidden name=editaction value=ff> <input type=submit value="Upload">
</form>

<?
// get directory

if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			$dataarray[]="$file";
		}
		closedir($dh);
		if (count($dataarray)>0) {
			sort($dataarray);
			array_shift($dataarray);
			array_shift($dataarray);
		}
	}
}
/////////////////////////// list ////////////////////////////////


//set loop range
	if ($page){
	} else {
		$page=1;
	}
	$nbegin=($page-1)*$pageItem;
	$nstop=$nbegin+$pageItem-1;
	if (count($dataarray)<=$nstop) {
		$nstop=count($dataarray)-1;
	}
?>

<script language="Javascript">
<!--
function itemaction(arga,argb){
	document.f2.edititem.value=arga;
	document.f2.editaction.value=argb;
	document.f2.submit();
}
//-->
</script>

<!--list-->
<span class="engcontent">Total: <?print(count($dataarray))?>  - Page <?print($page)?></span><br><br>
<form name=f2 action="./?section=<?print($section);?>" method=post>
<input type=hidden name=edititem value=''>
<input type=hidden name=editaction value=''>
<table width="70%" cellpadding="2" cellspacing="1" border="0" bgcolor="#000000">
<tr><td class=tablehead nowrap>No.</td>
<td class=tablehead nowrap>File Name</td>
<td class=tablehead nowrap width="50">Control</td></tr>
<?

//loop each row
for($i=$nbegin; $i<=$nstop;$i++) {
	$j=$i+1;
	print "<tr bgColor=\"#FFFFFF\" onmouseover=\"javascript:this.bgColor='#f6d6c6'\" onmouseout=\"javascript:this.bgColor='#FFFFFF'\">
		<td nowrap>$j</td>
		<td nowrap><a href=\"$dir$dataarray[$i]\" target=_blank>$dataarray[$i]</a></td>
		<td><input type=button onClick=\"itemaction('$dataarray[$i]','fd');\" value=\"Del\"></td></tr>\n";	
}
print "</table><input type=hidden name=page value=$page>\n";
print "</form>\n";	

//pages total
	$pagetotal=ceil(count($dataarray)/$pageItem);
	$next=$page+1;
	$previous=$page-1;
	print "<span class=\"engcontent\">Page &nbsp; ";
	if ($previous>0) {
		print "<a href=$file?page=$previous>Previous</a> &nbsp; ";
	}
	for($j=1; $j<=$pagetotal;$j++) {
		print "<a href=$file?page=$j>$j</a> &nbsp; ";
	}
	if ($next<=$pagetotal) {
		print "<a href=$file?page=$next>Next</a> &nbsp; </span>";
	}


/////////////////////////// list ////////////////////////////////
?>