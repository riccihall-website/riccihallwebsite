<?
function submitabstract($dbname){

global $dbpath;
$dbname="SubmitAbstract";
$filename=$dbname.".txt";
$dir="./upload/$dbname/";
$ipath="http://www.hkos.org.hk/revamp/upload/$dbname/";

if ($_REQUEST['action']=="upload") {  // upload file

//print($dir.$temptimestamp.$_FILES['upfile']['name'].$_REQUEST['Name'].$_REQUEST['Email']);	
	$temptimestamp=date("YmdGis");
	if ($_FILES['upfile']['name']<>"" && $_REQUEST['Name']<>"" && $_REQUEST['Email']<>"") {
		// save file if upload exists			
		move_uploaded_file($_FILES['upfile']['tmp_name'],$dir.$temptimestamp.$_FILES['upfile']['name']);

		// send email
		//$to      = 'siuholeung@hotmail.com'; 
		$to      = getSetting("Email_ASM");
		$headers = 'From: abstract@hkos.org.hk';
		$subject = 'ASM Abstract Online Submit Notice';
		$message .= "\nName: ".stripslashes($_REQUEST['Name']);
		$message .= "\nEmail: ".stripslashes($_REQUEST['Email']);
		$message .= "\nPhone: ".stripslashes($_REQUEST['Phone']);
		$message .= "\nFile: ".$ipath.$temptimestamp.$_FILES['upfile']['name'];
		//$message=iconv("big5", "UTF-8", $message);
		if ($to) {
			mail($to, $subject, $message, $headers);
		}

		// save record
		$newline=getTableID($dbname)."\t".stripslashes($_REQUEST['Name'])."\t".stripslashes($_REQUEST['Email'])."\t".stripslashes($_REQUEST['Phone'])."\t".$temptimestamp."\t".$temptimestamp.$_FILES['upfile']['name']."\n";
		$datafile=fopen($dbpath.$filename,"a");
		fwrite($datafile,$newline);
		fclose($datafile);

		print(getLabel("AbstractSuccess"));
		print("<br><font color=red>$temptimestamp</font>");
	} else {
			print(getLabel("AbstractFail"));
	}
	?><br><br><a href="<?=$link?>"><?=getLabel("Back")?></a><?

} elseif($_REQUEST['action']=="check") { // check previous

	$rowsArray=getRows($filename);

	for($i=0; $i<count($rowsArray);$i++) {
		$itemArray=explode("\t",trim($rowsArray[$i]));
		if ($itemArray[4]==$_REQUEST['code']) {
			$tempitemArray = $itemArray;
		}
	}

	?>	<table cellpadding=0 cellspacing=0 border=0 bgcolor=#000000 width=400><tr><td>
	  <table cellpadding=4 cellspacing=1 border=0 width="100%">
	<tr><td class=scorehead colspan=2>Check previous submission</td></tr>
	<tr><td nowrap class=score>Submission code </td><td nowrap class=score><?=$tempitemArray[4]?></td></tr>
	<tr><td nowrap class=score>Name </td><td nowrap class=score><?=$tempitemArray[1]?></td></tr>
	<tr><td nowrap class=score>Email </td><td nowrap class=score><?=$tempitemArray[2]?></td></tr>
	<tr><td nowrap class=score>Phone </td><td nowrap class=score><?=$tempitemArray[3]?></td></tr>
	<tr><td nowrap class=score>File </td><td nowrap class=score><a href="<?print($dir.$tempitemArray[5]);?>" target=_blank><?=$tempitemArray[5]?></a></td></tr>
	  </table></td></tr>
	</table><P><a href="<?=$link?>"><?=getLabel("Back")?></a><?

} else { // print forms
?>
<script language="JavaScript">
<!--
function checkform() {

	if (document.myform.name.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("Name")?>!");
		return false;
	}
	if (document.myform.email.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("Email")?>!");
		return false;
	}
	if (document.myform.upfile.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("File")?>!");
		return false;
	} 
}

function checkform2() {

	if (document.myform2.code.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("SubmissionCode")?>!");
		return false;
	}

}
//-->
</script>

Download <a href="upload/Top/<?print(getSetting("Form_Abstract"));?>" target=_blank>Abstract Form</a><P>

You can return the abstract:
<ol>
<li>by e-mail the file to <a href="mailto:<?print(getSetting("Email_ASM"));?>?Subject=Submit Abstract"><?print(getSetting("Email_ASM"));?></a></li>
<li>by the upload form below</li>
</ol>
A reply letter will be sent to you at once, and a confirmation number will be issued to your abstract. <br> Please call Vicki if you cannot receive your confirmation number within 2 working days.  Thanks.
<P>
Enquiry Tel: <?print(getSetting("Phone"));?> 

<form name=myform method=post action="<?print($link)?>" onSubmit="return checkform();"  enctype="multipart/form-data">
	<table cellpadding=0 cellspacing=0 border=0 bgcolor=#000000 width=400><tr><td>
	  <table cellpadding=4 cellspacing=1 border=0 width="100%">
<tr><td class=scorehead colspan=2>Upload abstract file</td></tr>

<tr><td nowrap class=score>Name <font color=red>*</font></td><td nowrap class=score><input type=text size=15 name=Name></td></tr>
<tr><td nowrap class=score>E-mail <font color=red>*</font></td><td nowrap class=score><input type=text size=15 name=Email></td></tr>
<tr><td nowrap class=score>Phone </td><td nowrap class=score><input type=text size=15 name=Phone></td></tr>
<tr><td nowrap class=score valign=top>File <font color=red>*</font></td><td nowrap class=score><input type=file name=upfile> file size &lt; 1MB </td></tr>
<tr><td nowrap class=score colspan=2 align=center><input type=submit value="Submit"> <input type=reset value="Reset"><input type=hidden name=action value=upload></td></tr>

	  </table></td></tr>
	</table><P>
<input type=hidden name=act value=sub>
</form>
              <br>
<form name=myform2 method=post action="<?print($link)?>" onSubmit="return checkform2();">
	<table cellpadding=0 cellspacing=0 border=0 bgcolor=#000000 width=400><tr><td>
	  <table cellpadding=4 cellspacing=1 border=0 width="100%">
<tr><td class=scorehead colspan=2>Check previous submission</td></tr>

<tr><td nowrap class=score>Submission code <font color=red>*</font></td><td nowrap class=score><input type=text size=15 name=code></td></tr>
<tr><td nowrap class=score colspan=2 align=center><input type=submit value="Submit"> <input type=reset value="Reset"><input type=hidden name=action value=check></td></tr>

	  </table></td></tr>
	</table><P>
<input type=hidden name=act value=check>
</form>
If you forgot your submission code, please email us at <a href="mailto:<?print(getSetting("Email"));?>"><?print(getSetting("Email"));?></a> for assistance.
  
<?}
}?>