<?php


class Rsa {
 
    /**     
     * 获取私钥     
     * @return bool|resource     
     */    
    private static function getPrivateKey() 
    {        
        $abs_path = dirname(__FILE__) . '/rsa_private_key.pem';
        $content = file_get_contents($abs_path);    
        return openssl_pkey_get_private($content);    
    }    

    /**     
     * 获取公钥     
     * @return bool|resource     
     */    
    private static function getPublicKey()
    {   
        $abs_path = dirname(__FILE__) . '/rsa_public_key.pem';
        $content = file_get_contents($abs_path);    
        return openssl_pkey_get_public($content);     
    }

    /**     
     * 私钥加密     
     * @param string $data     
     * @return null|string     
     */    
    public static function privEncrypt($data = '')    
    {        
        if (!is_string($data)) {            
            return null;       
        }        
        return openssl_private_encrypt($data,$encrypted,self::getPrivateKey()) ? base64_encode($encrypted) : null;    
    }    

    /**     
     * 公钥加密     
     * @param string $data     
     * @return null|string     
     */    
    public static function publicEncrypt($data = '')   
    {        
        if (!is_string($data)) {            
            return null;        
        }        
        return openssl_public_encrypt($data,$encrypted,self::getPublicKey()) ? base64_encode($encrypted) : null;    
    }    

    /**     
     * 私钥解密     
     * @param string $encrypted     
     * @return null     
     */    
    public static function privDecrypt($encrypted = '')    
    {        
        if (!is_string($encrypted)) {            
            return null;        
        }        
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;    
    }    

    /**     
     * 公钥解密     
     * @param string $encrypted     
     * @return null     
     */    
    public static function publicDecrypt($encrypted = '')    
    {        
        if (!is_string($encrypted)) {            
            return null;        
        }        
    return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;    
    }


    /**
     * --------------------------------------------------------------------------
     * aes AES-128-CBC 加密
     * --------------------------------------------------------------------------
     * @param $str
     * @param $privateKey
     * @return string
     */
    public static function aesAncrypt($str, $privateKey)
    {
        $iv= '12f862d21d3ceafb';

        return base64_encode(openssl_encrypt($str, 'AES-128-CBC',$privateKey, OPENSSL_RAW_DATA , $iv));   # AES-128-CBC
    }

    /**
     * --------------------------------------------------------------------------
     * aes AES-128-CBC 解密
     * --------------------------------------------------------------------------
     * @param $str
     * @param $privateKey
     * @return string
     */
    public static function aesDecrypt($encryptedData = '' , $privateKey)
    {

        $iv= '12f862d21d3ceafb';

        return openssl_decrypt(base64_decode($encryptedData), 'AES-128-CBC', $privateKey, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * --------------------------------------------------------------------------
     * 产生数据认证的摘要
     * --------------------------------------------------------------------------
     */
    public  function digest($data,$key)
    {
        return hash_hmac('sha256',json_encode($data),$key);
    }

    /**
     * --------------------------------------------------------------------------
     * 验证数据是否被修改过，真实性，完整性
     * --------------------------------------------------------------------------
     * @param $json_data
     * @param $key
     */
    public function is_update($json_data, $key)
    {
        $data = json_decode($json_data,true);

        //对摘要进行res 私钥解密
        $digest = $this->privDecrypt($data['digest']);

        echo 'res 解密后的摘要内容：'.$digest.'<br>';

        //开始判断数据完整性
        $new_data['name'] = $data['name'];
        $new_data['age'] =$data['age'];
        return $this->is_correct($new_data,$digest,$key);
    }


    private function is_correct($data,$digest,$key)
    {
        $server_digest = self::digest($data,$key);
        echo 'server 产生摘要内容：'.$server_digest.'<br>';

        if($server_digest === $digest) {
            return '未被修改';
        } else {
            return '被修改';
        }

    }





}
