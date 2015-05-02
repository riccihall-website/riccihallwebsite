<?
function showRow($name,$type,$value){
/////////////////////////// show row ////////////////////////////////
	global $section;
	global $dir;
	global $langArray;

	if(is_array($type)) {
		$typeArray=$type;
		$type=array_shift($typeArray);
	}

	switch ($type) {
	case "text":
	case "textCheck":
		$input="<input type=text name=\"$name\" id=\"$name\" size=60 value=\"$value\">";
		break;
	case "textMultiple":
	case "textMultipleCheck":
		$valueArray=explode("::",trim($value));
		$input="<input type=hidden name=\"$name\" id=\"$name\">";
		for($i=0;$i<count($langArray);$i++) {
			$input.="<input type=text name=\"$name"."$i\" id=\"$name"."$i\" size=50 value=\"$valueArray[$i]\"> ($langArray[$i])<br>\n";
		}
		break;
	case "hidden";
		$input="<input type=hidden name=\"$name\" id=\"$name\" value=\"$value\">";
		break;
	case "textArea":
	case "textAreaCheck":
		$input="<textarea name=\"$name\" id=\"$name\" cols=50 rows=10>$value</textarea>";
		break;
	case "textAreaMultiple":
	case "textAreaMultipleCheck":
		$valueArray=explode("::",trim($value));
		$input="<input type=hidden name=\"$name\" id=\"$name\">";
		for($i=0;$i<count($langArray);$i++) {
			$input.="<textarea name=\"$name"."$i\" id=\"$name"."$i\" cols=40 rows=5>$valueArray[$i]</textarea> ($langArray[$i])<br>\n";
		}
		break;
	case "radio":
	case "radioCheck":
		foreach($typeArray as $radio) {
			if ($radio == $value)
				$input.="<input type=radio name=\"$name\" id=\"$name\" value=\"$radio\" checked> $radio &nbsp;&nbsp;";
			else 
				$input.="<input type=radio name=\"$name\" id=\"$name\" value=\"$radio\"> $radio &nbsp;&nbsp;";
		}
		break;
	case "boxListCheck":
		$input="<input type=hidden id=\"$name\" name=\"$name\" value=\"\">";
		$valueArray=explode(",",trim($value));
		$rowsArray=getRows($typeArray[0]);
		foreach($rowsArray as $line) {
			$itemArray=explode("\t",trim($line));
			$thisname=$name.$itemArray[0];
			if ($valueArray[$itemArray[0]-1]=="Y")
				$input.="<input type=\"checkbox\" id=\"$thisname\" name=\"$thisname\" value=\"Y\" checked> $itemArray[1] &nbsp;&nbsp;";
			else
				$input.="<input type=\"checkbox\" id=\"$thisname\" name=\"$thisname\" value=\"Y\"> $itemArray[1] &nbsp;&nbsp;";
		}
		break;
	case "select":
	case "selectCheck":
$input="<select name=\"$name\" id=\"$name\" size=1>
<option value=''>==NONE==</option>
";
for($i=0; $i<count($typeArray);$i++) {
	if (ereg("&&",$typeArray[$i])){
		$tempselect=explode("&&",trim($typeArray[$i]));
		$typeArray[$i]=$tempselect[1];
		$typeValue=$tempselect[0];
	} else {
		$typeValue=$typeArray[$i];
	}
	if ($typeValue==$value) {
		$input.="<option value=\"$typeValue\" selected>$typeArray[$i]</option>\n";
	} else {
		$input.="<option value=\"$typeValue\">$typeArray[$i]</option>\n";
	}
}
$input.="</select>";
		break;
	case "file":
	case "fileCheck":
	case "image":
	case "imageCheck":					// set select box
$input="<select name=\"$name\" id=\"$name\" size=1>
<option value=''>==NONE==</option>
";
$imageArray=getDirectory($dir);					// get list of image file names from upload directory
for($i=0; $i<count($imageArray);$i++) {
	if ($imageArray[$i]==$value) {
		$input.="<option selected>$imageArray[$i]</option>\n";
	} else {
		$input.="<option>$imageArray[$i]</option>\n";
	}
}
$input.="</select>";
$input.=" &nbsp;&nbsp;&nbsp; <input type=file name=\"".$name."upfile\">";	// upload box


if($value) {							// show image or flash if file name found in db
	if (ereg(".swf",$value)) {
		$input.="<br><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"640\">
          <param name=\"movie\" value=\"$dir$value\">
          <param name=\"quality\" value=\"high\">
          <embed src=\"$dir$value\" quality=\"high\" width=\"640\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed>
</object>";
	} elseif (eregi(".gif",$value) || eregi(".jpg",$value) || eregi(".png",$value)) {
		$input.="<br><a href=\"$dir$value\" target=_blank><img src=\"$dir$value\" width=400 border=0></a>";
	} else {
		$input.="<br><a href=\"$dir$value\" target=_blank>$value</a>";
	}
}
		break;
	case "textImageCheck":
$input1="<input type=text name=\"".$name."1\" id=\"".$name."1\" size=30>";	// text box

$input2="<select name=\"$name\" id=\"$name\" size=1>
<option value=''>==NONE==</option>
";										// select box
$imageArray=getDirectory($dir);
for($i=0; $i<count($imageArray);$i++) {
	if ($imageArray[$i]==$value) {
		$input2.="<option selected>$imageArray[$i]</option>\n";
	} else {
		$input2.="<option>$imageArray[$i]</option>\n";
	}
}
$input2.="</select>";
$input2.=" &nbsp;&nbsp;&nbsp; <input type=file name=\"".$name."upfile\">";	// upload box

if($value) {
	if (ereg(".swf",$value)) {
		$input=$input2;
		$input.="<br><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"400\">
          <param name=\"movie\" value=\"$dir$value\">
          <param name=\"quality\" value=\"high\">
          <embed src=\".$dir$value\" quality=\"high\" width=\"400\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed>
</object>";
	} elseif(ereg(".jpg",$value)||ereg(".gif",$value)) {
		$input=$input2;
		$input.="<br><a href=\"$dir$value\" target=_blank><img src=\"$dir$value\" width=400 border=0></a>";
	} else {
		$input="<input type=text name=\"$name\" id=\"$name\" size=60 value=\"$value\">";
	}
} else {
	$input="$input1 &nbsp;&nbsp;&nbsp; $input2";
}
	break;
	default:
		$input="<input type=text name=\"$name\" id=\"$name\" size=60 value=\"$value\">";
		break;
	}
	if(ereg("Check",$type))
		$name.="<font color=red>*</font>";
	if($type=="hidden")
		print("$input\n");
	else
		print("<tr><td width=\"10%\" class=tablehead valign=top nowrap>$name</td><td width=\"90%\" bgcolor=ffffff>$input</td></tr>\n");
/////////////////////////// show row ////////////////////////////////
}

