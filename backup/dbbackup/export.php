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

	$tbs = $dbbackup->get_tb(); 									//��ȡ���ݿ����
	if($_POST['sub']){
			$data = $dbbackup->get_backupdata($_POST['choice']);	//��ȡ��������
			if($dbbackup->export($data)){							//��������
				$bakfn = $msg->get_fn($dbbackup->bakfn);			//ȡ�ñ����ļ���
				$str = "��ϲ��<br>���ݳɹ�,�����ļ�������dataĿ¼�£�" .		//��ʾ��Ϣ
						"<br>�����ļ�Ϊ<br>".$bakfn;
				$msg->show_msg($str,'export.php','import.php');	//��ʾ���ݳɹ�
			}
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
		}else{ return true;}
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
            	�����Ը����Լ�����Ҫѡ����Ҫ���ݵ����ݿ��,�����������ļ�����"���ݻָ�"���ܡ�<br /><br />
                Ϊ�����ݰ�ȫ,�����ļ��������ݿ��� + ʱ�����������,����������ݳ����趨�Ĵ�С,������Զ����÷־��ݹ��ܣ������ĵȴ�ֱ��������ʾȫ��������ɡ�
		        </td>
            </tr>
        </tbody>
  </table>

  <table width="90%" align="center" style="margin-bottom:25px;">
        <tbody>
            <tr><td colspan="3" style="font-weight:bold; background:#DAEDF5;">���ݿ��</td></tr>
            <tr>
            	<td width="5%" align="center" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">ID</td>
                <td width="85%" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">���ݿ��</td>
                <td width="10%" align="center" bgcolor="#ECFBFA" style="color:#090;border-bottom:1px solid #EDEFF3">ѡ��</td>
            </tr>

            <?php
				$i = 1;
				foreach($tbs as $tb){
			?>
            <tr class="hover">
            	<td class="t" width="5%" align="center" style="border-bottom:1px solid #EDEFF3"><?php echo $i; $i++; ?></td>
                <td class="t" width="85%"style="border-bottom:1px solid #EDEFF3"><?php echo $tb; ?></td>
                <td class="t" width="10%" align="center" style="border-bottom:1px solid #EDEFF3"><input type="checkbox" name="choice[]" value="<?php echo $tb; ?>" /></td>
            </tr>
     		<?php
				}
			?>

            <tr><td colspan="3" style="font-weight:bold; background:#DAEDF5;">�־���</td></tr>
            <tr><td colspan="3">ÿ���־��ļ�����Ĭ��Ϊ<b>2048</b>KB,�Զ������ֶ�����dbbackup.php�ļ�private $part����</td></tr>
        </tbody>
    </table>

    <table width="90%" align="center" style="border:none">
        <tbody>
            <tr align="center">
            	<td colspan="3" bgcolor="#FFFFFF" style="padding:0px;">
            	<input type="button" name="checkall" value="ȫѡ" style="width:75px; height:28px; background:#F2F2F2; border:1px solid #333; font-weight:bold; color: #666; cursor:pointer;" id="CheckAll" />
            	<input type="submit" name="sub" value="����" style="width:75px; height:28px; background:#ffb62b; border:1px solid #333; font-weight:bold; color:#FFF; cursor:pointer;" onclick="return Sub(this.form)" />
            	</td>
            </tr>
        </tbody>
  	</table>
</form>
</body>
</html>
