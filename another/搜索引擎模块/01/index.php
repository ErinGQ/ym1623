<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<link href="./css/style.css" rel="stylesheet">
<title>ȫ����ȫ������������</title>
</head>
<body>
<script language="javascript">
function check(){
	if(myform.keyword.value==""){
		alert("�������ѯ�ؼ��֣�");myform.keyword.focus();return false;
	}
	if((myform.keyword.value.length)>100){
		alert("������ؼ��ֹ����������100���ַ��ڣ�");myform.keyword.focus();return false;
	}
}
</script>
<br><br><br><br>
<br>
<br><br><br>
<a href="./" target="_self"><img src="images/kuaikuaisou.gif" border="0" width="216" height="137"></a><br>
<br>
<table width="592" border="0" cellspacing="0" cellpadding="0" height="16">
<tr align="center">
<td width="592" height="9">
 <table width="600" border="0" cellspacing="0" cellpadding="0" height="23">
<tr align="center">
<td width="49" class="su0" id="su99s1" onClick="so99su(1)">վ��</td>
<td width="1"></td><td width="49" class="su1" id="su99s2" onClick="so99su(2)"><a href="site.php" target="_self">��ҳ</a></td>
<td width="1"></td><td width="49" class="su1" id="su99s3" onClick="so99su(3)">����</td>
<td width="1"></td><td width="49" class="su1" id="su99s4" onClick="so99su(4)">����</td>
<td width="1"></td><td width="49" class="su1" id="su99s5" onClick="so99su(5)">ͼƬ</td>
<td width="1"></td><td width="49" class="su1" id="su99s6" onClick="so99su(6)">��Ӱ</td>
<td width="1"></td><td width="52" class="su1" id="su99s7" onClick="so99su(7)">����</td>
<td width="1"></td><td width="52" class="su1" id="su99s8" onClick="so99su(8)">B T</td>          
<td width="1"></td><td width="52" class="su1" id="su99s9" onClick="so99su(9)">��̳</td>
<td width="1"></td><td width="49" class="su1"id="su99s10" onClick="so99su(10)">ͼ��</td>
<td width="1"></td><td width="49" class="su1"id="su99s11" onClick="so99su(11)">����</td>
<td width="1"></td></tr></table>
</td>           
</tr>
<form name="myform" method="post" action="search.php" target="_self">
<tr align="center">
<td height="96" background="images/bg2.gif" style="border: 1 solid #0882E9">
  <p align="center">
	<input type="hidden"  name="shq" value="84" >
    <input name="keyword" type="text"  id="keyword" size="60" maxlength="100"  onMouseOver="this.focus()" onFocus="this.select()" class="txt"/>
    &nbsp;
    <input name="submit" type="submit"  value="��������" class="btn" onClick="return check();">
    <a href="adva_search.php">�߼�����&gt;&gt;</a></p>

  <p align="center">&nbsp;</p>                       
 </td>                                                         
</tr>
</form> 
</table>
<p><a href="./manage/admin/login.php">&nbsp;</a><a href="http://www.mrbccd.com">��̴ʵ�</a>&nbsp;|&nbsp;<a onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.mrbccd.com')" href="http://www.mrbccd.com">�ѿ������Ϊ��ҳ</a>&nbsp;|&nbsp;<a href="http://www.mrbccd.com">���ڿ����</a></p>
<p><span class="STYLE1">Copyright&nbsp;&copy;&nbsp;�������վ www.mrbccd.com All Rights Reserved!</span><span class="STYLE1">&nbsp;��ICP�� 12345678</span></p>
<p>
  <script>function so99su(n){
var KeyNo=Math.floor(6*Math.random());
for(i=1;i<12;i++){
	eval("document.getElementById('su99s"+i+"').className='su1'");
}
	eval("document.getElementById('su99s"+n+"').className='su0'");
if(n==1){myform.shq.value="zn";}
else if(n==2){myform.shq.value="wy";}
else if(n==3){myform.shq.value="yy";}
else if(n==4){myform.shq.value="ls";}
else if(n==5){myform.shq.value="tp";}
else if(n==6){myform.shq.value="dy";}
else if(n==7){myform.shq.value="new";}
else if(n==8){myform.shq.value="bt";}
else if(n==9){myform.shq.value="bbs";}
else if(n==10){myform.shq.value="book";}
else if(n==11){myform.shq.value="more";}
}
</script> 
</p>
</body>
</html>
