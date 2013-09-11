<?php

namespace Cube;

class Command
{
    // Evaluator
    const EVENTS = 'eventGet';
    const METRIC = 'metricGet';
    const TYPES = 'typesGet';

    // Collector
    const SEND = 'eventPut';

    const ISO8601 = 'c';

    private static $commands;

    /**
     * @return array
     */
    public static function getCommands()
    {
        if (isset(self::$commands))
            return self::$commands;

        // Consider reflection?  Meh.
        return self::$commands = array(
            self::EVENTS,
            self::METRIC,
            self::TYPES,
            self::SEND,
        );
    }

    /**
     * @return array available options for $command
     * @param string $command see self::$commands
     */
    public static function getOptions($command)
    {
        switch($command) {
            case self::METRIC:
                return array('expression', 'start', 'stop', 'limit', 'step');
            case self::EVENTS:
                return array('expression', 'start', 'stop', 'limit');
            case self::TYPES:
                return array();
            case self::SEND:
                return array('type', 'time', 'data');
        }
        throw new \Cube\Exception\InvalidCommandException();
    }

    /**
     * @param string $command
     * @return bool
     */
    public static function isValidCommand($command)
    {
        return in_array($command, self::getCommands());
    }

    /**
     * @return bool are these $options valid for $command?
     * @param string $command
     * @param array $options
     */
    public static function areValidOptions($command, array $options)
    {
        return true; // todo
        // $available = self::getOptions($command);
        // return count(array_diff($options, $available)) === 0;
    }

    /**
     * @return array of cleaned arguments (validates time)
     * @param array $args array('time' => , 'type' => , 'data' => )
     */
    public static function prepPayload($args)
    {
        // Wrap the "dict" in an array if it isn't already wrapped
        // Cube expects lists of entries
        if (isset($args['data'])) $args = array($args);

        foreach ($args as &$entry) {
            if (count(array_diff(array_keys($entry), self::getOptions(self::SEND))) !== 0)
                throw new \Cube\Exception\InvalidCubeEvent();
            $time = isset($entry['time']) ? $entry['time'] : time();
            if (is_string($time))
                $time = strtotime($time);
            $entry['time'] = date('c', $time);
        }

        return $args;
    }
}
