<?php

require_once "Rsa.php";
$key = '12f862d21d3ceafb123';//定义的共同key
$rsa = new Rsa();
$data['name'] = 'Tom';
$data['age']  = '20';

$privEncrypt = $rsa->privEncrypt(json_encode($data));
echo '私钥加密后:'.$privEncrypt.'<br>';

$publicDecrypt = $rsa->publicDecrypt($privEncrypt);
echo '公钥解密后:'.$publicDecrypt.'<br>';

$publicEncrypt = $rsa->publicEncrypt(json_encode($data));
echo '公钥加密后:'.$publicEncrypt.'<br>';

$privDecrypt = $rsa->privDecrypt($publicEncrypt);
echo '私钥解密后:'.$privDecrypt.'<br>';



$aesEncrypt = $rsa->aesAncrypt(json_encode($data),$key);
echo 'aes加密后:'.$aesEncrypt.'<br>';

$aesDecrypt = $rsa->aesDecrypt($aesEncrypt,$key);
echo 'aes解密密后:'.$aesDecrypt.'<br>';

echo md5('1234').'<br>';

 echo hash('sha512', '1234').'<br>';
 echo hash_hmac('sha256', '1234',$key).'<br>';


echo '--------------------------加密流程如下------------------------------------------------------'.'<br>';

echo '获取摘要'.'</br>';
$digest = $rsa->digest($data,$key);
echo '摘要内容为：'.$digest.'</br>';

echo '将摘要用rsa 非对称加密：'.'</br>';
$publicDigest = $rsa->publicEncrypt($digest);
echo '摘要用rsa 非对称加密内容为：'.$publicDigest.'</br>';

$data['digest'] = $publicDigest;


print_r($data).'</br>';


echo 'aes 对称加密数据：'.'</br>';
$dataAesEncrypt = $rsa->aesAncrypt(json_encode($data),$key);
echo 'aes 对称加密数据内容：'.$dataAesEncrypt.'</br>';

echo '开始解密'.'</br>';
echo 'aes 对称解密数据'.'</br>';
$dataAesDecrypt = $rsa->aesDecrypt($dataAesEncrypt,$key);
echo 'aes 对称解密数据内容：'.$dataAesDecrypt.'</br>';

echo '开始判断数据是否被修改'.'<br>';
$result = $rsa->is_update($dataAesDecrypt,$key);


var_dump($result);











//





