<link rel="stylesheet" href="./css/style.css" />
<style type="text/css">
<!--
.STYLE13 {color: #FF3399}
.STYLE16 {color: #FF0000}
.STYLE20 {color: #0066FF}
.STYLE21 {color: #006600}
-->
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="96%" align="left">
	<?php require_once("top.php");?>
	</td>
  </tr>
</table>
<?php
require("common/function.php");
if($_GET){
$keyword=$_GET[keyword];
}
$newstr =urldecode(trim($_GET[keyword]));
//������Ҫ��ʼ��ʱ�ĵط���������ҳ���ڿ�ͷ
$time_start = getmicrotime();
?>
<?php
	require_once("./common/db_mysql.class.php");
	$DB = new DB_MySQL;
	$sql = "select * from tb_info where title like '%".$newstr."%' or content like '%".$newstr."%'order by id desc ";
	$DB->query($sql);
	
	if($_GET){
		//�õ�Ҫ��ȡ��ҳ��
		$page_num = $_GET['page_num']? $_GET['page_num']: 1;
	}
	else{
		//�״ν���ʱ,ҳ��Ϊ1
		$page_num = 1;
	}
	
	//�õ��ܼ�¼��
	$DB->query($sql);
	$row_count_sum = $DB->get_rows();
	$row_count_sum;
	//ÿҳ��¼��,����ʹ��Ĭ��ֵ����ֱ��ָ��ֵ
	$row_per_page = 6;
	//��ҳ��
	$page_count = ceil($row_count_sum/$row_per_page);
	//�ж��Ƿ�Ϊ��һҳ�������һҳ
	$is_first = (1 == $page_num) ? 1 : 0;
	$is_last = ($page_num == $page_count) ? 1 : 0;
	//��ѯ��ʼ��λ��
	$start_row = ($page_num-1) * $row_per_page;
	//ΪSQL������limit�Ӿ�
	$sql .= " limit $start_row,$row_per_page";
	//ִ�в�ѯ
	$DB->query($sql);
	$res = $DB->get_rows_array();
	//���������
	$rows_count=count($res);
	//��ѯ�����ϵͳ�ĵ�ǰʱ��
	$time_end = getmicrotime();
	$t0 = $time_end - $time_start;
	?>
<TABLE cellSpacing=1 cellPadding=0 width="100%" bgColor=#e5ecf9  style="BORDER-RIGHT: #dddddd 1px solid; BORDER-TOP: #ffffff  1px solid; BORDER-LEFT: #ffffff 1px solid; BORDER-BOTTOM: #dddddd 1px solid">
  <tr>
    <td width="62%" border=1 >&nbsp;����ѯ�Ĺؼ����ǣ�<?php echo $keyword;?></td>
    <td width="22%" border=1 >����ѣ��ҵ������ҳԼ��&nbsp;<font  color="#AA0066"><?php echo $row_count_sum;?></font>&nbsp;��ƪ</td>
    <td width="16%" border=1 ><?php echo "��ʱ�� $t0 ��";?></td>
  </tr>
</table>
<table width=100% height="600" border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td valign="top"><br /><p>
        <?php
		for($i=0;$i<$rows_count;$i++){
			$id=$res[$i]['id'];			//ID��
			$title=$res[$i]['title'];	//����
			$content = $res[$i]['content'];	//����
		?>
      </p>
      <table width="831" border="0" cellpadding="0" cellspacing="0" style="margin-left:15px; margin-right:15px">
        <tr>
          <td width="831" height="23" class="alink">&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="lookinfo.php?id=<?php echo $id; ?>" target="_blank">
		  <?php echo chinesesubstr(str_ireplace($newstr,"<font color='#FF0000'>".$newstr."</font>",$title),0,80);if(strlen($title)>80){ echo "...";}?>
		  </a></td>
        </tr>
        <tr >
          <td >&nbsp;&nbsp;&nbsp;&nbsp;
            <?php  echo chinesesubstr(str_ireplace($newstr,"<font color='#FF0000'>".$newstr."</font>",$content),0,500);	if(strlen($content)>500){echo "...";} ?>
          </td>
        </tr>
      </table>
      <p>
        <?php
		}
	  ?></p>
      <table width="100%" border="0">
        <tr>
          <td height="30">&nbsp;</td>
        </tr>
      </table>
	  <?php 
	  if($row_count_sum>0){
	  ?>
      <table width="850" border="0" cellpadding="2" cellspacing="1" bgcolor="#99CCCC" style="margin-left:15px; margin-right:15px">
        <tr height='26px' align="right">
          <th align="center" bgcolor="#E5ECF9"><!--  ��ҳ��ʾ�������� -->
            &nbsp;&nbsp; [��ҳ���]</th>
        </tr>
        <tr height='26px'>
          <td align="center" bgcolor="#E5ECF9">
		  <?php
			if(!$is_first){
			?>
            <a href="./so.php?page_num=1&keyword=<?php echo $keyword;?>">��һҳ</a> <a href="./so.php?page_num=<?php echo ($page_num-1); ?>&keyword=<?php echo $keyword;?>">��һҳ</a>
            <?php
			}
			else{
			?>
            ��һҳ&nbsp;&nbsp;��һҳ
            <?php
			}
			if(!$is_last){
			?>
            <a href="./so.php?page_num=<?php echo ($page_num+1); ?>&keyword=<?php echo $keyword;?>">��һҳ</a> <a href="./so.php?page_num=<?php echo $page_count; ?>&keyword=<?php echo $keyword;?>">���һҳ</a>
            <?php
			}
			else
			{
			?>
            ��һҳ&nbsp;&nbsp;���һҳ
            <?php
			}
			?>
		  </td>
        </tr>
      </table>
		<?php
		 }else{
		 $z_null="&nbsp;&nbsp;&nbsp;&nbsp;";
		 if($row_count_sum==0){echo  $z_null."��Ǹ��û�м�������&nbsp;<font color='FF0000'>".$newstr."</font>&nbsp;��ص���ҳ��Ϣ";
		 echo "<br><br><br>";
		 echo  $z_null."����� ��������<br>";
		 echo  $z_null."�� �鿴����������Ƿ�����<br>";
		 echo  $z_null."�� ȥ�����ܲ���Ҫ���ִʣ��磺 '��'��'��'��'��' ��<br>";
		}
		}
		?>
      </td>
  </tr>
</table>
<table width=100% border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td height=30 align=center><font color="#7777CC">�������</font> <a href=http://www.mrbccd.com><font color=#7777CC>&copy; 2008&nbsp;&nbsp;������ϵ����Ѹ�������ָ���Զ������Ľ���������������޳ɱ�������վ�����ݻ�����</font></a>&nbsp;</td>
  </tr>
</table>