function showCheck($name,$type){
/////////////////////////// show check ////////////////////////////////
	global $langArray;
	if(is_array($type)) {
		$typeArray=$type;
		$type=array_shift($typeArray);
	}

	switch ($type) {
	case "textCheck":
		print("\tif (document.f1.".$name.".value.length==0) {\n");
		print("\t\talert(\"Please enter $name\");\n\t\treturn false;\n\t}\n");
		break;
	case "textMultipleCheck":
		print("\tif (document.f1.".$name."0.value.length==0) {\n");
		print("\t\talert(\"Please enter $name\");\n\t\treturn false;\n\t}\n");
	case "textMultiple":
		print("\t\tdocument.f1.$name.value=document.f1.".$name."0.value");
		for($i=1;$i<count($langArray);$i++) {
			print("+'::'+document.f1.".$name."$i.value");
		}
		print(";\n");
		break;
	case "textAreaCheck":
		print("\tif (document.f1.".$name.".value.length==0) {\n");
		print("\t\talert(\"Please enter $name\");\n\t\treturn false;\n\t}\n");
		break;
	case "textAreaMultipleCheck":
		print("\tif (document.f1.".$name."0.value.length==0) {\n");
		print("\t\talert(\"Please enter $name\");\n\t\treturn false;\n\t}\n");
	case "textAreaMultiple":
		print("\t\tdocument.f1.$name.value=document.f1.".$name."0.value");
		for($i=1;$i<count($langArray);$i++) {
			print("+'::'+document.f1.".$name."$i.value");
		}
		print(";\n");
		break;
	case "radioCheck":
		print("\tif (");
		for($i=0; $i<count($typeArray);$i++) {
			if ($i==0)
				print("document.f1.$name"."[$i].checked==0");
			else
				print(" && document.f1.$name"."[$i].checked==0");
		}
		print(") {\n");
		print("\t\talert(\"Please select $name\");\n\t\treturn false;\n\t}\n");
		break;
	case "boxListCheck":
		$rowsArray=getRows($typeArray[0]);
		$maxid=0;
		foreach($rowsArray as $line) {
			$itemArray=explode("\t",trim($line));
			if ($itemArray[0]>$maxid)
				$maxid=$itemArray[0];
		}
		print "		var dm='';\n";
		print "	for(i=1;i<=$maxid;i++) {
		if (i>1) dm=',';
		if (document.getElementById('$name'+i) && document.getElementById('$name'+i).checked) 
			document.getElementById('$name').value+=dm+'Y';
		else 
			document.getElementById('$name').value+=dm+'N';
	}\n";
		break;
	case "selectCheck":
		print("\tif (document.f1.$name.selectedIndex==0) {\n");
		print("\t\talert(\"Please select $name\");\n\t\treturn false;\n\t}\n");
		break;
	case "fileCheck":
	case "imageCheck":
		print("\tif (document.f1.$name.selectedIndex==0 && document.f1.$name"."upfile.value=='') {\n");
		print("\t\talert(\"Please select $name\");\n\t\treturn false;\n\t}\n");
		break;
	case "textImageCheck":
		print("\tif (document.f1.$name.selectedIndex==0 && document.f1.$name"."upfile.value=='' && document.f1.".$name."1.value=='') {\n");
		print("\t\talert(\"Please select image or enter $name\");\n\t\treturn false;\n\t}\n");
		//print("\tif ((document.f1.$name.selectedIndex>0 || document.f1.$name"."upfile.value) && document.f1.".$name."1.value) {\n");
		//print("\t\talert(\"Please either select image or enter $name\");\n\t\treturn false;\n\t}\n");
		print("\tif (document.f1.$name.selectedIndex==0 && document.f1.$name"."upfile.value=='') {\n");
		print("\t\tdocument.f1.$name.options[0].value=document.f1.".$name."1.value;\n\t}\n");
		//print("alert(document.f1.$name.options[0].value);");
		break;
	}
/////////////////////////// show check ////////////////////////////////
}
?>