<?php
require_once("./common/db_mysql.class.php");
$id=$_GET[id];
$DB = new DB_MySQL;
$sql = "select * from tb_info where  id='".$id."'";
$info = $DB->fetch_one_array($sql);
?>
<link rel="stylesheet" href="./css/style.css" />
<style type="text/css">
<!--
.STYLE6 {color: #FF0000}
-->
</style>
<table width="950" border="0" align="center">
  <tr>
    <td height="203" align="right" valign="top" background="images/topic.jpg"><a href="javascript:;" onclick="window.external.AddFavorite(location.href,document.title);return false"><span class="STYLE6"><br />
    ��ӱ�ҳ���ղؼ�</span>&nbsp;&nbsp;</a></td>
  </tr>
</table>

<table width=100% height="600" border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td valign="top"><table width="950" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:15px; margin-right:15px">
        <tr>
          <td width="831" height="30" bgcolor="#E5ECF9" class="alink">&nbsp;&nbsp;&nbsp;<?php echo $info['title'];?></td>
        </tr>
        <tr >
          <td  style="margin-left:60px; margin-right:60px; margin-top:30px; margin-bottom:30px; line-height:20px">&nbsp;<br /> &nbsp;&nbsp;&nbsp;
            <?php  echo $info['content']; ?><br /><br />
			</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width=100% border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td height=30 align=center><font color="#7777CC">�������</font> <a href=http://www.mrbccd.com><font color=#7777CC>&copy; 2008&nbsp;&nbsp;������ϵ����Ѹ�������ָ���Զ������Ľ���������������޳ɱ�������վ�����ݻ�����</font></a>&nbsp;</td>
  </tr>
</table>
