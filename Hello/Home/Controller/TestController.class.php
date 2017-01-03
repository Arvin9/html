<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
	public function index(){
		echo "index";
	}
	public function hello(){
    	//变量
    	//变量名必须通过'$'符号标识。
    	//以字母或下划线'_'开头、区分大小写
    	//只能由字母、数字、以及"_"组成、不允许有空格
    	//当变量名由多个单词组成，建议使用“_”进行分隔（比如$my_apple），俗称下划线法，或者以大写字母开头比如$myApple，俗称骆驼式命名法（也称驼峰命名法）。
    	//布尔类型（boolean）：只有两个值，一个是TRUE，另一个FALSE，可以理解为是或否。它不区分大小写。
    	$var = "hello world!<br>"; 
    	$n = 10;
    	echo $var;
    	//var_dump函数可以将变量的数据类型显示出来
    	var_dump($var);
    	var_dump(n);

    	//memory_get_usage”获取当前PHP消耗的内存
    	echo memory_get_usage();
   	
    	//布尔类型true,flag
    	echo "<br>";
    	$flag = true;
    	echo $flag;

    	//浮点型
    	echo "<br>";
    	$num_float = 1.234;    	//小数点  
		$num_float = 1.2e3;    	//科学计数法，小写e  
		$num_float = 7.0E-10;   //科学计数法，大写E
		echo $num_float;

		//字符串
		//字符串型可以用三种方法定义：单引号形式、双引号形式和Heredoc结构形式
		//当双引号中包含变量时，变量会与双引号中的内容连接在一起
		//当单引号中包含变量时，变量会被当做字符串输出。
		echo "<br/>";
		$love = "I love you!"; 
		$string1 = "$love";
		$string2 = '$love';
		echo $string1;
		echo "<br />";
		echo $string2;

		//Heredoc结构形式解决字符串很长的问题。首先使用定界符表示字符串（<<<），接着在“<<<“之后提供一个标识符GOD，然后是字符串，最后以提供的这个标识符结束字符串。
		$string1 = <<<GOD
		我有一只小毛驴，我从来也不骑。
		有一天我心血来潮，骑着去赶集。
		我手里拿着小皮鞭，我心里正得意。
		不知怎么哗啦啦啦啦，我摔了一身泥.
GOD;

		echo $string1;

		//资源类型
		//“fopen”函数打开文件，得到返回值的就是资源类型。
		$file_handle = fopen("/var/www/html/hello.php","r");
		if ($file_handle){
		//接着采用while循环（后面语言结构语句中的循环结构会详细介绍）一行行地读取文件，然后输出每行的文字
		    while (!feof($file_handle)) { //判断是否到最后一行
		        $line = fgets($file_handle); //读取一行文本
		        echo $line; //输出一行文本
		        echo "<br />"; //换行
		    }
		}
		fclose($file_handle);//关闭文件

		//空类型
		//NULL是空类型，对大小写不敏感
    }

    public function quantity(){
    	echo "quantity<br>";
    	//define()函数的语法格式为：
    	//bool define(string $constant_name, mixed $value[, $case_sensitive = true])
    	$p = "PII";
		define("PI",3.14);
		define($p,3.14);
		echo PI;
		echo "<br/>";
		echo PII;
		//__FILE__ :php程序文件名。它可以帮助我们获取当前文件在服务器的物理位置。
		echo "<br/>";
		echo __FILE__;
		//__LINE__ :PHP程序文件行数。它可以告诉我们，当前代码在第几行。
		echo "<br/>";
		echo __LINE__;
		//PHP_VERSION:当前解析器的版本号。它可以告诉我们当前PHP解析器的版本号，我们可以提前知道我们的PHP代码是否可被该PHP解析器解析。
		echo "<br/>";
		echo PHP_VERSION;
		//PHP_OS：执行当前PHP版本的操作系统名称。它可以告诉我们服务器所用的操作系统名称，我们可以根据该操作系统优化我们的代码。
		echo "<br/>";
		echo PHP_OS;

		//constant()函数,它和直接使用常量名输出的效果是一样的，但函数可以动态的输出不同的常量。
		//mixed constant(string constant_name)
		echo "<br/>";
		echo constant("PI");
	}

	public function operator(){
		//算术运算符，'+'、'-'、'*'、'/'、'%'
		$a = 2;
		$b = 1;
		$c = $a + $b;
		echo $c."<br/>";
		$c = $a - $b;
		echo $c."<br/>";
		$c = $a * $b;
		echo $c."<br/>";
		$c = $a / $b;
		echo $c."<br/>";

		//“=”：把右边表达式的值赋给左边的运算数。
		//“&”：引用赋值，意味着两个变量都指向同一个数据。

		// == 等于
		// === 全等
		// != 不等
		// <> 不等
		// !== 非全等
		// < 小于
		// > 大于
		// <= 小于等于
		// >= 大于等于

		//三元运算符
		$b = $a >= 60 ? "及格": "不及格";
		echo $b."<br>"; 

		//逻辑运算
		// and or xor && ||
	}
}