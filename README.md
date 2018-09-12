显示/记录调试信息
=

* 记录开始时间

    Debug::start(): void

* 页面处理结束,返回或在页面正文显示调试信息

    Debug::end($ret = null)

* 获取本次Web访问的持续时间
    
    Debug::getPersist(): float

* 添加一条调试信息
    
    Debug::set($msg, string $type = 'other'): void
    
    或
    
    debug($msg): void

* 记录一次数据库访问的调试信息

    Debug::setSql(string $method, string $prepare, float $time, $params = null, string $sql = ''): void

* 记录一次网络请求的调试信息

    Debug::setNet(string $url, $data, string $return, float $time): void

* 判断是否调试状态 ,可被临时关闭

    Debug::isDebug(string $name = ''): bool
    
    或
    
    isDebug(string $name = ''): bool

* 清除调试信息

    Debug::clearMsgs():void

* 重新计时,主要处理fragment的重入问题

    Debug::clear(): void
