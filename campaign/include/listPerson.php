<?
function listPerson($dbname){

print("<table border=0 cellpadding=4 cellspacing=0 width=750>");

$rowsArray=getRows($dbname.".txt");
print("<tr><td valign=top><img src=\"images/shim.gif\" width=80 height=1 border=0></td><td valign=top><img src=\"images/shim.gif\" width=650 height=1 border=0></td></tr>\n");
for($i=0;$i<count($rowsArray);$i++){
	$itemArray=explode("\t",trim($rowsArray[$i]));
	if ($itemArray[2]=='Active') {
		print("<tr><td valign=top>\n");
		if ($itemArray[7]) print("<a href=\"?section=$dbname&id=$itemArray[0]\"><img src=\"upload/$dbname/$itemArray[7]\" width=80 border=0></a>\n");
		print("</td><td valign=top align=left>\n");		
		print("<a href=\"?section=$dbname&id=$itemArray[0]\">".getLang($itemArray[1])."</a><br><br>\n");
		if ($itemArray[5]) print(mb_substr(getLang($itemArray[5]),0,80,"UTF-8")." ......\n");
		print("</td></tr>\n");
	}
}
print("</table><br>\n");
}
?>