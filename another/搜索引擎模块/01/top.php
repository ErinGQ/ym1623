<link  href="./css/style.css" rel="stylesheet" />

<script language="javascript">
function check(){
	if(myform.keyword.value==""){
		alert("�������ѯ�ؼ��֣�");myform.keyword.focus();return false;
	}
	if((myform.keyword.value.length)>50){
		alert("������ؼ��ֹ����������50���ַ��ڣ�");myform.keyword.focus();return false;
	}
}
</script>
<title>��ȫ������������</title>
<form  name="myform"  method="post" action="search.php">
  <table width="954" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <td width="222" rowspan="2"><img border=0 src="images/kuaikuaisou.gif" width="216"  height="137" /></td>
      <td width="380" align="center"><input  name="keyword" id="keyword" size="50" onMouseOver="this.focus()" onFocus="this.select()" value="<?php echo $keyword;?>"/>
      <input type="hidden" name="hide_keyword"  value="<?php echo $keyword;?>"/>      </td>
      <td width="352"><input  name="submit" type="submit" value="�� ��" class="btn" onclick="return check();" />
        <input  name="submit2" type="submit" value="�������" class="btn" onclick="return check();"/>      </td>
    </tr>
  </table>
</form>
