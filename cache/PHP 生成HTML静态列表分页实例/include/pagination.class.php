<?php
 /**
 * @version 1.0
 * @copyright 2005-2006
 * @Download: http://www.codefans.net
 * @package ��ҳ��-Դ�밮���߶����޸�
*/
class wind_page	
{
    var $page;
      //��������ҳ
    var $total;
      //��¼������
    var $totalpage;
     //��ҳ��
    var $pagesize;
      //ÿҳ��ʾ����
    var $offset;
      //ƫ����
    var $result;
      //��¼����
    var $thispage;
      //��¼������ //��¼������ //��¼������
    var $link;
      //���ӣ���¼$_get������
    var $bar_mun;
      //bar��ʾ��ҳ��
    var $starttime;
      //��ʼʱ��
    var $bar_last;
      //�������ĳ���ҳ��
    var $bar_mid;
      //�������м�ҳ
    var $minpage;
      //��������Сҳ
    var $maxpage;
      //���������ҳ
    var $key;
      //��ʶ��ҳ(һ��ҳ������ҳʱ��������)
    var $style;
      //����ķ��
    var $pre_page_char;
      //��һҳ
    var $pre_page_image;
      //��һҳͼ��
    var $pre_page_char_color;
      //��һҳ������ɫ
    var $next_page_char;
      //��һҳ
    var $next_page_image;
      //��һҳͼ��
    var $next_page_char_color;
      //��һҳ������ɫ
    var $pre_groud_char;
      //�Ϸ��м�ҳ��
    var $pre_groud_char_color;
      //�Ϸ��м�ҳ��������ɫ
    var $next_groud_char;
      //�·��м�ҳ��
    var $next_groud_char_color;
    //�·��м�ҳ��������ɫ
    var $first_page_char;
    //��ҳ
    var $first_page_char_color;
    //��ҳ������ɫ
    var $last_page_char;
    //βҳ
    var $last_page_char_color;
    //βҳ������ɫ
    var $html_page_val;
    //html��ǰ��ҳ��ֵ
     
    function wind_page($sql, $pagesize = 20, $bar_mun = 10, $style = 1,$this_page = 1,$html_page_val=1,$key = "") //���캯������
    {
        $this->starttime = microtime();
        $this->pagesize = $pagesize;
          //ÿҳ��ʾ����
        $this->key = trim($key);
        $this->bar_mun = $bar_mun;
        $this->style = $style;
        $this->html_page_val = $html_page_val;
        //html��ǰ��ҳ��ֵ
        $this->bar_last = $bar_mun-1;
        $this->bar_mid = floor($bar_mun/2);
        $this->sql = $sql;
        $result = mysql_query($this->sql);
        $this->total = mysql_num_rows($result);
        //��¼������
        $this->totalpage = ceil($this->total/$this->pagesize);
        //��ҳ��
        //$this->page = ceil($_GET[$this->key."page"]);
        $this->page = $this_page;
        //��������ҳ
        if ($this->page == "" || $this->page < 1 || !is_numeric($this->page))$this->page = 1;
        $this->page = min($this->page, $this->totalpage);
        $this->thispage = $this->pagesize;
        if ($this->page * $this->pagesize > $this->total) {
            $this->thispage = $this->total-($this->page-1) * $this->pagesize;
        };
        $this->sql .= " limit ".($this->pagesize * ($this->page-1)).", ".$this->pagesize;
          //��ʼ��ȡ������
       //echo "<br>";
        $this->result = mysql_query($this->sql);
        $this->getvar();
        
        $this->pre_page_char = "��һҳ";
        $this->pre_page_image = "<img src=\"/images/b_s_prev.gif\" border=\"0\" />";
        $this->next_page_char = "��һҳ";
        $this->next_page_image = "<img src=\"/images/b_s_next.gif\" border=\"0\" />";
        $this->pre_groud_char = "��һ��";
        $this->next_groud_char = "��һ��";

    }
    
    function getvar() //ȡ�ó�page�������get����
    {
        $this->link = "";
        foreach($_GET as $key => $vaule) {
            if (strtolower($key)  !== $this->key."page") $this->link  .= "&$key=$vaule";
        }
    }
     
