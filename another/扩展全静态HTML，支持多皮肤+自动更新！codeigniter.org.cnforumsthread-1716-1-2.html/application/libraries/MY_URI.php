<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ֧��ȫ��̬ html �� URI ��
 *
 * @package CodeIgniter EX
 * @author Nick from visvoyȦ��gmail��com
 */
class MY_URI extends CI_URI
{
	// ��¼�����ù������ segment ��ţ�Ĭ��=3 (1=������, 2=Controller, 3=action)
	var $_goodseg = 3;
	
	// Constructor
	function MY_URI()
	{
		parent::CI_URI();
	}

	// HOOK: ��¼����ʹ�ù��� segment �������ţ������������� seg
	function segment($n, $no_result = FALSE)
	{
		if ($n > $this->_goodseg)
		{
			$this->_goodseg = $n;
		}
		return parent::segment($n, $no_result);
	}
	
	// EXTEND: ֻ��ȡ������ ::segment() �������ù���������֮�ڵ� segment ���鼯��
	function good_rsegment_array() 
	{
		if ($this->_goodseg < 0) 
		{
			return $this->rsegments;
		}
		return array_slice($this->rsegments, 0, $this->_goodseg);
	}
	
	// HOOK: ��ֹ���ν��� URI
	function _fetch_uri_string()
	{
		if ($this->uri_string != '') 
		{
			return;
		}
		parent::_fetch_uri_string();
	}
	
	// HOOK: ȥ�� JS ģʽ URI ��β�� .js
	function _remove_url_suffix()
	{
		if (strtolower(substr($this->uri_string, -3)) == '.js') {
			define('JSMODE', 1); // ���� html �ļ����ģʽ
			log_message('debug', 'JS mode is current.');
			$this->uri_string = substr($this->uri_string, 0, -3);
		} else {
			parent::_remove_url_suffix();
		}
	}
} // END class MY_URI