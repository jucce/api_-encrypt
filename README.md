#HTTP+对称加密+消息认证+非对称加密 api 接口加密策略 （php） 



##1.准备工作
 1.$key = 'abcd'、\##定时两端的私有key
 
 2.产生公钥私钥



##2.关于生成rsa 公钥私钥的方法
下载开源RSA密钥生成工具openssl（通常Linux系统都自带该程序），
解压缩至独立的文件夹，进入其中的bin目录，执行以下命令：

a、openssl genrsa -out rsa_private_key.pem 1024

b、openssl pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM -nocrypt -out private_key.pem

c、openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem

第一条命令生成原始 RSA私钥文件 rsa_private_key.pem

第二条命令将原始 RSA私钥转换为 pkcs8格式

第三条生成RSA公钥 rsa_public_key.pem

上面几个就可以看出：通过私钥能生成对应的公钥

##2.1 在线生成私钥公钥

网址：http://www.bm8.com.cn/webtool/rsa/




对于传输的报文采用aes对称加密，对摘要（消息认证）用的是rsa 公钥加密。
代码实现逻辑参考如下加密策略：
https://blog.p2hp.com/archives/5448