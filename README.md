# debug
显示/记录调试信息

## 记录开始时间
start(): void

## 页面处理结束,返回或在页面正文显示调试信息
end($ret = null)

## 获取本次Web访问的持续时间
getPersist(): float

## 添加一条调试信息
set($msg, string $type = 'other'): void

## 记录一次数据库访问的调试信息
setSql(string $method, string $prepare, float $time, $params = null, string $sql = ''): void

## 记录一次网络请求的调试信息
setNet(string $url, $data, string $return, float $time): void

## 判断是否调试状态 ,可被临时关闭
isDebug(string $name = ''): bool

## 清除调试信息
clearMsgs():void

## 重新计时,主要处理fragment的重入问题
clear(): void
