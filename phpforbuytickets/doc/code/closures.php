<?php
$message = 'hello';


/*

 闭包可以从父作用域中继承变量。 任何此类变量都应该用 use 语言结构传递进去。

Example #3 从父作用域继承变量
*/
// 没有 "use"
$example = function () {
    var_dump($message);
};
echo $example();

// 继承 $message
$example = function () use ($message) {
    var_dump($message);
};
echo $example();

// Inherited variable's value is from when the function
// is defined, not when called
$message = 'world';
echo $example();

// Reset message
$message = 'hello';

// Inherit by-reference
$example = function () use (&$message) {
    var_dump($message);
};
echo $example();

// The changed value in the parent scope
// is reflected inside the function call
$message = 'world';
echo $example();

// Closures can also accept regular arguments
$example = function ($arg) use ($message) {
    var_dump($arg . ' ' . $message);
};
$example("hello");




/*
Example #4 Closures 和作用域
// 一个基本的购物车，包括一些已经添加的商品和每种商品的数量。
// 其中有一个方法用来计算购物车中所有商品的总价格，该方法使
// 用了一个 closure 作为回调函数。
*/

class Cart
{
    const PRICE_BUTTER  = 1.00;
    const PRICE_MILK    = 3.00;
    const PRICE_EGGS    = 6.95;

    protected   $products = array();
    
    public function add($product, $quantity)
    {
        $this->products[$product] = $quantity;
    }
    
    public function getQuantity($product)
    {
        return isset($this->products[$product]) ? $this->products[$product] :
               FALSE;
    }
    
    public function getTotal($tax)
    {
        $total = 0.00;
        
        $callback =
            function ($quantity, $product) use ($tax, &$total)
            {
            	/*
					(PHP 4 >= 4.0.4, PHP 5, PHP 7)
					constant — 返回一个常量的值
					 通过 name 返回常量的值。

当你不知道常量名，却需要获取常量的值时，constant() 就很有用了。也就是常量名储存在一个变量里，或者由函数返回常量名。

该函数也适用 class constants。
参数

name

    常量名。

返回值

返回常量的值。如果常量未定义则返回 NULL。
错误／异常

如果常量未定义，会产生一个 E_WARNING 级别的错误。
范例

Example #1 constant() 的例子
<?php

define("MAXSIZE", 100);

echo MAXSIZE;
echo constant("MAXSIZE"); // same thing as the previous line


interface bar {
    const test = 'foobar!';
}

class foo {
    const test = 'foobar!';
}

$const = 'test';

var_dump(constant('bar::'. $const)); // string(7) "foobar!"
var_dump(constant('foo::'. $const)); // string(7) "foobar!"

?>

            	*/
                $pricePerItem = constant(__CLASS__ . "::PRICE_" .
                    strtoupper($product));
                echo "pricePerItem=$pricePerItem\n";
                $total += ($pricePerItem * $quantity) * ($tax + 1.0);
            };
        



/*


array_walk

(PHP 4, PHP 5, PHP 7)

array_walk — 使用用户自定义函数对数组中的每个元素做回调处理
说明
bool array_walk ( array &$array , callable $funcname [, mixed $userdata = NULL ] )

将用户自定义函数 funcname 应用到 array 数组中的每个单元。

array_walk() 不会受到 array 内部数组指针的影响。array_walk() 会遍历整个数组而不管指针的位置。
参数

array

    输入的数组。
funcname

    典型情况下 funcname 接受两个参数。array 参数的值作为第一个，键名作为第二个。

        Note:

        如果 funcname 需要直接作用于数组中的值，则给 funcname 的第一个参数指定为引用。这样任何对这些单元的改变也将会改变原始数组本身。

        Note:

        Many internal functions (for example strtolower()) will throw a warning if more than the expected number of argument are passed in and are not usable directly as funcname.

    只有 array 的值才可以被改变，用户不应在回调函数中改变该数组本身的结构。例如增加/删除单元，unset 单元等等。如果 array_walk() 作用的数组改变了，则此函数的的行为未经定义，且不可预期。
userdata

    如果提供了可选参数 userdata，将被作为第三个参数传递给 callback funcname。

返回值

成功时返回 TRUE， 或者在失败时返回 FALSE。
错误／异常

如果 funcname 函数需要的参数比给出的多，则每次 array_walk() 调用 funcname 时都会产生一个 E_WARNING 级的错误。这些警告可以通过在 array_walk() 调用前加上 PHP 的错误操作符 @ 来抑制，或者用 error_reporting()。
范例

Example #1 array_walk() 例子
<?php
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");

function test_alter(&$item1, $key, $prefix)
{
    $item1 = "$prefix: $item1";
}

function test_print($item2, $key)
{
    echo "$key. $item2<br />\n";
}

echo "Before ...:\n";
array_walk($fruits, 'test_print');

array_walk($fruits, 'test_alter', 'fruit');
echo "... and after:\n";

array_walk($fruits, 'test_print');
?>

以上例程会输出：

Before ...:
d. lemon
a. orange
b. banana
c. apple
... and after:
d. fruit: lemon
a. fruit: orange
b. fruit: banana
c. fruit: apple


*/

        array_walk($this->products, $callback);
        return round($total, 2);;
    }
}

