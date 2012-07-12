<?php

	/**
	 * ���ݿⱸ�ݳ���
	 *
	 * @author������
	 * @version��1.0
	 * @lastupdate��2010-7-19
	 *
	 */

	include("config/config.php");
	include("includes/dbbackup.class.php");
	include("includes/msg.class.php");
	$dbbackup = new dbbackup($dbhost, $dbuser, $dbpwd, $dbname);
	$msg = new msg();

	$bakfile = $dbbackup->get_backup();					//��ȡ�����ļ�
	if($_GET['fn']){
		if($dbbackup->import($_GET['fn'])){				//��������
			$str = "��ϲ��<br>���������Ѿ��ɹ����룡";					//��ʾ��Ϣ
			$msg->show_msg($str,'import.php','export.php');			//��ʾ����ɹ�
		}
	}
	//ɾ�������ļ�
	if($_POST['sub']){
		echo $dbbackup->del($_POST['choice'])? $msg->show_msg("��ϲ��<br>�����ļ���ɾ���ɹ�!",'import.php','export.php') : $msg->show_msg("ɾ��ʧ��!",'import.php','import.php');
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>powered by ����</title>
<style type="text/css">
body{ margin:0px; padding:0px;}
table{ border: 1px solid #EDEFF3;border-collapse:collapse; margin-bottom:50px;}
td{ font:normal 12px/17px Arial;padding:7px;}
.selected{background:#FEF1DA;}
.bg{ background: #F2F7F9;}
a{ color:#000;}
</style>
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
		$('tbody tr td input').click(function() {
            if ($(this).parent().parent().hasClass('selected')) {
                 $(this).parent().parent()
                    .removeClass('selected')
                    //.find(':checkbox').attr('checked',false);
            }else{
                $(this).parent().parent()
                    .addClass('selected')
                    //.find(':checkbox').attr('checked',true);
            }
        });
        // �����ѡ��Ĭ���������ѡ��ģ����ɫ.
        // $('table :checkbox:checked').parent().parent().addClass('selected');
        //��:
        $('table :checkbox:checked').parents("tr").addClass('selected');
        //$('tbody>tr:has(:checked)').addClass('selected');

		//ȫѡ��ѡ
		$("#CheckAll").toggle(function(){
			$(":checkbox").attr('checked',true);
			$(".t").addClass('selected');
		},function(){
			$(":checkbox").attr('checked',false);
			$(".t").removeClass('selected');
		});

		//��껬����񱳾��л���ɫ
		$('.hover').hover(function(){
			$(this).find("td").addClass('bg');
		},function(){
			$(this).find("td").removeClass('bg');
		})
});

//�ж��Ƿ�ѡ���˲�������
function Sub(form){
	var j = 0;
	for(var i=0; i<form.elements.length; i++){
		if(form.elements[i].name == "choice[]"){
			if(form.elements[i].checked){
				j++;
			}
		}
	}
	if(j == 0){
		alert("��ѡ���������");
		return false;
	}else{
		//ȷ���Ƿ�Ҫɾ������
		var r = confirm("�˹��ܲ��ɻָ�,��ȷ��Ҫɾ��ѡ�еı����ļ���");
		return r == true ? true : false;
	}
}

//ȷ���Ƿ�Ҫ��������
function Confirm(){
	var r = confirm("���ݻָ����ܽ�����ԭ��������,��ȷ��Ҫ���뱸��������");
	return r == true ? true : false;
}
</script>
</head>

<body>
<form name="myform" method="post" action="">
  <table width="90%" align="center">
        <tbody>
            <tr><td style="font-weight:bold; background:#DAEDF5;">�����˵�</td></tr>
            <tr><td><a href="export.php">��������</a> <a href="import.php">��ԭ����</a></td></tr>
        </tbody>
  </table>

  <table width="90%" align="center">
        <tbody>
            <tr><td style="font-weight:bold; background:#DAEDF5">��ʾ��Ϣ</td></tr>
            <tr>
            	<td style="padding:30px;">
            	�������ڻָ��������ݵ�ͬʱ,������ԭ������,��ȷ���Ƿ���Ҫ�ָ�,�������������ʧ��<br /><br />
				���һ�������ļ��ж���־���ֻ����ѡһ�������ļ����룬������Զ����������־�
		        </td>
            </tr>
        </tbody>
  </table>

  <table width="90%" align="center" style="margin-bottom:25px;">
        <tbody>
            <tr><td colspan="6" style="font-weight:bold; background:#DAEDF5;">�����ļ�</td></tr>
            <tr>
            	<td width="5%" align="center" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">ID</td>
                <td width="25%" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">�ļ���</td>
                <td width="15%" align="center" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">����ʱ��</td>
                <td width="15%" align="center" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">���</td>
                <td width="20%" align="center" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">����</td>
                <td width="10%" align="center" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">ɾ</td>
            </tr>
            <?php
				$i = 1;
				foreach($bakfile as $tb){
			?>
            <tr class="hover">
            	<td class="t" width="5%" align="center" style="border-bottom:1px solid #EDEFF3" ><?php echo $i; $i++; ?></td>
            	<td class="t" width="25%" style="border-bottom:1px solid #EDEFF3" ><?php echo $tb; ?></td>

                <td class="t" width="15%" align="center" style="border-bottom:1px solid #EDEFF3" >
                <?php
                	//ȡ�ñ���ʱ��
			  		if(!preg_match("/_part/", $tb)){
						$str = explode(".", $tb);
						$time = substr($str[0],-10);
						//�������ڽű�����������/ʱ�亯����Ĭ��ʱ����
						Date_default_timezone_set("PRC");//
						echo date("Y-m-d h:i",$time);
			  		}else{
			  			//�־�
			  			$str = explode("_part", $tb);
						$time = substr($str[0],-10);
						//�������ڽű�����������/ʱ�亯����Ĭ��ʱ����
						Date_default_timezone_set("PRC");//
						echo date("Y-m-d h:i",$time);
			  		}
                ?>
                </td>

                <td class="t" width="15%" align="center" style="border-bottom:1px solid #EDEFF3" >
                <?php
			  		//ȡ�־��
			  		if(!preg_match("/_part/", $tb)){
			  			echo "1";
			  		}else{
			  			$str = explode(".", $tb);
						echo substr($str[0],-1);
			  		}
		  		?>
                </td>

                <td class="t" width="20%" align="center" style="border-bottom:1px solid #EDEFF3" ><a href="?fn=<?php echo $tb; ?>" onclick="return Confirm()">����</a></td>
                <td class="t" width="10%" align="center" style="border-bottom:1px solid #EDEFF3" ><input type="checkbox" name="choice[]" value="<?php echo $tb; ?>" /></td>
            </tr>
            <?php
				}
			?>
        </tbody>
    </table>

    <table width="90%" align="center" style="border:none">
        <tbody>
            <tr align="center">
            	<td colspan="3" bgcolor="#FFFFFF" style="padding:0px;">
            	<input type="button" name="checkall" value="ȫѡ" style="width:75px; height:28px; background:#F2F2F2; border:1px solid #333; font-weight:bold; color: #666; cursor:pointer;" id="CheckAll" />
            	<input type="submit" name="sub" value="ɾ������" style="width:75px; height:28px; background:#ffb62b; border:1px solid #333; font-weight:bold; color:#FFF; cursor:pointer;" onclick="return Sub(this.form)" />
            	</td>
            </tr>
        </tbody>
  	</table>
</form>
</body>
</html>
