<?php
    include_once("include/fso.class.php");
      $fso = new CtbClass;
	    //�½�һ���ļ������� 
	    $fso->file = "config.ini";
	    //ָ�����õ��ļ�
	    $config_ini = $fso->read_file();
	    //�������ļ�---��һά���鷵���ļ�����
	    echo $write_page_end = $config_ini[0];
	    //�������ҳ��ҳ��
	    echo $write_id_end = $config_ini[1];
?>