<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ֧��ȫ��̬ html �� Output ��
 *
 * @package CodeIgniter EX
 * @author Nick from visvoyȦ��gmail��com
 */
class MY_Output extends CI_Output
{
	var $_path = '';
	
	// Constructor
	function MY_Output()
	{
		parent::CI_Output();

		// ��վ��Ŀ¼		
		$this->_path = dirname(FCPATH).'/';
		
		// html ģʽ�����������
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}
	
	// HOOK: ����ת�򵽾�̬ html �ļ��Ĺ���
	function _display($output = '')
	{
		global $URI;
		
		if ('' == $output)
		{
			$output = &$this->final_output;
		}
		
		// JS ģʽ������ html �ļ������������
		if (defined('JSMODE'))
		{
			log_message('debug', 'JS mode content send complete');
			return parent::_display($output);
		}
		
		// ���ɾ�̬ html �ļ�
		// ��û�л��棬�򻺴���ڣ�CI ����� requested controller ����ҳ��
		// ����������£���ֵ��д��̬ html �ļ�
		// 
		// ���л�����û���ڣ���Ҫ�� ::_display() ����д��̬ html �ļ�
		// ��Ϊ��ִ�� ::_display_cache() ������ʱ���Ѿ�д�� html ��
		if (function_exists('get_instance'))
		{
			$CI = &get_instance();
			$f = $this->_get_html_filename($CI->uri);
			$this->_create_htmlfile($this->_path.$f, $output);
		}
		
		// ���¹�����������
		// Ϊʲôû�н��о�̬ html ת��
		// ��Ϊû��Ҫ�ۣ��¸£������Ѿ�����ҳ�������ˣ�����ֱ�������
		// �´��ٷ������ URI ��ʱ����Զ�ת�����Ӧ�ľ�̬ html �ˣ�
		// ǿ��ת��Ļ�����Ҫ copy �����е�һ��ε� header ��������ˡ�����
		return parent::_display($output);
	}
	
	// HOOK: ͬʱ��⾲̬ html �ļ�
	function _display_cache(&$CFG, &$URI)
	{
		// POSTҳ��������û�����壬��ȻPOST���^o^
		if (strtoupper($_SERVER['REQUEST_METHOD']) != 'GET') {
			return false;
		}
		
		// ��ȡ��̬ html �ļ���
		$f = $this->_get_html_filename($URI);
		
		// ��֤��̬ html �ļ��Ƿ���ڻ����
		$has_html = $this->_validate_htmlfile($this->_path.$f);
		
		// JS ģʽֻ��� html �ļ�״̬
		if (defined('JSMODE')) 
		{
			log_message('debug', 'Exit a HTML file checking request');
			exit;
		}
			
		// html ������û�й��ڣ�����������ת�� html
		// ע�� JS ģʽ������ת����Ϊ JS ģʽ����Ϊ js_action ���� html �ļ�
		if ($has_html && !defined('JSMODE'))
		{
			$url = $CFG->item('base_url').$f;
			log_message('debug', 'Redirect to html: '.$url);
			header("Location: ".$url, TRUE, 302);
			//header("Refresh:0;url=".$url);
			exit;
		}
		
		// ��Ҫ���� URI ������������������
		$uri_temp = $URI->uri_string;
		$URI->uri_string = implode('/', $URI->good_rsegment_array());
		$result = parent::_display_cache($CFG, $URI);
		
		// �ָ� uri string ���Թ������������
		$URI->uri_string = $uri_temp;
		
		// �л��棬��û�о�̬ html �ļ����Ǿ����� html �ļ�
		if (TRUE == $result && !$has_html)
		{
			$this->_create_htmlfile($this->_path.$f, $this->final_output);
		}
		
		return $result;
	}

	// EXTEND: ȡ��ȫ��̬ html ���ļ��������� url ·��
	function _get_html_filename(&$URI) {
		$f = config_item('url_suffix');
		$f = (trim($f) == '') ? '.html' : $f;
		$f = implode('/', $URI->good_rsegment_array()).$f;
		return $f;
	}
	
