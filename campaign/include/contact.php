<?
function contact() {
global $link;
?>
<script>
<!--
function checkform() {
	if (document.f1.Name.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("Name")?>");
		return false;
	}
	if (document.f1.Email.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("Email")?>");
		return false;
	}
	if (document.f1.Message.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("Message")?>");
		return false;
	}
}
//-->
</script>
						
<?
if ($_REQUEST['act']=="submit") {
//$to      = 'siuholeung@hotmail.com'; 
$to      = getSetting("Email_contact_form");
$headers = 'From: '.getSetting("Email_contact_form");
$subject = 'Contact Form '.getSetting("SiteName");
$message .= "\nName: ".stripslashes($_REQUEST['Name']);
$message .= "\nPhone: ".stripslashes($_REQUEST['Phone']);
$message .= "\nEmail: ".stripslashes($_REQUEST['Email']);
$message .= "\nMessage: ".stripslashes($_REQUEST['Message']);
//$message=iconv("big5", "UTF-8", $message);
	if ($to) {
		mail($to, $subject, $message, $headers);
?>                              <table width="427" align="center" valign=middle>
                                  <tr>
                                    <td class="Main" align="center" valign=middle><?=getLabel("ContactSuccess")?></td>
                                  </tr>
                                </table>
<?
	} else {
?>                              <table width="427" align="center" valign=middle>
                                  <tr>
                                    <td class="Main" align="center" valign=middle><?=getLabel("ContactFail")?></td>
                                  </tr>
                                </table>
<?
	}

?><br><br><a href="<?=$link?>"><?=getLabel("Back")?></a><?
} else {
?>
		<form name="f1" method="post" action="<?=$link?>" onSubmit="return checkform();">
			<table cellspacing="0" cellpadding="0" border="0" bgcolor="#000000"><tr><td><table cellspacing="1" border="0" cellpadding="2" >
			<tr><td align="right" class=score><font color=red>*</font> <?=getLabel("Name")?>: </td> <td class=score><input name='Name' type='text' size='30'></td></tr>
			<tr><td align="right" class=score>  <?=getLabel("Phone")?>: </td> <td class=score><input name='Phone' type='text' size='30'></td></tr>
			<tr><td align="right" class=score><font color=red>*</font> <?=getLabel("Email")?>: </td> <td class=score><input name='Email' type='text' size='30'></td></tr>
			<tr><td align="right" class=score><font color=red>*</font> <?=getLabel("Message")?>: </td> <td class=score><textarea name='Message' cols=40 rows=5></textarea></td></tr>
			<tr><td colspan=2 align=center class=score><input type=submit><input type=reset><input type=hidden name=act value=submit></td></tr>
			</table></td></tr></table>
                 </form>
<?}
}
?>