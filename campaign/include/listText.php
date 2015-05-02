<?
function listText($dbname){
print("<table border=0 cellpadding=4 cellspacing=0 width=100%>");

$rowsArray=getRows($dbname.".txt");
//print("<tr><td valign=top><img src=\"images/shim.gif\" width=170 height=1 border=0></td><td valign=top><img src=\"images/shim.gif\" width=580 height=1 border=0></td></tr>\n");
for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[2]=='Active') {
		print("<tr><td valign=top><b>$itemArray[1]</b></td>");
		print("<td valign=top>".getLang($itemArray[3])."</td></tr>\n");
	}
}
print("</table><br>\n");
}
?>