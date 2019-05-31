#api 接口加密策略 （php）

##1.HTTP+对称加密+消息认证+非对称加密


对于传输的报文采用aes对称加密，对摘要（消息认证）用的是rsa 公钥加密。
代码实现逻辑参考如下加密策略：
https://blog.p2hp.com/archives/5448