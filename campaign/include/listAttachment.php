<?
function listAttachment($dbname){
print("<table border=0 cellpadding=4 cellspacing=0 width=100%><tr>");


$rowsArray=getRows($dbname.".txt");
//print("<tr><td valign=top><img src=\"images/shim.gif\" width=170 height=1 border=0></td><td valign=top><img src=\"images/shim.gif\" width=580 height=1 border=0></td></tr>\n");

for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[2]=='Active') {
		print("<td align=center valign=top><a href=\"upload/$dbname/$itemArray[7]\" target=_blank><img src=\"upload/$dbname/$itemArray[6]\" border=0><br>".getLang($itemArray[1])."</a></td>");
	}
	$j=round(($i+1)/4)*4-1;
	if ($j==$i) print ("</tr><tr>");
}
print("</tr></table><br>\n");
}
?>