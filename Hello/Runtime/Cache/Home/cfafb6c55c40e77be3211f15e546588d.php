<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>hello</title>
</head>
<body>
    <FORM method="post" action="/hello.php/Home/Form/insert">
	标题：<INPUT type="text" name="title"><br/>
	内容：<TEXTAREA name="content" rows="5" cols="45"></TEXTAREA><br/>
	<INPUT type="submit" value="提交">
	</FORM>
</body>
</html>