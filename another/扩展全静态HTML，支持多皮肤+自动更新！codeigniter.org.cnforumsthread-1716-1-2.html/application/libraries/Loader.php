<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ������ PHP4 ���棬���� CI_Loader ��Ч����Base4.php�����޶��ˣ��ܴꡫ��
// ��������ʵ�� PHP4/PHP5 �������� CI_Loader �����Ҳ����޸� CI ����
eval('?'.'>'.str_replace('CI_Loader', 'CI_Loader_Superclass', file_get_contents(BASEPATH.'libraries/Loader'.EXT)));

/**
 * ֧��ȫ��̬ html �� Loader ��
 *
 * @package CodeIgniter EX
 * @author Nick from visvoyȦ��gmail��com
 */
class CI_Loader extends CI_Loader_Superclass
{
	// Constructor
	function CI_Loader()
	{
		parent::CI_Loader_Superclass();
	}
	
	// HOOK: ������� views ʱʡ�� view ����
	// ��ʱ view ����Ĭ��Ϊ action ������
	// ���磺��ǰ action = index, ִ�У�$ctrl->view(array('tag' => 1...))
	// ����ת��Ϊ��$ctrl->view('index', array('tag' => 1...))
	// ����Ĭ�� action ��Ϊ view ���������ڼ�� views ���� html �ļ����Զ�����
	function view($view = null, $vars = array(), $return = FALSE)
	{
		if (!is_string($view)) {
			$CI =& get_instance();
			$t = $CI->router->fetch_method();
			// û�д��� _remap , if (method_exists($CI, '_remap'))
			return parent::view($t, $view, $vars);
		}
		return parent::view($view, $vars, $return);
	}
	
	// HOOK: ��� url ��ַת����image asset ��ַת����upload ��ַת��
	function _ci_load($_ci_data)
	{
		// ����Ƿ������ ::view() ������
		if (isset($_ci_data['_ci_view']) 
			&& !isset($_ci_data['_ci_path']))
		{
			// �� views ���������ǰ׺/method
			$CI =& get_instance();
			$_ci_data['_ci_view'] = $CI->config->item('theme').'/'.$CI->router->fetch_class().'/'.$_ci_data['_ci_view'];
			
			// ��ΪҪת����ַ������ػ��������
			$return = $_ci_data['_ci_return'];
			$_ci_data['_ci_return'] = true;
			$c = parent::_ci_load($_ci_data);
			
			// ��ʼת����ַ
			// ע�⣺ȫ��̬ html ģʽ�� index_page �ǿ�ֵ�����û�ȡ
			$u = trim($CI->config->item('upload_tag'));	// �ϴ��ļ���Ŀ¼
			$ui = trim($CI->config->item('theme'));	// ��ǰ������
			$url = trim($CI->config->item('base_url'));	// ��վ��ַ
			$img = trim($CI->config->item('image_tag'));	// image asset СĿ¼
			$img_url = trim($CI->config->item('image_url'));	// ͼƬ��������ַ
			$find = $replace = array();
			
			// �滻 image���������滻 image �����滻�������ӣ�
			// ע�⣺�滻����ͼƬ��������Ȼ�� ui ���ַ�Ŀ¼����ͼ��
			if ('' != $img_url)
			{
				$img_url = rtrim($img_url, '/');
				$uf = "/$ui/$img/";
				$ur = "$img_url/$ui/";
				$find = array_merge($find, array("\"$uf", "'$uf", "=$uf", "($uf"));
				$replace = array_merge($replace, array("\"$ur", "'$ur", "=$ur", "($ur"));
			}
			
			// �滻�ϴ�·��
			if ('' != $u)
			{
				$url = rtrim($url, '/');
				$uf = "/$u/";
				$ur = "$url/$u/";
				$find = array_merge($find, array("\"$uf", "'$uf", "=$uf", "($uf"));
				$replace = array_merge($replace, array("\"$ur", "'$ur", "=$ur", "($ur"));
			}
			
			// �滻�������ӣ����� /theme/welcome... �滻Ϊ base_url/theme/welcome...
			$url = rtrim($url, '/');
			$uf = "/$ui/";
			$ur = "$url/$ui/";
			$find = array_merge($find, array("\"$uf", "'$uf", "=$uf", "($uf"));
			$replace = array_merge($replace, array("\"$ur", "'$ur", "=$ur", "($ur"));
			
			// ִ���滻����
			$c = str_replace($find, $replace, $c);
			
			// Ҫ�󷵻����ݣ�
			if (true === $return)
			{		
				return $c;
			}
			
			// ���������ݣ��Ǿ�����ɣ�copy һС�γ���Ķ��� Oy
			// PHP 4 requires that we use a global
			global $OUT;
			$OUT->append_output($c);
			@ob_end_clean();
		}
		else 
		{
			return parent::_ci_load($_ci_data);
		}
	}
} // END class CI_Loader (extended, in fact ^o^)