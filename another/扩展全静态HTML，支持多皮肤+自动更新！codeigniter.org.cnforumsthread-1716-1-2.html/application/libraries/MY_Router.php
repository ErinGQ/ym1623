<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ֧��ȫ��̬ html �� Router ��
 *
 * @package CodeIgniter EX
 * @author Nick from visvoyȦ��gmail��com
 */
class MY_Router extends CI_Router
{
	// Constructor
	function MY_Router()
	{
		parent::CI_Router();
	}
	
	// HOOK: �� router ֧�� html ���� http://ci-ex.com/theme/controller/action.html
	function _set_routing()
	{
		// ȫ��̬ html ģʽ�������� enable_query_strings
		$query_string_temp = $this->config->item('enable_query_strings');
		$this->config->set_item('enable_query_strings', false);
		
		// ��ǰ���� URI �����мӹ�
		$this->uri->_fetch_uri_string();
		if ('' == $this->uri->uri_string) 
		{
			// ��Ҫȡ�� default_contoller �����ܺͳ������ظ��������Ա����޸ĳ��࣬=.=
			@include(APPPATH.'config/routes'.EXT);
			if (!isset($route) || !is_array($route)) 
			{
				$route = array();
			}
			$def_ctrl = (!isset($route['default_controller']) OR $route['default_controller'] == '') ? false : strtolower($route['default_controller']);	
			if (false === $def_ctrl)
			{
				show_error("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
			}
			
			// ��Ĭ�� uri_string �㼯�� theme/default_controller
			$this->uri->uri_string = $this->config->item('default_theme').'/'.$def_ctrl;
		}
		
		// HOOK ���������๤����������
		parent::_set_routing();
		
		// �ָ� enable_query_strings ���Թ��������ʹ��
		$this->config->set_item('enable_query_strings', $query_string_temp);
	}
	
	// HOOK: �� Router ���Խ��� theme/controller/action �е� theme
	function _set_request($segments = array())
	{
		parent::_set_request($segments);
		
		// ��Ϊǰ��ȷ���ˣ�uri_string һ�����ǿ�ֵ
		// ��Ҫ�� theme ��� rsegments ��ͷ
		$theme = $this->config->item('theme');
		array_unshift($this->uri->rsegments, $theme);
	}
	
	// HOOK: �� Router ���Խ��� theme/controller/action �е� theme
	function _validate_request($segments)
	{
		$theme = $segments[0];
		$root = dirname(FCPATH).'/';
		
		// ȷ������Ŀ¼����
		if (!is_dir($root.$theme))
		{
			show_error("Unable to load requested theme: $theme");
		}
		
		// ���浱ǰ��������
		$this->config->set_item('theme', $theme);
		
		return parent::_validate_request(array_slice($segments, 1));
	}
} // END class MY_Router