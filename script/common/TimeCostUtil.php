<?php
/**
 * 时间消耗统计工具类
 * 用于记录代码执行时间，便于性能分析和优化
 * 使用示例：$tt = TimeCostUtil::start("必要msg"), 必须赋值$tt, 以保证正确记录时间
 * 单个函数内，多处处调用start方法，需要显式调用end方法
 */
class TimeCostUtil
{
    private $msg;

    private $callerInfo = [];

    private $startTime;

    private $endTime;

    private $isRecord = false;

    const LOG_TAG = "time_cost";


    private static function createInstance(string $msg, $callerInfo): TimeCostUtil
    {
        $obj = new self();
        $obj->msg = $msg;
        return $obj;
    }

    public static function start(string $msg): TimeCostUtil
    {
        $callerInfo = self::getCaller(2);
        $obj = self::createInstance($msg, $callerInfo);
        $obj->startTime = microtime(true);
        $obj->callerInfo = $callerInfo;
        return $obj;
    }


    public function end()
    {
        $this->isRecord = true;
        $this->endTime = microtime(true);
        $costTime = $this->endTime - $this->startTime;
        $logMsg = "{$this->msg} {$this->callerInfo['function']} cost(ms): " . round(1000*$costTime, 1);
        $logExtra = [
            'function' => $this->callerInfo['function_name'] ?? '',
            'fie' => $this->callerInfo['file'] ?? '',
            'line' => $this->callerInfo['line'] ?? '',
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'cost_time' => $costTime,
        ];
        LoggerV2::info($logMsg, self::LOG_TAG, $logExtra);
    }


    public function __destruct()
    {
        if (!$this->isRecord) {
            $this->end();
        }
    }

    private static function getCaller($level = 1): array
    {
        $trace = debug_backtrace();
        $callerIndex = $level;
        $callerFn = "";
        if (isset($trace[$callerIndex])) {
            $caller = $trace[$callerIndex];
            if ($caller['class']) {
                $callerFn .= $caller['class'];
                $callerFn .= $caller['type'] ?: '::';
            }
            $callerFn .= $caller['function'];
            return [
                'function_name' => $callerFn,
                'function' => $caller['function'] ?? '',
                'class' => $caller['class'] ?? '',
                'type' => $caller['type'] ?? '', // -> 或 ::
                'file' => $caller['file'] ?? '',
                'line' => $caller['line'] ?? '',
                'args' => $caller['args'] ?? []
            ];
        }
        return [];
    }

    private function __construct(){}
    private function __clone(){}


}









