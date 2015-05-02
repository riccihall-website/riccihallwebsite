<span class=SectionTitle2>HKOD &gt;</span><br><br>
<script language="JavaScript">
<!--
function checkform() {

}

function clearall() {
	document.myform.Name.value="";
	document.myform.District.selectedIndex=0;
	document.myform.Practice.selectedIndex=0;
}

//-->
</script>
<form name=myform method=post action="?section=HKOD" onSubmit="return checkform();">
	<table cellpadding=0 cellspacing=0 border=0 bgcolor=#000000 width=180><tr><td>
	  <table cellpadding=4 cellspacing=1 border=0 width="100%">
<tr><td class=scorehead colspan=2><?=getLabel("Search");?></td></tr>

<tr><td class=score><?=getLabel("Name");?><br><input type=text size=20 name=Name value="<?=$_REQUEST['Name']?>"><br><br>

<?=getLabel("District");?><br>

<?
$districtArray=array("00\t","14\tTuen Mun 屯門","18\tYuen Long 元朗","13\tTsuen Wan 荃灣","05\tKwai Tsing 葵青","07\tNorth 北區","12\tTai Po 大埔","09\tShatin 沙田","08\tSai Kung 西貢","03\tIsland 離島","10\tSham Shui Po 深水","17\tYau Tsim Mong 油尖旺","04\tKowloon City 九龍城","16\tWong Tai Sin 黃大仙","06\tKwun Tong 觀塘","01\tCentral & Western 中西區","15\tWan Chai 灣仔","02\tEastern 東區","11\tSouthern 南區");
$practiceArray=array("00","private\tPrivate 私人執業","government\tGovernment 政府","hospital authority\tH.A. 醫管局","university\tUniversity 大學","other\tOthers 其他");
?>
<select name=District>
<?
foreach($districtArray as $line) {
	$itemArray=explode("\t",trim($line));
	$tempSelect="";
	if ($itemArray[0] == $_REQUEST['District'])
		$tempSelect="selected";
	print("<option value=\"$itemArray[0]\" $tempSelect>$itemArray[1]</option>\n");
}
?>
</select><br><br>

<?=getLabel("TypesOfPractice");?><br>
<select name="Practice">
<?
foreach($practiceArray as $line) {
	$itemArray=explode("\t",trim($line));
	$tempSelect="";
	if ($itemArray[0] == $_REQUEST['Practice'])
		$tempSelect="selected";
	print("<option value=\"$itemArray[0]\" $tempSelect>$itemArray[1]</option>\n");
}
?>
              </select><br><br>

<input type=submit value="<?=getLabel("Search");?>"> <input type=button onClick="clearall();" value="<?=getLabel("Clear");?>"><input type=hidden name=action value=search></td></tr>

	  </table></td></tr>
	</table><P>
</form>