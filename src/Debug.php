<?php
declare(strict_types=1);

namespace icePHP;

/**
 * 调试类,用于控制调试信息的显示,通常不被直接使用1
 * 需要使用调试功能,请调用 debug方法
 */
final class Debug
{
    /**
     * 禁止实例化
     */
    private function __construct()
    {
    }

    // 程序开始执行时间
    private static $begin;

    // 程序结束时的消耗时间
    private static $persist;

    // 所有调试信息
    private static $msgs = [];

    /**
     * 重新计时,主要处理fragment的重入问题
     */
    static public function clear(): void
    {
        self::start();
    }

    /**
     * 记录开始时间
     */
    static public function start(): void
    {
        self::$begin = self::timeLog();
    }

    /**
     * 页面处理结束,在页面正文显示调试信息
     * @param $ret mixed 原来要处理的数据
     * @return string|array
     */
    static public function end($ret = null)
    {
        // 非调试状态,不处理
        if (!self::isDebug()) {
            return $ret;
        }

        //分别统计三种操作的总耗时
        $counts = $sums = ['sql' => 0, 'net' => 0, 'debug' => 0, 'cache' => 0];
        $nets = $others = [];

        $sqls = [['方法', '用时', '堆栈', 'SQL语句']];
        $caches = [['类型', '操作', '堆栈', '键', '值']];
        $nets = [['用时', '地址', '数据']];

        foreach (self::$msgs as $key => $msg) {
            if (!is_array($msg)) {
                continue;
            }

            $type = $msg['type'];

            $sums[$type] += floatval(isset($msg['time']) ? $msg['time'] : 0);
            $counts[$type]++;

            if ($type == 'sql') {
                $sqls[] = [$msg['method'], $msg['time'] . ' ms', $msg['trace'], $msg['sql']];
            } elseif ($type == 'cache') {
                $caches[] = [$msg['server'], $msg['method'], $msg['info'], $msg['key'], $msg['value']];
            } elseif ($type == 'net') {
                $nets[] = [$msg['time'] . ' ms', $msg['url'], $msg['return']];
            } elseif (!is_string($msg)) {
                $others[] = json($msg);
            }
        }

        // 如果有数据库访问调试信息并且要求记录
        if (self::isDebug('sql') and $counts['sql']) {
            $sqls[] = ['全部 ' . $counts['sql'], round($sums['sql'], 3) . ' ms', '', ''];
        }

        //如果有网络调试信息,并要求记录
        if (self::isDebug('net') and $counts['net']) {
            $nets[] = ['全部 ' . $counts['net'], round($sums['net'], 3) . ' ms', ''];
        }

        // 否则是按模板输出
        $debug = [
            'persist' => self::getPersist(),
            'sqls' => $sqls,
            'nets' => $nets,
            'caches' => $caches,
            'others' => $others
        ];

        // Ajax模式
        if (isAjax() or isset($_REQUEST['callback']) or is_array($ret)) {
            $ret['debug'] = $debug;
            return $ret;
        }

        // 如果是命令行模式,直接输出显示
        if (isCliMode()) {
            foreach ($debug['msgs'] as $msg) {
                echo $msg . "\r\n";
            }
            echo 'Persist:' . $debug['persist'] . "\r\n\r\n";
            return dump($debug, 'DEBUG', true);
        }

        // 显示输出模块
        {
            $persist = $debug['persist'];
            $usage = kmgt(memory_get_peak_usage());

            require __DIR__ . '/template.php';
        }

        return '';
    }

    /**
     * 获取本次Web访问的持续时间
     * @return float ms
     */
    static public function getPersist(): float
    {
        self::$persist = self::timeLog(self::$begin);
        return self::$persist;
    }

    /**
     * 添加一条调试信息
     * @param array|string $msg 调试信息
     * @param string $type 调试信息类别:file,sql,net,other
     */
    static public function set($msg, string $type = 'other'): void
    {
        if (is_array($msg)) {
            $msg['type'] = $type;
        }
        self::$msgs[] = $msg;
    }

