<?php

	/**
	 * �����ļ�����
	 *
	 * @author������
	 * @version��1.0
	 * @lastupdate��2010-8-11
	 *
	 */

/**
 +----------------------------------------------------------------------
    ʹ��ʵ����
 +----------------------------------------------------------------------
	$download = new download();
	if(!$download->download_files($_GET['download_filename'])){
		echo $download->Errors;
	}
 +----------------------------------------------------------------------
    ������Ϊ�߼���ʾ,��������ʹ��
 +----------------------------------------------------------------------
 */

	class download{

		/*
		 * ��������ļ����ļ���
		 * @private integer
		 */
		private $upload_file_folder = 'upload/';

		/**
		 * ������Ϣ
		 * @private String
		 */
		public $Errors;

		/**
		 * �����ļ�
		 *
		 * @access public
		 * @parameter string $download_filename  �����ļ�������
		 * @return void
		 */
		public function download_files($download_filename){
			//������ָ����$_GET[]ֵʱ�˳�����
			if(empty($download_filename)){
				$this->Errors = '�Ƿ�������';
				return false;
			}
			$filename = $download_filename; //��ȡ�����ļ�������
			//���Ҫ���ص��ļ��Ƿ����
			if(!file_exists($this->upload_file_folder . $filename)){
				$this->Errors = '�ܱ�Ǹ������Ҫ���ص��ļ������ڣ�';
				return false;
			}
			$file_size = filesize($this->upload_file_folder . $filename); //��ȡ�ļ��Ĵ�С
			Header("Content-type: application/octet-stream"); //����Ҫ���ص��ļ�����
			Header("Accept-Ranges: bytes"); //֧�ֶϵ�����
			Header("Accept-Length: ".filesize($file_size)); //�������ص��ļ���С
			Header("Content-Disposition: attachment; filename=" . $filename); //����Ҫ�����ļ����ļ���
			$fp = fopen($this->upload_file_folder . $filename,"r");
			$reading_byte_size = 1024; //ÿ��ѭ����ȡ�ֽڵĴ�С
		    $current_position = 0; //��ǰ�ļ�ָ���λ��
		    /*��ʾ�������ļ�̫����Ҫѭ���������*/
		    while(!feof($fp) && $file_size - $current_position > $reading_byte_size)
		    {
		        $output = fread($fp,$reading_byte_size);
		        echo $output;
		        $current_position += $reading_byte_size;
		    }
		    $output = fread($fp,$file_size - $current_position);
		    echo $output;
		    fclose($fp);
		    return true;
		}
	}

?>







