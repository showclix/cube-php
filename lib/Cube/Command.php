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
    const COLLECTD = 'collectdPut';

    private static $commands; //, $evaluator_commands, $collector_commands

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
            self::COLLECTD,
        );
    }

    public static function getOptions($command)
    {
        switch($command) {
            case self::METRIC:
                return array('expression', 'start', 'stop', 'limit', 'step');
            case self::EVENTS:
                return array('expression', 'start', 'stop', 'limit');
            case self::TYPES:
                return array();
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
        $available = self::getOptions($command);
        return count(array_diff($options, $available)) === 0;
    }
}