	// EXTEND: ���ɾ�̬ html �ļ������𼶴�����Ŀ¼����
	function _create_htmlfile($file, &$content) {
		$k = str_replace('\\', '/', $file);
		
		// �𼶴�����Ŀ¼
		while ($pos = strrpos($k, '/')) 
		{
			$k = substr($k, 0, $pos);
			if (is_dir($k))
			{
				break;
			}
			@mkdir($k, 0777);
		}
		
		if (!$fp = @fopen($file, 'wb'))
		{
			log_message('error', "Unable to write html file: $file");
			return false;
		}
		if (!flock($fp, LOCK_EX))
		{
			log_message('error', "Unable to lock html file: $file");
			return false;
		}
		
		// ���� html �Զ����½ű�
		$CI = &get_instance();
		$js = implode('/', $CI->uri->good_rsegment_array());
		$js = $CI->config->item('base_url').$js.'.js';
		$js = '<script src="'.$js.'" type="text/javascript"></script>';
		
		// HTML �ļ�Ĭ�ϱ���һ����
		$exp = ($this->cache_expiration > 0) ? $this->cache_expiration : (60 * 24 * 30);
		$exp = time() + $exp * 60;
		$e = '<!-- RC'.$exp.'TS -->';
		
		fwrite($fp, $content.$js.$e);
		flock($fp, LOCK_UN);
		fclose($fp);
		@chmod($file, 0666);
		
		log_message('debug', "HTML file written: $file");
		return true;
	}
		
	// EXTEND: ���ȫ��̬ html �ļ��Ƿ���ڻ����
	// html �ļ������ڻ���ڷ��� false ����֤ ok ���� true
	function _validate_htmlfile($f) {
		global $CFG, $RTR;
		
		if (!file_exists($f))
		{
			return false;
		}
		
		// ̽�� views �� controller �ļ��Ƿ��޸Ĺ�����������Զ����¶�Ӧ�� html �ļ�
		if ($CFG->item('html_check_source') == true) {
			$t = $CFG->item('theme').'/'.$RTR->fetch_directory().$RTR->fetch_class().'/'.$RTR->fetch_method();
			$t1 = APPPATH.'views/'.$t.EXT;
			$t2 = APPPATH.'controllers/'.$RTR->fetch_directory().$RTR->fetch_class().EXT;
			//log_message('debug', 't1='.$t1);
			//log_message('debug', 't2='.$t2);
			
			// ��� views �ļ�
			if (file_exists($t1) && @filemtime($t1) > @filemtime($f))
			{
				return $this->_delete_htmlfile($f, 'HTML views has modified, created htmlfile deleted: '.$f);
			}
			else // ���û�� views.php �����Լ�� views.url_suffix �� views.html
			{
				$ext = trim($CFG->item('url_suffix'));
				$ext = ('' == $ext) ? '.html' : $ext;
				$t1 = APPPATH.'views/'.$t.$ext;
				if (file_exists($t1) && @filemtime($t1) > @filemtime($f))
				{
					return $this->_delete_htmlfile($f, 'HTML views.suffix changed, htmlfile deleted: '.$f);
				}
			}
			
			// ��� controller �ļ�
			if (file_exists($t2) && @filemtime($t2) > @filemtime($f))
			{
				return $this->_delete_htmlfile($f, 'HTML controller changed, htmlfile deleted: '.$f);
			}
		}
		
		if (!($fp = @fopen($f, 'rb')))
		{
			return $this->_delete_htmlfile($f);
		}
		
		// ��ȡ html �ļ�β����ʱ���
		$n = filesize($f);
		if ($n > 100) {
			fseek($fp, $n - 100);
			$c = fread($fp, 100);
		} else {
			$c = fread($fp, $n);
		}
		fclose($fp);

		// Ѱ�Ҹ���ʱ���		
		$start = strrpos($c, '<!-- RC');
		$end = strrpos($c, 'TS -->');
		if (false === $start || false === $end)
		{
			return $this->_delete_htmlfile($f, 'HTML uptime lost and file deleted: '.$f);
		}
		
		// ����Ƿ����
		$exp = substr($c, $start + 7, $end - $start - 7);
		//log_message('debug', 'HTML TIME STAMP='.$exp);
		if (!is_numeric($exp) || time() >= $exp)
		{
			return $this->_delete_htmlfile($f, 'HTML expired and file deleted: '.$f);
		}
		
		log_message('debug', 'HTML status good: '.$f);
		return true;
	}
	
	// EXTEND: ɾ�����ڵľ�̬ html �ļ�
	function _delete_htmlfile($f, $memo = '') {
		@unlink($f);
		if ('' != $memo) 
		{
			log_message('debug', $memo);
		}
		//clearstatcache();
		return false;
	}
} // END class MY_Output