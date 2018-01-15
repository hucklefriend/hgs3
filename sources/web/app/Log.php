<?php
/**
 * 仮登録メーラブル
 */

namespace Hgs3;

class Log extends \Illuminate\Support\Facades\Log
{
    /**
     * Adds a log record at the DEBUG level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function debug($message, $context = array())
    {
        return parent::debug($message, $context);
    }

    /**
     * Adds a log record at the INFO level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function info($message, $context = array())
    {
        return parent::info($message, $context);
    }

    /**
     * Adds a log record at the NOTICE level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function notice($message, $context = array())
    {
        return parent::notice($message, $context);
    }

    /**
     * Adds a log record at the WARNING level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function warning($message, $context = array())
    {
        return parent::warning($message, $context);
    }

    /**
     * Adds a log record at the ERROR level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function error($message, $context = array())
    {
        return parent::error($message, $context);
    }

    /**
     * Adds a log record at the CRITICAL level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function critical($message, $context = array())
    {
        return parent::critical($message, $context);
    }

    /**
     * Adds a log record at the ALERT level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function alert($message, $context = array())
    {
        return parent::alert($message, $context);
    }

    /**
     * Adds a log record at the EMERGENCY level.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @return Boolean Whether the record has been processed
     * @static
     */
    public static function emergency($message, $context = array())
    {
        return parent::emergency($message, $context);
    }
}
