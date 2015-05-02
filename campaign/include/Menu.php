<?
if($id<>"") {
	$itemArray=getRowById($_REQUEST['section'].".txt",$_REQUEST['id']);

	if($itemArray[6]<>"") {	// get page banner
		print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[6]."\" border=0>");
	} else {// get parent section banner
		$tempbanner=getValueByNameCol("Top.txt",$_REQUEST['section'],6);
		if ($tempbanner<>"") {
			print("<img src=\"upload/Top/".$tempbanner."\" border=0>");	
		} else {
			$tempbanner=getValueByNameCol("Left.txt",$_REQUEST['section'],6);
			if ($tempbanner<>"") {
				print("<img src=\"upload/Left/".$tempbanner."\" border=0>");	
			} 
		}
	}

	print("<br><img src=\"images/shim.gif\" width=10 height=1 border=0><span class=SectionTitle>".getLang($itemArray[1])."</span>");

	print("<table cellpadding=10><tr>");

	if($itemArray[10]=="Left") {//image
		print("<td valign=top>");
		if($itemArray[11]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[11]."\" border=0><br><br>\n");
		if($itemArray[12]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[12]."\" border=0><br><br>\n");
		if($itemArray[13]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[13]."\" border=0><br><br>\n");
		if($itemArray[14]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[14]."\" border=0><br><br>\n");
		print("</td>\n");
        }

	if($itemArray[10]=="Top") {//image
		print("<td valign=top align=center>");
		if($itemArray[11]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[11]."\" border=0><br><br>\n");
		if($itemArray[12]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[12]."\" border=0><br><br>\n");
		if($itemArray[13]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[13]."\" border=0><br><br>\n");
		if($itemArray[14]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[14]."\" border=0><br><br>\n");
		print("</td></tr><tr>\n");
        }
	print("<td valign=top>");
	$tempstr=getLang($itemArray[5]);
	if($tempstr<>"")	//content
		 print($tempstr."<br><br>");
	if($itemArray[8]<>"") {	//function
		$funcArray=explode("::",trim($itemArray[8]));
		include_once($funcArray[0].".php");
		$funcArray[0]($funcArray[1]);
	}
	print("</td>");

	if($itemArray[10]=="Right") { //image
		print("<td valign=top>");
		if($itemArray[11]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[11]."\" border=0><br><br>\n");
		if($itemArray[12]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[12]."\" border=0><br><br>\n");
		if($itemArray[13]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[13]."\" border=0><br><br>\n");
		if($itemArray[14]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[14]."\" border=0><br><br>\n");
		print("</td>\n");
        }
	if($itemArray[10]=="Bottom") {//image
		print("</tr><tr><td valign=top align=center>");
		if($itemArray[11]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[11]."\" border=0><br><br>\n");
		if($itemArray[12]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[12]."\" border=0><br><br>\n");
		if($itemArray[13]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[13]."\" border=0><br><br>\n");
		if($itemArray[14]) print("<img src=\"upload/".$_REQUEST['section']."/".$itemArray[14]."\" border=0><br><br>\n");
		print("</td>\n");
        }
	print("</tr></table>");
} else {
		// get parent section banner
		$tempbanner=getValueByNameCol("Top.txt",$_REQUEST['section'],6);
		if ($tempbanner<>"") {
			print("<img src=\"upload/Top/".$tempbanner."\" border=0>");	
		} else {
			$tempbanner=getValueByNameCol("Left.txt",$_REQUEST['section'],6);
			if ($tempbanner<>"") {
				print("<img src=\"upload/Left/".$tempbanner."\" border=0>");	
			} 
		}

	print("<table cellpadding=10><tr><td>");

	$temptitle=getLang(getValueByNameCol("Top.txt",$_REQUEST['section'],1));
	if ($temptitle=="")
		$temptitle=getLang(getValueByNameCol("Left.txt",$_REQUEST['section'],1));
	if ($temptitle<>"")	
		print("<span class=SectionTitle>".$temptitle."</span><br><br>");

	$rowsArray=getRows($section.".txt");
	for($i=0;$i<count($rowsArray);$i++){
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[2]=='Active')
			print("<a href=?section=$section&id=".$itemArray[0].">".getLang($itemArray[1])."</a><br>");
	}
	print("</td></tr></table>");
}
?>