<?
function forum($dbname){
global $page;
global $pageItem;
global $link;
global $dbpath;
$dataFile=$dbname.".txt";

if($_REQUEST['action']=='inserted'){
/////////////////////////// inserted ////////////////////////////////
$newline=getTableID($dbname);
$defArray=getDef($dbname);		//get section db definition from master file
$nameArray=$defArray[0];

$_REQUEST['Status']='Active';
$_REQUEST['Datetime']=date("Y-m-d H:i:s");

foreach($nameArray as $name)					// construct new line
	$newline.="\t".eregi_replace("\r\n","<br>",stripslashes($_REQUEST[$name]));
$newline.="\n";

$rowsArray=getRows($dataFile);

//loop each row
$datafile=fopen($dbpath.$dataFile,"w");
fwrite($datafile,$newline);
for($i=0; $i<count($rowsArray);$i++) {
	fwrite($datafile,$rowsArray[$i]);
}
fclose($datafile);
}

/////////////////////////// calculate page number and row range ////////////////////////////////
$rowsArray=getRows($dataFile);
$pageTotal=ceil(count($rowsArray)/$pageItem);
//set loop range
	if ($page=="") 	$page=1;
	$nbegin=($page-1)*$pageItem;
	$nstop=$nbegin+$pageItem-1;
	if (count($rowsArray)<=$nstop) $nstop=count($rowsArray)-1;
/////////////////////////// show page number ////////////////////////////////
showPage($pageTotal,$page,$link);

/////////////////////////// show messages ////////////////////////////////
?>
<br><br><table cellpadding="2" cellspacing="1" border="0" bgcolor="#000000" width=100%>
<tr><td class=tablehead width="200" nowrap><?print(getLabel("Name"))?></td>
<td class=tablehead width="200" nowrap><?print(getLabel("Email"))?></td>
<td class=tablehead width="200" nowrap><?print(getLabel("Datetime"))?></td></tr>
<?
$alternate=1;
for($i=$nbegin; $i<=$nstop;$i++) {
	if($alternate==1) {
		$tblbg="#ffffff";
	}else{
		$tblbg="#".getStyle("Background");
	}
	$thisArray=explode("\t",trim($rowsArray[$i]));
	if ($thisArray[2]=='Active') {
		print("<tr bgcolor=$tblbg><td valign=top>$thisArray[1]</td>");
		print("<td valign=top>$thisArray[3]</td>");
		print("<td valign=top>$thisArray[4]</td></tr>\n");
		print("<tr bgcolor=$tblbg><td colspan=3>$thisArray[5]<br><br></td></tr>\n");
	}
	$alternate*=-1;
}
print("</table><br>\n");

/////////////////////////// show page number ////////////////////////////////
showPage($pageTotal,$page,$link);

/////////////////////////// show message box ////////////////////////////////
?>
<br><br>
<script type="text/javascript">
<!--
function checkform() {
	if (document.f1.Name.value.length==0) {
		alert("<?print(getLabel('PleaseEnter'));?><?print(getLabel('Name'));?>");
		return false;
	}
	if (document.f1.Email.value.length==0) {
		alert("<?print(getLabel('PleaseEnter'));?><?print(getLabel('Email'));?>");
		return false;
	}
	if (document.f1.Content.value.length==0) {
		alert("<?print(getLabel('PleaseEnter'));?><?print(getLabel('Content'));?>");
		return false;
	}
}
//-->

</script>

<form name=f1 action="?section=<?print($_REQUEST['section']);?>&id=<?print($_REQUEST['id']);?>" method="post" onSubmit="return checkform();">
<table cellpadding="2" cellspacing="1" border="0" bgcolor="#000000" width=100%>
<tr><td class=tablehead width="300" nowrap><?print(getLabel("Name"))?></td>
<td class=tablehead width="300" nowrap><?print(getLabel("Email"))?></td></tr>
		<tr bgcolor=#aaaaaa><td valign=top><input type=text name=Name size=50></td>
		<td valign=top><input type=text name=Email size=50></td>
		<tr bgcolor=#aaaaaa><td colspan=23><textarea name=Content cols=80 rows=5></textarea></td></tr>
</table><input type=submit><input type=reset><input type=hidden name=action value=inserted></form><br>
<?
}
?>