    function pre_page($color="#909090",$sign=0) //��һҳ
    {
        if ($this->page > 1) {	
            return "<a href=\"index_".sprintf("%02d",$this->page-1).".html\" class=\"AB\"><font color=\"".$this->pre_page_char_color."\">".$this->pre_page_char."</font></a>";
        } else 
        {
          	return "<font color=\"$color\">".$this->pre_page_char."</font>";
        }
       
    }
     
    function next_page($color="#909090",$sign=0) //��һҳ
    {
        if ($this->page < $this->totalpage) {
        	  
              return "<a href=\"index_".sprintf("%02d",$this->page+1).".html\" class=\"AB\">".$this->next_page_char."</a>";
            
        } else {
        	  
            	return "<font color=\"$color\">".$this->next_page_char."</font>";
        }
    }
     
    function pre_groud($char = "<<", $color = "#909090") //��һ��
    {
        if ($this->page <= ($this->bar_mid+1)) {
            return "<font color=\"".$color."\">".$this->pre_groud_char."</font>";
            //return $this->pre_groud_char;
        } else {
            $pre_gpage = ($this->page-$this->bar_mid < 0)?1:
            $this->page-$this->bar_mid;
            return "<a href=\"index_".sprintf("%02d",$pre_gpage).".html\" title=\"��һ��\">".$this->pre_groud_char."</a>";
        }
    }
     
    function next_groud($char = ">>", $color = "#909090") //��һ��
    {
        if (($this->totalpage-$this->page) <= ($this->bar_mid-1)) {
            return "<font color=\"".$color."\">".$this->next_groud_char."</font>";
        } else {
            $next_gpage = ($this->page+$this->bar_mid < $this->totalpage)?$this->page+$this->bar_mid:
            $this->totalpage;
            return "<a href=\"index_".sprintf("%02d",$next_gpage).".html\"  title=\"��һ��\" >".$this->next_groud_char."</a>";
        }
    }
     
    function mun($lcolor = "#FF6633", $acolor = "#FF6633", $left = "&nbsp", $right = "&nbsp") //���ֵ�����
    {
        $link = "";
        $this->minpage = ($this->page-$this->bar_mid < 1) ? 1:($this->page-$this->bar_mid);
        $this->maxpage = $this->minpage+$this->bar_last;
        if ($this->maxpage > $this->totalpage) {
            $this->maxpage = $this->totalpage;
            $this->minpage = ($this->maxpage-$this->bar_last < 1) ? 1: $this->maxpage-$this->bar_last;
        }
       for($i = $this->minpage; $i <= $this->maxpage; $i++)
        {
        	/* ѭ�����ҳ�� */
            $i = sprintf("%02d",$i);
            //������λ��ǰ�油0
            $char = $left.$i.$right;
            //�������������߼�խ
            if ($i == $this->page) 
            {
            	/* �����ǵ�ǰҳ�򲻼����� */
                $link.= "<font color=\"".$acolor."\">".$char."</font>";
            }
            else 
             {
                //$link  .= "<a href=\"".$_SERVER['PHP_SELF']."?".$this->key."page=".$i.$this->link."\" >".$char."</a>";
                $link.= "<a href=\"index_".$i.".html\" >".$char."</a>";
                //�ؼ���$link ���������ϼ���֮��
            }
        }
        echo "<br>";
        return $link;
    }
     
     
    function jump_bar($class = "jump_bar") //������ת
    {
        $link = "<select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\" class=\"$class\">";
        for($i = $this->minpage; $i <= $this->maxpage; $i++) {
            if ($i < 10)$i = "0".$i;
            //����ѡ�񲻳���10��
            if($this->page == $i)
            {
            	/* ����Ϊ��ǰҳ�룬��ѡ�� */
            	$link  .= "<option value=\"index_".$i.".html\" selected>��".$i."ҳ</option>";
            }
            else
            {
            	 $link  .= "<option value=\"index_".$i.".html\">��".$i."ҳ</option>";
            }
        }
        $link  .= "</select>";
        return $link;
    }
     
