<?php 
$keyword =$_GET['keyword']; 
$xm=$_GET['xm'];
$keyword2=urlEncode($keyword); 
$keyword3=strtolower($keyword2); 
if($keyword =="") 
{echo "��û����������������"; 
exit;} 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<link  href="./css/style.css" rel="stylesheet" type="text/css">
<style>
body  {text-align: left;}
.t1{ color: #FFFF00;font-family: Webdings;} 
.t2{ color: #9999FF;font-family: Webdings;} 
.parent{width:100%; height: 20; letter-spacing: 2; vertical-align: 0; font-weight: bold; background-color: #66CCFF; border-bottom-style: solid; border-bottom-width: 1}
</style>
<base target="cjss">
</head>
<BODY>
<?php print <<<EOT
<script>if(top==self)top.location="main.php?keyword=$keyword";</script>
<form action="main.php" method="get" target="_top">
        <table border="0" cellpadding="2" cellspacing="0" bgcolor="#47AFF" width="100%">
      <tr>
        <td width="100%" align="center"><a href="./" target="_top"><img  src="images/kuaikuaisou.gif" border="0" width="120" height="68"></a><br>
          <br>&nbsp;<input name="keyword" value="$keyword" size="15" >
		  </td>
      </tr>
      <tr>
        <td width="100%"  height="35" align="center">
           &nbsp;<input type="submit" value="��������" class="btn">
        </td>
      </tr> </FORM>
	  
  </table>&nbsp;
<!--��ҳ����-->
<div class='parent' ><font class="t1">8</font>&nbsp;��ҳ</div>
<!--�����ǳ��õĴ�����������-->
<div style="width: 134; height: 128;">&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://www.baidu.com/s?tn=aiyat&ct=&lm=&z=&rn=&_sv=1&word=$keyword2">�ٶ�</a>
<br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://www.google.com/search?hl=zh-CN&newwindow=1&q=$keyword2">GOOGLE</a>
<br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://cnweb.search.live.com/results.aspx?q=$keyword2&page=searchresults&FORM=MSNH&where1=&mkt=zh-cn">MSN�й�</a>
<br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://page.zhongsou.com/p?aid=E0200000000&k=tlei&w=$keyword2">����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://www.sogou.com/websearch/corp/search.jsp?query=$keyword2&searchtype=1&pid=aiyatx&class=1&cpc=SOGOU">�ѹ�</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://www.tianwang.com/cgi-bin/tw?word=$keyword2&range=0&cd=03&submit.x=14&submit.y=7">����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://iask.sina.com.cn/search_engine/search_knowledge_engine.php?key=$keyword2&classid=0&title=PHP&gjss=0&x=27&y=13">����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://search.union.yahoo.com.cn/click/search.htm?fw=union&m=82676&b=1003&p=1009&a=2001&name=$keyword2">�Ż�</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://www.17so.com/so?q=$keyword2">һ����</a>
</div>
<!--���ָ��-->
<div class='parent'><font  class="t1">8</font>&nbsp;���ָ��</div>
<!--�����ǳ��õĸ����վ-->
<div style="width: 114; height: 140">&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://music.qq.com/portal_v2/static/search_result.html?search_input=$keyword2&search_bt.x=33&search_bt.y=11">QQ����</a><br> &nbsp;<font class="t2">4</font>&nbsp;
<a href="http://mp3.baidu.com/m?tn=baidump3&ct=134217728&lm=-1&z=&rn=&_sv=4&word=$keyword2&_si.x=15&_si.y=9">�ٶ�MP3</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://music.yahoo.com.cn/search?p=$keyword2&pid=82676_1006&needbid=&ei=GBK&source=3721_union">�Ż�MP3</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://mp3.zhongsou.com/m?w=$keyword2&ty=&lg=">���� MP3</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://d.sogou.com/music?query=$keyword2&searchtype=4&pid=aiyatx&class=1&cpc=SOGOU">�ѹ�MP3</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://m.iask.com/g?k=$keyword2&ss=all">����MP3</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://mp3.baidu.com/m?f=ms&tn=baidump3lyric&ct=150994944&lf=1&rn=10&word=$keyword2&lm=-1">�ٶȸ�� </a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://music.yahoo.com.cn/lyric.html?pid=82676_1006&p=$keyword2&button=$keyword2&button=%B8%E8%B4%CA%CB%D1%CB% F7&mimetype=all&source=ysearch_music_result_topsearch">�Ż����</a>
</div>
<!--��Ӱ��վ-->
<div class='parent'><font  class="t1">8</font>&nbsp;��Ӱ</div>
<!--�����ǳ��õĵ�Ӱ��վ-->
<div class='child'  style="width: 116; height: 58">&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://movie.baidu.com/srh.php?tn=baidux&word=$keyword2">�ٶ�Ӱ��</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://video.search.yahoo.com/search/video?p=$keyword2&toggle=1&ei=GBK">�Ż� Video</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://v.iask.com/v?k=$keyword2">������Ƶ</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://file.tianwang.com/cgi-bin/search?word=$keyword2&FType=3&submit.x=31&submit.y=12">����Ӱ��</a>
</div>
<!--���Դ��-->
<div class='parent'><font  class="t1">8</font>&nbsp;���Դ��&nbsp;</div>
<!--�����ǳ��õ����Դ����վ-->
<div class='child' style="width: 131; height: 88">&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://search2.onlinedown.net/search.asp?keyword=$keyword2">�������԰</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://www.skycn.com/search.php?offset=0&ss_name=$keyword2">������</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://down.chinaz.com/query.asp?action=title&keyword=$keyword2&page=1">�й�վ��վ</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://dlc.pconline.com.cn/search.jsp?keyword=$keyword2">̫ƽ�����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://soft.sogou.com/software.so?query=$keyword2&amp;class=4">�ѹ�����</a></div>
<!--��̳��վ-->
<div  class='parent'><a name="bbs"></a><font  class="t1">8</font>&nbsp;��̳</div>
<!--������һЩ���͵���̳-->
<div  class='child'  style="width: 130; height: 70">&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://post.baidu.com/f?kw=$keyword2">�ٶ�����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://search.bbs.sina.com.cn/search/search?gid=3&bbsid=19&t=keyword&q=$keyword2">����˵��</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://search.chinabbs.com/cgi-bin/search?content=$keyword2&type=title">Chinabbs</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://bbs.zhongsou.com/b?w=$keyword2&dt=1&webid=tlei&aid=B0100006149">������̳</a></div>
<!--������վ-->
<div class='parent'><font  class="t1">8</font>&nbsp;����</div>
<!--������һЩ֪����������վ-->
<div class='child'  style="width: 131; height: 120">&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://news.baidu.com/ns?tn=news&ct=201326592&lm=-1&z=0&rn=&_sv=2&word=$keyword2&_si.x=12&_si.y=5">�ٶ�����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://xinwen.yahoo.com.cn/search?p=$keyword2&pid=82676_1006&needbid=&ei=GBK&source=3721_union">�Ż�����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://iask.com/n?k=$keyword2">��������</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://news.sogou.com/news?query=$keyword2&searchtype=5&pid=aiyatx&class=1&cpc=SOGOU">�ѹ�����</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://search.xinhuanet.com/search/searchnews.jsp?sw=$keyword2">�»�������</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://news.zhongsou.com/zsnews.cgi?word=$keyword2&hcsource=&selectact=&class1=">��������</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://news.google.com/news?hl=zh-CN&ned=cn&ie=UTF-8&q=$keyword2">GOOGLE����</a></div>
<!--ͼƬ��Դ��վ-->
<div class='parent'><font class="t1">8</font>&nbsp;ͼƬ</div>
<div id='KB8Child' class='child' style="width: 157; height:  22">&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://image.baidu.com/i?tn=baiduimage&ct=201326592&lm=- 1&z=0&rn=&_sv=6&word=$keyword2&_si.x=15&_si.y=11">�ٶ�ͼƬ</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://image.yahoo.com.cn/search?p=$keyword2&pid=82676_1006&needbid=&ei=GBK&source=3721_union">�Ż�ͼƬ</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://images.google.com/images?q=$keyword2&amp;hl=zh-CN">GoogleͼƬ</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://img.zhongsou.com/i?w=$keyword2&amp;t=&amp;l=">����ͼƬ</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a  href="http://image.sogou.com/imgsearch.jsp?keyword=$keyword2&amp;sogouhome="> �ѹ�ͼƬ</a><br>&nbsp;<font class="t2">4</font>&nbsp;
<a href="http://p.iask.com/p?k=$keyword2">����ͼƬ</a>  </div>  
</BODY>  
</HTML> 
<!--
EOT;
?>-->
