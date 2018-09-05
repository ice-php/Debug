<?php
declare(strict_types=1);

namespace icePHP;

/**
 * 记录调试信息
 * 这是Debug的一个快捷入口
 * @param array|string $msg 要显示的信息
 */
function debug($msg): void
{
    isDebug() ? Debug::set($msg) : null;
}

/**
 * 判断当前是否调试状态
 *
 * @param string $name 调试状态名,此参数用来同时 调试不同的内容
 * @return boolean 是否是指定的调试状态
 */
function isDebug(string $name = ''): bool
{
    return Debug::isDebug($name);
}