    function mun_bar() //�������ֵ�����  [<<][<][01][02][03][04][05][06][07][08][09][10][>][>>]
    {
        //return $this->first_groud().$this->pre_groud().$this->pre_page().$this->mun().$this->next_page().$this->next_groud().$this->last_groud();
        return $this->pre_groud()."&nbsp;".$this->pre_page().$this->mun().$this->next_page()."&nbsp;".$this->next_groud();
    }
    function page_button() 
    { //�������ֵ�����  [<][01][02][03][04][05][06][07][08][09][10][>]
        //return $this->first_groud().$this->pre_groud().$this->pre_page().$this->mun().$this->next_page().$this->next_groud().$this->last_groud();
        return $this->pre_page('#909090',1).$this->mun().$this->next_page('#909090',1);
    }
     
    function total_bar($coloro = "#000000", $colorn = "red") //ͳ������  ҳ��:1/4310 ÿҳ:20 ����:4310ҳ ��ҳ:20
    {
        return "<font color=$coloro>ҳ��:<font color=$colorn>$this->page</font>/$this->totalpage ÿҳ:<font color=$colorn>$this->pagesize</font> ����:<font color=$colorn>$this->totalpage</font>ҳ  ��ҳ:<font color=$colorn>$this->thispage</font></font>";
    }
     
    // ����������
    //ҳ��:1/4310 ÿҳ:20 ����:4310ҳ ��ҳ:20 [<<][<][01][02][03][04][05][06][07][08][09][10][>][>>]
    function page_bar($coloro = "#000000", $colorn = "red") {
        return "<table width='100%'  border='0' cellspacing='0'>
            <tr>
            <td width='5%'></td>
            <td width='35%'>".$this->total_bar()."</td>
            <td width='40%'align='right'>".$this->mun_bar()."</td>
            <td width='10%'>".$this->jump_bar()."</td>
            <td width='5%'></td>
            </tr>
            </table>".$this->MM_jumpMenu();
    }
     
    function taketime($color = "#000000") //����ִ��ʱ��
    {
        return "<div align='center'><font color=$color>��ҳִ��ʱ��".abs((microtime()-$this->starttime) * 1000)."����</font></div>";
    }
     
    function style() //�����ҳ����ʽ
    {
        $style_num = $this->style;
         
        if ($this->totalpage  != 0) //�����ҳ��=0 ,��ʾ�޷�ҳ
        {
            switch($style_num) {
                case 1:
                return $this->page_bar();
                //ҳ��:1/4310 ÿҳ:20 ����:4310ҳ ��ҳ:20 [<<][<][01][02][03][04][05][06][07][08][09][10][>][>>]
                break;
                case 2:
                echo $this->mun_bar();
                //�������ֵ�����  [<<][<][01][02][03][04][05][06][07][08][09][10][>][>>]
                break;
                case 3:
                echo $this->page_button();
                //�������ֵ�����  [<][01][02][03][04][05][06][07][08][09][10][>]
                break;
            }
        }
    }
     
    function MM_jumpMenu() //JavaScript����ת
    {
        //window.open(selObj.options[selObj.selectedIndex].value,targ);
        return "<script language=\"JavaScript\">
            <!--
            function MM_jumpMenu(targ,selObj,restore){
            if (selObj.selectedIndex==0) return;
            window.location.href=selObj.options[selObj.selectedIndex].value,targ;
            if (restore) selObj.selectedIndex=0;
            }
            //-->
            </script>";
    }
     
    function first_groud($char = "&nbsp;<<", $color = "#000000") {
        if ($this->page == 1) {
            return "<font color=\"".$color."\">".$char."</font>";
        } else {
            //$pre_gpage=($this->page-$this->bar_mid<0)?1:$this->page-$this->bar_mid;
            $pre_gpage = 1;
            return "<a href=\"".$_SERVER['PHP_SELF']."?".$this->key."page=".$pre_gpage.$this->link."\" title=\"��һ��\"><font color=\"".$color."\">".$char."</font></a>";
        }
    }
     
    function last_groud($char = "&nbsp;>>", $color = "#000000") {
        if ($this->page == $this->totalpage) {
            return "<font color=\"".$color."\">".$char."</font>";
        } else {
            //$pre_gpage=($this->page-$this->bar_mid<0)?1:$this->page-$this->bar_mid;
            $pre_gpage = $this->totalpage;
            return "<a href=\"".$_SERVER['PHP_SELF']."?".$this->key."page=".$pre_gpage.$this->link."\" title=\"��һ��\"><font color=\"".$color."\">".$char."</font></a>";
        }
    }
}
?>