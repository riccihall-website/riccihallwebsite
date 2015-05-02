<?include_once("include/datashow.php");

// check mode and get exist data

if ($_REQUEST['editaction']=="e") {
	$editmode="Edit";
	$thisarray=getRowById($dataFile,$edititem);
	// addback carriage return
	for($i=0; $i<count($thisarray);$i++)
		$thisarray[$i]=eregi_replace('<br>',"\r\n",$thisarray[$i]);
} elseif ($_REQUEST['editaction']=="c") {
	$editmode="Copy";
	$thisarray=getRowById($dataFile,$edititem);
	// addback carriage return
	for($i=0; $i<count($thisarray);$i++)
		$thisarray[$i]=eregi_replace('<br>',"\r\n",$thisarray[$i]);
} elseif ($_REQUEST['editaction']=="i") {
	$editmode="Insert";
}

//edit form
?>
<script>
<!--
function checkform() {
<?
for($i=0; $i<count($nameArray);$i++) {
	showCheck($nameArray[$i],$typeArray[$i]);
}
for($i=0; $i<count($nameArray);$i++) {
	showExtra($nameArray[$i],$typeArray[$i]);
}
?>
}
//-->
</script>
<form name=f1 action=index.php method=post enctype="multipart/form-data" onSubmit="return checkform();">
<table cellpadding=4 cellspacing=1 border=0 bgcolor=#000000 width="500"><tr><td colspan=2 class=tablehead align=center><?print($editmode)?></td></tr>
<?
for($i=0; $i<count($nameArray);$i++) {
	if ($thisarray[$i+1]) 
		showRow($nameArray[$i],$typeArray[$i],$thisarray[$i+1]);
	 else 
		showRow($nameArray[$i],$typeArray[$i],$defaultArray[$i]);
}
?>
</table>
<P>
<input type=hidden name=editaction value="<?print($_REQUEST['editaction'].$_REQUEST['editaction'])?>">
<input type=hidden name=edititem value="<?print($edititem)?>">
<input type=hidden name=page value="<?print($page)?>">
<input type=hidden name=section value="<?print($section)?>">
<input type=submit value="Save"> &nbsp; <input type=reset value="Reset"> &nbsp; <input type=button value="Cancel" onClick="javascript:document.location='index.php?section=<?print($section)?>&page=<?print($page)?>'">
</form>
