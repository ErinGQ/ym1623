<?
//Download: http://www.codefans.net
class create_html {
         
        private $template;
        //ģ��
        private $file_name;
        //�ļ���
        private $array;
        //��������
        function create_html($file_name, $template, $array) {
          //������
              
            $this->template = $this->read_file($template, "r");
              //��ȡģ���ļ�  
            $this->file_name = $file_name;        
            $this->array = $array;
            //��������
            $this->html();
            //����html
        }
         
        function html() {
        	 //����html
            while (ereg ("{([0-9]+)}", $this->template, $regs)) {
            	//ѭ��ģ�������ܵ�{1}.....
                $num = $regs[1];
                //�õ�1��2��3����
                $this->template = ereg_replace("\{".$num."\}", $this->array[$num], $this->template);
                //�������滻��html����
                $this->write_file($this->file_name, $this->template, "w+");
                //����HTML�ļ�
            }
        }
         
        function read_file($file_url, $method = "r") {
            //��ȡ�ļ�
             
            $fp = @fopen($file_url, $method);
            //���ļ�
            $file_data = fread($fp, filesize($file_url));
            //��ȡ�ļ���Ϣ
            return $file_data;
        }
         
        function write_file($file_url, $data, $method) {
            //д���ļ�
            $fp = @fopen($file_url, $method);
            //���ļ�
            @flock($fp, LOCK_EX);
            //�����ļ�
            $file_data = fwrite($fp, $data);
            //д���ļ�
            fclose($fp);
            //�ر��ļ�
            return $file_data;
        }
}
?>