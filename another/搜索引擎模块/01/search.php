<html>
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
include_once("splitword.php");
include_once("common/function.php");
if($_POST[submit]!=""){
$keyword=$_POST[keyword];
}
if($_POST[submit2]!=""){						//�ڲ�ѯ����в���

	$h_keyword=$hide_keyword;			//��ȡԭʼ��ֵ	
	$keynew=$keyword;
	$h_keyword.=$keyword;				//��ȡ��ֵ+��ֵ
 	$keyword=$h_keyword;				//�����µ�ֵ����keyword
}
$yuan=trim($keyword);
$tt= $yuan;

$str=gl($tt);

$sp = new SplitWord();
//������Ҫ��ʼ��ʱ�ĵط���������ҳ���ڿ�ͷ
$time_start = getmicrotime();
$sp->SplitRMM($str);
$tt=$sp->SplitRMM($str);

?>
<?php
	require_once("common/db_mysql.class.php");
	$DB = new DB_MySQL;				//��������
	$str=array(" ","");				//����һ������
	$cc=str_replace($str,"",$tt);	//ȥ���ַ����еĿո�
	if(substr($cc,0,2)=="��"){
		$cc= substr($cc,2);			//ȥ��ǰ��ġ���������
	}
	if(substr($cc,-2,2)=="��"){
		$cc= substr($cc,0,-2);		//ȥ������ġ���������
	}
	
	if(substr($cc,0,2)=="��" && substr($cc,-2,2)=="��"){
		$a= substr($cc,2);			//ȥ��ǰ��ġ���������
		$cc= substr($a,0,-2);		//ȥ������ġ���������
	}
		$newstr = explode("��",$cc);			//Ӧ��explode()�������ַ���ת��������
		if(count($newstr)==1){					//��������Ԫ�ظ���Ϊ1�����򰴵����������в�ѯ
			 $sql = "select * from tb_info where title like '%".$newstr[0]."%' or content like '%".$newstr[0]."%'order by id desc ";
		}else{
			if($_POST[submit2]!=""){					//�ڲ�ѯ����в���
				//���β�ѯ�ִ�
				$keynew=gl($keynew);			//���˱�����
				$sp1 = new SplitWord();
				$sp1->SplitRMM($keynew);
				$tc=$sp1->SplitRMM($keynew);
					$cc1=dunhao($tc);
					$newstr1 = explode("��",$cc1);		//Ӧ��explode()�������ַ���ת��������
				/***************************************************************************************/
				//���β��ҵ��㷨
				$k_sql="select k_id from tb_temp";
				$info = $DB->fetch_one_array($k_sql);
				$kid=substr($info['k_id'],0,-1);				//ȥ�����һ����@��
				$k_id=explode('@',$kid);						//��ID��ת��������
				$sql = "select * from tb_info ";				//��ѯ��Ϣ���е�����
				while(list($name,$value)=each($k_id)){			//��������
				   $a.="$value".",";
				}
				$a= substr($a,0,-1);							//ȥ�����һ����,������
				//ʹ��in�ؼ��ֲ�ѯ����ID�Ŷ�Ӧ����Ϣ
				$sql .= " where id in(".$a.") ";				//ָ���������ֵ	
						
				$sql2=" and (";
				for($i=0;$i<count($newstr1);$i++){
					$sql0.=" title like '%".trim($newstr1[$i])."%'"." or";	
				}
				for($j=0;$j<count($newstr1);$j++){
					$sql1.=" content like '%".trim($newstr1[$j])."%'"." and";	
				}
				$sql1=substr($sql1,0,-3);						//ȥ�����һ����and��
				$sql3=")";
				$sql.=$sql2.$sql0.$sql1.$sql3. " order by id desc";
			}
		
			else{
			//�ϲ���ѯ�����
			for($i=0;$i<count($newstr);$i++){
				$sql0.=" title like '%".trim($newstr[$i])."%'"." or";	
			}
			for($j=0;$j<count($newstr);$j++){
				$sql1.=" content like '%".trim($newstr[$j])."%'"." or";	
			}
			$sql1=substr($sql1,0,-3);				//ȥ�����һ����or��		
			$sql="select * from tb_info where".$sql0.$sql1." order by id desc";
			}
	}	
	
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
	$time_end = getmicrotime();				//������ʱ
	$t0 = $time_end - $time_start;			//������ʱ
	?>
<TABLE cellSpacing=1 cellPadding=0 width="100%" bgColor=#e5ecf9  style="BORDER-RIGHT: #dddddd 1px solid; BORDER-TOP: #ffffff  1px solid; BORDER-LEFT: #ffffff 1px solid; BORDER-BOTTOM: #dddddd 1px solid">
  <tr>
    <td width="62%" border=1 >&nbsp;����ѯ�Ĺؼ����ǣ�<?php echo $keyword;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "�ִ�:  "; foreach( $newstr as $link) { ?> <a href="so.php?keyword=<?php echo urlencode($link); ?>"><?php echo $link." ";} ?></a></td>
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
		  <?php
		 	for($n=0;$n<count($newstr);$n++){
				 $title= str_ireplace($newstr[$n],"<font color='#FF0000'>".$newstr[$n]."</font>",$title);
			}
		   echo chinesesubstr($title,0,80);
		   if(strlen($title)>80){ echo "...";}
		  ?>
		  </a></td>
        </tr>
        <tr >
          <td >&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
			for($k=0;$k<count($newstr);$k++){
				 $content= str_ireplace($newstr[$k],"<font color='#FF0000'>".$newstr[$k]."</font>",$content);
			}
			echo chinesesubstr($content,0,600);	  
			  if(strlen($content)>600){echo "...";} ?>
          </td>
        </tr>
      </table>
      <p>
        <?php
		$key0.=$id.'@';
		}
		$key00=$key0;
		 if($row_count_sum>0){
		/* ����ѯ�Ĺؼ��ִ洢����ʱ����*/
		$ins="update tb_temp set k_id='".$key00."'";
		$DB->query($ins);
		}
		/* *************************  */
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
          <th align="center" bgcolor="#E5ECF9">
            &nbsp;&nbsp; [��ҳ���]</th>
        </tr>
        <tr height='26px'>
          <td align="center" bgcolor="#E5ECF9">
		  <?php
			if(!$is_first){
			?>
            <a href="./search.php?page_num=1&keyword=<?php echo $keyword;?>">��һҳ</a> <a href="./search.php?page_num=<?php echo ($page_num-1);?>&keyword=<?php echo $keyword;?>">��һҳ</a>
            <?php
			}
			else{
			?>
            ��һҳ&nbsp;&nbsp;��һҳ
            <?php
			}
			if(!$is_last){
			?>
            <a href="./search.php?page_num=<?php echo ($page_num+1);?>&keyword=<?php echo $keyword;?>">��һҳ</a> <a href="./search.php?page_num=<?php echo $page_count;?>&keyword=<?php echo $keyword;?>">���һҳ</a>
            <?php
			}
			else
			{
			?>
            ��һҳ&nbsp;&nbsp;���һҳ
            <?php
			}
			?>		  </td>
        </tr>
      </table>
		<?php
		}else{
		 $z_null="&nbsp;&nbsp;&nbsp;&nbsp;";
		 if($row_count_sum==0){echo  $z_null."��Ǹ��û�м�������&nbsp;<font color='FF0000'>".$yuan."</font>&nbsp;��ص���ҳ��Ϣ";
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
