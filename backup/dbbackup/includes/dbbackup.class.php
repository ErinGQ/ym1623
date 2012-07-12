<?php

	/**
	 * ���ݿⱸ�ݳ���
	 *
	 * @author������
	 * @version��1.0
	 * @lastupdate��2010-7-18
	 *
	 */


// +-----------------------------------------------------------
// | ����ԭ��
// +-----------------------------------------------------------
// |Ĭ�ϱ����ļ�����2048K,��־���
// |������Ա������ݺ͵�������
// |һ�������ļ��ж���־�,ֻ����ѡһ������,������Զ����������־�
// +-----------------------------------------------------------

/**
 +-----------------------------------------------------------------
 *  ʹ��ʵ����
 +-----------------------------------------------------------------
 *  $dbbackup = new dbbackup("localhost", "root", "", "���ݿ���");
 +-----------------------------------------------------------------
 *  �������ݣ�
 *  $tbs = $dbbackup->get_tb()						��ȡ���ݿ����
 *  $data = $dbbackup->get_backupdata($tbs); 		��ȡ��������
 *  $dbbackup->export($data)						��������
 +-----------------------------------------------------------------
 *  �������ݣ�
 *  $bakfile = $dbbackup->get_backup();				��ȡ�����ļ�
 *  $dbbackup->import(�ļ���)						��������
 +-----------------------------------------------------------------
 *  ɾ�����ݣ�
 *	$dbbackup->delfn(�ļ���)
 +-----------------------------------------------------------------
 *  ������Ϊ�߼���ʾ,��������ʹ��
 +-----------------------------------------------------------------
 */


	class dbbackup{


		/**
		 * ���ݿ�����
		 *
		 * @private string
		 */
			private $db_host;

		/**
		 * ���ݿ��û���
		 *
		 * @private string
		 */
			private $db_user;

		/**
		 * ���ݿ�����
		 *
		 * @private string
		 */
			private $db_pwd;

		/**
		 * ���ݿ���
		 *
		 * @private string
		 */
			private $db_database;

		/**
		 * ���ݿ����,GBK,UTF8,gb2312
		 *
		 * @private string
		 */
			private $coding;

		/**
		 * ���ݿ����ӱ�ʶ
		 *
		 * @private string
		 */
			private $conn;

		/**
		 * �ļ���·������ű������ݣ�
		 *
		 * @private string
		 */
			private $data_dir = 'data/';

		/**
		 * �־��ȣ���λKB��
		 *
		 * @private string
		 */
			private $part = 2048;

		/**
		 * �����ļ���
		 *
		 * @private string | array
		 */
			public $bakfn;


		/**
		 * ���캯��
		 *
		 * @access public
		 * @parameter string $db_host 		���ݿ�����
		 * @parameter string $db_user 		���ݿ��û���
		 * @parameter string $db_pwd  		���ݿ�����
		 * @parameter string $db_database   ���ݿ���
		 * @parameter string $coding  		����
		 * @return void
		 */
		public function __construct($db_host, $db_user, $db_pwd, $db_database, $coding = 'gb2312'){
			$this->init();
			$this->db_host = $db_host;
			$this->db_user = $db_user;
			$this->db_pwd =  $db_pwd;
			$this->db_database = $db_database;
			$this->coding = $coding;
			$this->connect();
			$this->part = $this->part * 1024; //���÷־���,��λΪKB
			$this->cre_dir();  				  //�����ļ���
		}

		/**
		 * ��ʼ������
		 *
		 * @access private
		 * @return void
		 */
		private function init(){
			set_time_limit(0);					//����ִ�в���ʱ
			error_reporting(E_ERROR | E_PARSE); //������
		}

		/**
		 * �������ݿ�
		 *
		 * @access private
		 * @return void
		 */
		private function connect(){
			$this->conn = @mysql_connect($this->db_host,$this->db_user,$this->db_pwd);
			if(!$this->conn){
				echo '<font color="red">������ʾ���������ݿ�ʧ�ܣ�</font>';
				exit();
			}

			if(!@mysql_select_db($this->db_database, $this->conn)){
				echo '<font color="red">������ʾ�������ݿ�ʧ�ܣ�</font>';
				exit();
			}

			if(!@mysql_query("SET NAMES $this->coding")){
				echo '������ʾ�����ñ���ʧ�ܣ�';
			}
		}

		/**
		 * �����ļ���
		 *
		 * @access private
		 * @return void
		 */
		private function cre_dir(){
			//�ļ��в������򴴽�
			if(!is_dir($this->data_dir)){
				mkdir($this->data_dir, 0777);
			}
		}

		/**
		 * 	��ȡ���ݿ����
		 *
		 * @access public
		 * @return Array
		 */
		public function get_tb(){
			//��ѯ����
			$tq = mysql_list_tables($this->db_database);
			while($tr = mysql_fetch_row($tq)){
				$arrtb[] = $tr[0];
			}
			return $arrtb; //���ر���
		}

		/**
		 * ��ȡ��������
		 *
		 * @access public
		 * @parameter string $db_host	����
		 * @return String or Array
		 */
		public function get_backupdata($arrtb){
			$backupdata = ''; //�洢��������
			//��ȡ��������
			foreach($arrtb as $tb){
				//��ȡ��ṹ
				$query = mysql_query("SHOW CREATE TABLE $tb");
				$row = mysql_fetch_row($query);
				$backupdata .= "DROP TABLE IF EXISTS $tb;\n" . $row[1] . ";\n\n";
				//��ȡ������
				$query = mysql_query("select * from $tb");
				$numfields = mysql_num_fields($query); //ͳ���ֶ���
				//����INSERT���
				while($row = mysql_fetch_row($query)){
					$comma = ""; //�洢����
					$backupdata .= "INSERT INTO $tb VALUES (";
					for($i=0; $i<$numfields; $i++){
											  	  //ת��SQL����е������ַ�
						$backupdata .= $comma . "'" . mysql_escape_string($row[$i]) . "'";
						$comma = ",";
					}
					$backupdata .= ");\n";
					//�������ݴ��� partֵ ���������,�־���
					if(strlen($backupdata) > $this->part){
						$arrbackupdata[] = $backupdata;
						$backupdata = ''; //���֮ǰ��sql
					}
				}
				$backupdata .= "\n"; // \n����ÿ�ű��е�����
			}
			//+
			//| ��ʾ��
			//| �����Ƿ���Ҫ�־���,���ز�ֵͬ
			//+
			if(is_array($arrbackupdata)){
				//��ʣ�����ݼ�������
				array_push($arrbackupdata, $backupdata);
				return $arrbackupdata; //�������鱸������
			}
			return $backupdata; //���ر�������
		}

		/**
		 * ����������д���ļ�
		 *
		 * @access private
		 * @parameter string $data	����
		 * @return Boolean
		 */
		private function wri_file($data){
			//����Ϊ������־���
			if(is_array($data)){
				$i = 1;
				foreach($data as $val){
					//д������
					$filename = $this->data_dir . $this->db_database . mktime() . "_part{$i}.sql"; //�ļ���
					if(!$fp = @fopen($filename, "w+")){ echo "�ڴ��ļ�ʱ��������,����ʧ��!"; return false;}
					if(!@fwrite($fp, $val)){
						echo "��д����Ϣʱ��������,����ʧ��!"; fclose($fp); //��ر��ļ�����ɾ��
						unlink($filename); //ɾ���ļ�
						return false;}
					$this->bakfn[] = $this->db_database . mktime() . "_part{$i}.sql"; //���ݳɹ��򷵻��ļ�������
					$i++;
				}
			}else{ //��������
				$filename = $this->data_dir . $this->db_database . mktime() . ".sql";
				if(!$fp = @fopen($filename, "w+")){ echo "�ڴ��ļ�ʱ��������,����ʧ��!"; return false;}
				if(!@fwrite($fp, $data)){
					echo "��д����Ϣʱ��������,����ʧ��!"; fclose($fp);
					unlink($filename);
					return false;}
				$this->bakfn = $this->db_database . mktime() . ".sql"; //���ݳɹ��򷵻��ļ���
			}
			fclose($fp);
			return true;
		}

		/**
		 * ��������
		 *
		 * @access public
		 * @parameter string $data	����
		 * @return void
		 */
		public function export($data){
			return $this->wri_file($data); //д������
		}

		//+-------------
		//+-------------

		/**
		 * ��ȡ���б����ļ�
		 *
		 * @access public
		 * @return Array
		 */
		public function get_backup(){
			$backup = scandir($this->data_dir); //��ѯ���еı����ļ�
			for($i=0; $i<count($backup); $i++){
				if($backup[$i] != "." && $backup[$i] != ".."){
					$arrbackup[] = $backup[$i];
				}
			}
			return $arrbackup; //���ر����ļ�����
		}

		/**
		 * ��������
		 * ��һ�������ļ��ж���־�ֻ����ѡһ�������ļ�����,������Զ����������־� ��
		 *
		 * @access public
		 * @parameter string|array $filename	�����ļ���
		 * @return Boolean
		 */
		public function import($filename){
			//�����ļ���Ϊ�־��ļ�֮һ,����ҳ����з־��ļ�
			$Boolean = preg_match("/_part/",$filename); 		   //�ж��ļ��Ƿ�Ϊ�־��ļ�
			if($Boolean){
				$fn = explode("_part", $filename);				   //ȡ�־��ļ���
				$backup = scandir($this->data_dir);	    		   //��ѯ���еı����ļ�
				for($i=0; $i<count($backup); $i++){
					$part = preg_match("/{$fn[0]}/", $backup[$i]); //ȡ������ƥ��ķ־��ļ�
					if($part){
						$filenames[] = $backup[$i];
					}
				}
			}
			//�����ļ��������ȡ�־�����,�����ȡ�����ļ�����
			if(is_array($filenames)){
				foreach($filenames as $fn){
					$data .= file_get_contents($this->data_dir . $fn);  //��ȡ����
				}
			}else{
				$data = file_get_contents($this->data_dir . $filename);
			}
			//�и�����
			$data = str_replace("\r", "\n", $data);
			$regular = "/;\n/";
			$data = preg_split($regular,trim($data));
			//ѭ����������
			foreach($data as $val){
				mysql_query($val) or die('��������ʧ�ܣ�' . mysql_error());
			}
			return true;
		}

		//+-------------
		//+-------------

		/**
		 * ɾ�������ļ�
		 *
		 * @access public
		 * @parameter string $delfn	�����ļ���
		 * @return void
		 */
		public function del($delfn){
			//ɾ����������ļ�
			if(is_array($delfn)){
				foreach($delfn as $fn){
					if(!unlink($this->data_dir.$fn)){ return false;}
				}
				return true;
			}
			//ɾ�����������ļ�
			return unlink($this->data_dir.$delfn);
		}

	}

?>