$my_cart = new Cart;

// 往购物车里添加条目
$my_cart->add('butter', 1);
$my_cart->add('milk', 3);
$my_cart->add('eggs', 6);

// 打出出总价格，其中有 5% 的销售税.
print $my_cart->getTotal(0.05) . "\n";
// 最后结果是 54.29



class base_class  
{  
 function say_a()  
 {  
 echo "'a' - said the " . __CLASS__ . "\n";  
 }  
 function say_b()  
 {  
 echo "'b' - said the " . __CLASS__ . "\n";  
 }  
}  
  
class derived_class extends base_class  
{  
 function say_a()  
 {  
 parent::say_a();  
 echo "'a' - said the " . __CLASS__ . "\n";  
 }  
 function say_b()  
 {  
 parent::say_b();  
 echo "'b' - said the " . get_class($this) . "\n";  
 }  
}  
  
$obj_b = new derived_class();  
$obj_b->say_a();  
echo "--------------\n";  
$obj_b->say_b(); 

/*

get_calss(*) 调用者
__CLASS__  当前方法拥有者

result:
'a' - said the base_class
'a' - said the derived_class
--------------
'b' - said the derived_class
'b' - said the derived_class
*/



// for ($i = 1; $i <= 5; ++$i) {
//         $pid = pcntl_fork();

//         if (!$pid) {
//             sleep(1);
//             print "In child $i\n";
//             exit($i);
//         }
//     }

//     while (pcntl_waitpid(0, $status) != -1) {
//         $status = pcntl_wexitstatus($status);
//         echo "Child $status completed\n";
//     } 


//     $socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
//     socket_bind($socket,'localhost',8010);
//     $ret = socket_listen($socket,0);
//     print "ret = $ret\n";

//     while (true) {
//     	$connect = @socket_accept($socket);
//     	if($connect){
//     		print "get socket\n";
//     	}
//     }

// socket_getsockname($socket, $IP, $PORT);


// print $IP.":".$PORT."\n";



Class WS {
    var $master;  // 连接 server 的 client
    var $sockets = array(); // 不同状态的 socket 管理
    var $handshake = false; // 判断是否握手
    function __construct($address, $port){
        // 建立一个 socket 套接字
        $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)   
            or die("socket_create() failed");
        socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1)  
            or die("socket_option() failed");
        socket_bind($this->master, $address, $port)                    
            or die("socket_bind() failed");
        socket_listen($this->master, 2)                               
            or die("socket_listen() failed");
        $this->sockets[] = $this->master;
        // debug
        echo("Master socket  : ".$this->master."\n");
        while(true) {
            //自动选择来消息的 socket 如果是握手 自动选择主机
            $write = NULL;
            $except = NULL;
            socket_select($this->sockets, $write, $except, NULL);
            foreach ($this->sockets as $socket) {
                //连接主机的 client 
                if ($socket == $this->master){
                    $client = socket_accept($this->master);
                    if ($client < 0) {
                        // debug
                        echo "socket_accept() failed";
                        continue;
                    } else {
                        //connect($client);
                        array_push($this->sockets, $client);
                        echo "connect client\n";
                    }
                } else {
                    $bytes = @socket_recv($socket,$buffer,2048,0);
                    if($bytes == 0) 
                    {
                    	$index = array_search($this->sockets, $socket);
                    	unset($this->sockets[$index]);
                    	socket_close($socket);
                    	continue;
                    }
                    if (!$this->handshake) {
                        // 如果没有握手，先握手回应
                        $this->doHandShake($socket, $buffer);
                        echo "shakeHands\n";
                    } else {
                        // 如果已经握手，直接接受数据，并处理
                        $buffer = $this->decode($buffer);
                        //process($socket, $buffer); 
                        $this->broadcastmsg($buffer);
                        echo "get data: $buffer \n";
                    }
                }
            }
        }
    }


    function broadcastmsg($msg){
    	print "get msg len = ".strlen($msg)."\n";
    	if(strlen($msg) < 3)return;
    	foreach ($this->sockets as $key => $socket) {
    		print "check socket\n";
    		if($socket != $this->master){
    			$ret = socket_write($socket, $msg,strlen($msg));
    			print "send to client ret = $ret\n";
    			print "broadcastmsg:$msg\n";
    		}
    	}
    }


    // 解析数据帧
	function decode($buffer)  {
	    $len = $masks = $data = $decoded = null;
	    $len = ord($buffer[1]) & 127;
	    if ($len === 126)  {
	        $masks = substr($buffer, 4, 4);
	        $data = substr($buffer, 8);
	    } else if ($len === 127)  {
	        $masks = substr($buffer, 10, 4);
	        $data = substr($buffer, 14);
	    } else  {
	        $masks = substr($buffer, 2, 4);
	        $data = substr($buffer, 6);
	    }
	    for ($index = 0; $index < strlen($data); $index++) {
	        $decoded .= $data[$index] ^ $masks[$index % 4];
	    }
	    return $decoded;
	}


    function getKey($req) {
	    $key = null;
	    if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $req, $match)) { 
	        $key = $match[1]; 
	    }
	    return $key;
	}


    function encry($req){
	    $key = $this->getKey($req);
	    $mask = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
	    return base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
	}

    function dohandshake($socket, $req){
    // 获取加密key
	    $acceptKey = $this->encry($req);
	    $upgrade = "HTTP/1.1 101 Switching Protocols\r\n" .
	               "Upgrade: websocket\r\n" .
	               "Connection: Upgrade\r\n" .
	               "Sec-WebSocket-Accept: " . $acceptKey . "\r\n" .
	               "\r\n";
	    // 写入socket
	    socket_write($socket,$upgrade.chr(0), strlen($upgrade.chr(0)));
	    // 标记握手已经成功，下次接受数据采用数据帧格式
	    $this->handshake = true;
	}
}

