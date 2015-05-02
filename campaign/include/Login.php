<img src="images/shim.gif" width=10 height=1 border=0><br>

<span class=SectionTitle><?=getLabel("MemberLogin")?></span><br><br>

<script language="javascript">
<!--
function checkform() {
	if (document.f1.username.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("Username")?>!");
		return false;
	}
	if (document.f1.password.value.length==0) {
		alert("<?=getLabel("PleaseEnter")?><?=getLabel("Password")?>!");
		return false;
	}
}
//-->
</script>
<form action="?section=Top&id=<?=$id?>" name=f1 method=post onSubmit="return checkform()">
<?=getLabel("Username")?>: <input type=text size=15 name=username> <br>
<?=getLabel("Password")?>: <input type=password size=15 name=password> <br>
<input type=submit value="Login">
</form>
