<?php
	


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.jb51.net/article/48866.htm");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);





 $post_data = array (
          "blog_name" => "360weboy",
          "blog_url" => "http://www.360weboy.com",
          "action" => "Submit"
        );
// 设置请求为post类型
curl_setopt($ch, CURLOPT_POST, 1);
// 添加post数据到请求中
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

$response = curl_exec($ch);
print "result:\n".$response;

curl_close($ch);

?>