// $ws = new WS('localhost', 4000);


/*
创建类websocket($config);
$config结构:
$config=array(
  'address'=>'192.168.0.200',//绑定地址
  'port'=>'8000',//绑定端口
  'event'=>'WSevent',//回调函数的函数名
  'log'=>true,//命令行显示记录
);
 
回调函数返回数据格式
function WSevent($type,$event)
 
$type字符串 事件类型有以下三种
in  客户端进入
out 客户端断开
msg 客户端消息到达
均为小写
 
$event 数组
$event['k']内置用户列表的userid;
$event['sign']客户标示
$event['msg']收到的消息 $type='msg'时才有该信息
 
方法:
run()运行
search(标示)遍历取得该标示的id
close(标示)断开连接
write(标示,信息)推送信息
idwrite(id,信息)推送信息
 
属性:
$users 客户列表
结构:
$users=array(
[用户id]=>array('socket'=>[标示],'hand'=[是否握手-布尔值]),
[用户id]=>arr.....
)
*/
 
class websocket{
    public $log;
    public $event;
    public $signets;
    public $users;  
    public $master; 
    public function __construct($config){
        if (substr(php_sapi_name(), 0, 3) !== 'cli') {
            die("请通过命令行模式运行!");
        }
        error_reporting(E_ALL);
        set_time_limit(0);
        ob_implicit_flush();
        $this->event = $config['event'];
        $this->log = $config['log'];
        $this->master=$this->WebSocket($config['address'], $config['port']);
        $this->sockets=array('s'=>$this->master);
    }
    function WebSocket($address,$port){
        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($server, $address, $port);
        socket_listen($server);
        $this->log('开始监听: '.$address.' : '.$port);
        return $server;
    }
  function run(){
    while(true){
      $changes=$this->sockets;
      @socket_select($changes,$write=NULL,$except=NULL,NULL);
      foreach($changes as $sign){
        if($sign==$this->master){
          $client=socket_accept($this->master);
          $this->sockets[]=$client;
          $user = array(
            'socket'=>$client,
            'hand'=>false,
          );
          $this->users[] = $user;
          $k=$this->search($client);
          $eventreturn = array('k'=>$k,'sign'=>$sign);
          $this->eventoutput('in',$eventreturn);
        }else{
          $len=socket_recv($sign,$buffer,2048,0);
          $k=$this->search($sign);
          $user=$this->users[$k];
          if($len<7){
            $this->close($sign);
            $eventreturn = array('k'=>$k,'sign'=>$sign);
            $this->eventoutput('out',$eventreturn);
            continue;
          }
          if(!$this->users[$k]['hand']){//没有握手进行握手
            $this->handshake($k,$buffer);
          }else{
            $buffer = $this->uncode($buffer);
            $eventreturn = array('k'=>$k,'sign'=>$sign,'msg'=>$buffer);
            $this->eventoutput('msg',$eventreturn);
          }
        }
      }
    }
  }
  function search($sign){//通过标示遍历获取id
    foreach ($this->users as $k=>$v){
      if($sign==$v['socket'])
      return $k;
    }
    return false;
  }
  function close($sign){//通过标示断开连接
    $k=array_search($sign, $this->sockets);
    socket_close($sign);
    unset($this->sockets[$k]);
    unset($this->users[$k]);
  }
  function handshake($k,$buffer){
    $buf  = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
    $key  = trim(substr($buf,0,strpos($buf,"\r\n")));
    $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
    $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
    $new_message .= "Upgrade: websocket\r\n";
    $new_message .= "Sec-WebSocket-Version: 13\r\n";
    $new_message .= "Connection: Upgrade\r\n";
    $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
    socket_write($this->users[$k]['socket'],$new_message,strlen($new_message));
    $this->users[$k]['hand']=true;
    return true;
  }
  function uncode($str){
    $mask = array();  
    $data = '';  
    $msg = unpack('H*',$str);  
    $head = substr($msg[1],0,2);  
    if (hexdec($head{1}) === 8) {  
      $data = false;  
    }else if (hexdec($head{1}) === 1){  
      $mask[] = hexdec(substr($msg[1],4,2));
      $mask[] = hexdec(substr($msg[1],6,2));
      $mask[] = hexdec(substr($msg[1],8,2));
      $mask[] = hexdec(substr($msg[1],10,2));
      $s = 12;  
      $e = strlen($msg[1])-2;  
      $n = 0;  
      for ($i=$s; $i<= $e; $i+= 2) {  
        $data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2)));  
        $n++;  
      }  
    }  
    return $data;
  }
    function code($msg){
      $msg = preg_replace(array('/\r$/','/\n$/','/\r\n$/',), '', $msg);
      $frame = array();  
      $frame[0] = '81';  
      $len = strlen($msg);  
      $frame[1] = $len<16?'0'.dechex($len):dechex($len);
      $frame[2] = $this->ord_hex($msg);
      $data = implode('',$frame);
      return pack("H*", $data);
    }
    function ord_hex($data)  {  
      $msg = '';  
      $l = strlen($data);  
      for ($i= 0; $i<$l; $i++) {  
        $msg .= dechex(ord($data{$i}));  
      }  
      return $msg;  
    }
 
    function idwrite($id,$t){//通过id推送信息
      if(!$this->users[$id]['socket']){return false;}//没有这个标示
      $t=$this->code($t);
      return socket_write($this->users[$id]['socket'],$t,strlen($t));
    }
    function write($k,$t){//通过标示推送信息
      $t=$this->code($t);
      return socket_write($k,$t,strlen($t));
    }

    function broadcast($t){
    	foreach ($this->users as $key => $user) {
    		
    		$this->write($user["socket"],$t);
    	}
    }

    function eventoutput($type,$event){//事件回调
      call_user_func($this->event,$type,$event);
    }
    function log($t){//控制台输出
      if($this->log){
        $t=$t."\r\n";
        fwrite(STDOUT, iconv('utf-8','gbk//IGNORE',$t));
      }
    }
}