    /**
     * 获取调用规模中的开发 代码信息
     * @return array [类名,调用点信息]
     */
    static private function info()
    {
        //检查调用堆栈
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $lastLine = 0;

        $line = null;
        foreach ($trace as $line) {
            if (!isset($line['class'])) {
                $line['class'] = '';
            }

            //找到最后一次调用,且不是 框架调用的
            if (substr($line['class'], 0, 6) != 'SFrame' and substr($line['class'], 0, 7) != 'icePHP\\') break;
            $lastLine = $line['line'];
        }
        $from = $line;

        $info = $from['class'] . (isset($from['type']) ? $from['type'] : '') . $from['function'] . '::' . $lastLine;
        return [$from['class'], $info];
    }

    /**
     * 记录一次数据库访问的调试信息
     *
     * @param string $method 执行方式:Query/Execute/QueryHandle/
     * @param string $prepare
     * @param  $time  float 花费的时间(毫秒)
     * @param $params array|string|null
     * @param $sql string
     */
    static public function setSql(string $method, string $prepare, float $time, $params = null, string $sql = ''): void
    {
        [$class, $info] = self::info();

        //不记录MLog里的SQL,这里都是日志
        if ($class == 'SLogTable' and $method != 'Connect') {
            return;
        }
        self::set([
            'method' => $method,
            'sql' => $sql,
            'time' => round($time, 2),
            'prepare' => $prepare,
            'params' => $params,
            'trace' => $info
        ], 'sql');
    }

    /**
     * 记录缓存相关的调试信息
     * @param string $type 缓存类型:mem/redis/file/...
     * @param string $method get/set/clear/...
     * @param string $key 键
     * @param string $value 值
     */
    static public function setCache(string $type, string $method, string $key, $value = ''): void
    {
        [, $info] = self::info();
        self::set([
            'server' => $type,
            'method' => $method,
            'key' => $key,
            'value' => mb_strlen($value) > 100 ? (mb_substr($value, 0, 100) . '...[' . mb_strlen($value) . ']') : $value,
            'info' => $info
        ], 'cache');
    }

    /**
     * 记录一次网络请求的调试信息
     * @param $url string 请求地址
     * @param $data mixed 请求参数
     * @param $return string 返回信息
     * @param $time float 用时(秒)
     */
    static public function setNet(string $url, $data, string $return, float $time): void
    {
        self::set([
            'url' => $url,
            'data' => $data,
            'return' => strlen($return) . ' bytes',
            'time' => $time
        ], 'net');
    }

    /**
     * 判断是否调试状态 ,可被临时关闭
     * 或者配置文件中指定了调试状态,或者当前请求中指定了调试状态,或者长效指定了调试状态
     * @param string $name
     * @return boolean
     */
    static public function isDebug(string $name = ''): bool
    {
        // 记录临时禁止标识
        static $closed = false;

        // 如果已经关闭了调试
        if ($closed) {
            return false;
        }

        // 如果是要求临时关闭调试
        if ($name == 'close debug') {
            $closed = true;
            return false;
        }

        // 如果请求参数中要求关闭调试
        if (isset($_REQUEST['debug']) and !$name and in_array($_REQUEST['debug'], ['close', 'off', '0', 'disabled', 'no'])) {
            return false;
        }

        // 如果配置文件中指明了调试,或者直接链接中有DEBUG,则是调试模式
        if (Config::isDebug()) {
            return true;
        }

        // 请求参数中指定了调试状态
        if (isset($_REQUEST['debug']) and (!$name or $_REQUEST['debug'] == $name)) {
            return true;
        }

        // 如果COOKIE调试指定了长效调试状态
        $key = configDefault(false, 'system', 'cookieDebug');
        if (isset($_COOKIE[$key]) and (!$name or $_COOKIE[$key] == $name)) {
            return true;
        }

        return false;
    }

    /**
     * 时间记录及计算
     * SFrame中有同名方法,为减少依赖,此处重复实现
     * @param $begin float 开始时间
     * @return float 开始时间(如果未指明开始时间)/时间间隔(如果指明时间间隔)
     */
    static private function timeLog(float $begin = null): float
    {
        // 不带参数则返回当前时间
        if (!$begin) {
            return microtime(true);
        }

        // 带参数(开始时间),则返回当前时间与开始时间的差
        return round(microtime(true) - $begin, 6);
    }

    //清除调试信息
    public static function clearMsgs(): void
    {
        self::$msgs = [];
    }
}