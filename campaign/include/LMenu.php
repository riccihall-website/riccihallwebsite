<?
if($id<>"") {
	$rowsArray=getRows($section.".txt");
//	print("<span class=SectionTitle>".getSetting("SiteName")."</span><br><br>");

	$tempsection="";
	$tempsectioncur="";
	$tempsubhit="";
	for($i=0;$i<count($rowsArray);$i++){
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[2]=='Active'){
			if($itemArray[3]=='1') {
				$tempsectioncur=getLang($itemArray[1]);
				if($tempsubhit<1) {
					unset($rowsArrayDisplay);
				} elseif($tempsubhit==1) {
					$tempsubhit=2;
				}
			} else {
				if($tempsubhit<2) $rowsArrayDisplay[]=$rowsArray[$i];
			}
			if($itemArray[0]==$id) {
				$tempsubhit=1;
				$tempsection=$tempsectioncur;				
			}
//		 print getLang($itemArray[1])." tsh $tempsubhit<br>";
		}
	
	}

	print("&nbsp;<span class=SectionTitle2>$tempsection &gt;</span><br><br><table width=100% cellpadding=6 cellspacing=0>");
	for($i=0;$i<count($rowsArrayDisplay);$i++){
		$itemArray=explode("\t",trim($rowsArrayDisplay[$i]));
           		if ($itemArray[4]<>"") {
				$thislink=$itemArray[4];
	   		} else {
				$thislink="?section=".$section."&id=".$itemArray[0];
	  		}
//		print("<tr><td><a href=?section=$section&id=".$itemArray[0].">".getLang($itemArray[1])."</a></td></tr>");
//		print("<tr><td align=left valign=center class=lMenu style=\"cursor:pointer\" onmouseover=\"javascript:this.className='lMenuOver';\" onmouseout=\"javascript:this.className='lMenu';\" onClick=\"javascript:document.location.href='?section=Top&id=".$itemArray[0]."'\"><a href=?section=$section&id=".$itemArray[0].">".getLang($itemArray[1])."</a></td></tr>");
		print("<tr><td align=left valign=center class=lMenu style=\"cursor:pointer\" onmouseover=\"javascript:this.className='lMenuOver';\" onmouseout=\"javascript:this.className='lMenu';\" onClick=\"javascript:document.location.href='".$thislink."'\">".getLang($itemArray[1])."</td></tr>");
	
	}
        print("</table>");
}
?>