// new WebSocket("localhost",4000);

// 创建类websocket($config);
// $config结构:

$config=array(
  'address'=>'localhost',
  'port'=>'4000',
  'event'=>'WSevent',//回调函数的函数名
  'log'=>true,
);
$websocket = new websocket($config);
$websocket->run();
function WSevent($type,$event){
  global $websocket;
    if('in'==$type){
      $websocket->log('客户进入id:'.$event['k']);
    }elseif('out'==$type){
      $websocket->log('客户退出id:'.$event['k']);
    }elseif('msg'==$type){
      $websocket->log($event['k'].'消息:'.$event['msg']);
      roboot($event['sign'],$event['msg']);
    }
}
 
function roboot($sign,$t){
  global $websocket;
  switch ($t)
  {
  case 'hello':
    $show='hello,GIt @ OSC';
    break;  
  case 'name':
    $show='Robot';
    break;
  case 'time':
    $show='当前时间:'.date('Y-m-d H:i:s');
    break;
  case '再见':
    $show='( ^_^ )/~~拜拜';
    $websocket->write($sign,'Robot:'.$show);
    $websocket->close($sign);
    return;
    break;
  case '天王盖地虎':
    $array = array('小鸡炖蘑菇','宝塔震河妖','粒粒皆辛苦');
    $show = $array[rand(0,2)];
    break;
  default:
    // $show='( ⊙o⊙?)不懂,你可以尝试说:hello,name,time,再见,天王盖地虎.';
  	$show = $t;	
  }
  // $websocket->write($sign,'Robot:'.$show);
  $websocket->broadcast($show);
}
?>

