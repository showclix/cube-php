<?php
namespace Cube\Connection;
abstract class Connection {
    public function __construct(array $conf = array())
    {
        $this->conf = $conf;
        $this->init($conf);
    }

    public function getConf()
    {
        return $this->conf;
    }

    /**
     * @param string $command e.g. eventGet, eventPut
     * @param array $args command arguments
     * @return array response from call
     */
    public final function call($command, $args)
    {
        $this->pre($command, $args);
        $result = call_user_func(array($this, $command), $args);
        $this->pre($command, $args, $result);
        return $result;
    }

    // Optional pre and post hooks that can be implemented by the
    // sub classes.  These hooks are called directly before or after
    // a call to the command method.

    /**
     * @param string $command
     * @param array $args
     */
    public function pre($command, $args){}

    /**
     * @param string $command
     * @param array $args
     * @param array $result
     */
    public function post($command, $args, $result){}

    // Methods that each Connection sub class should instantiate
    // One for each cube command available.  Following an Adapter
    // pattern of sorts here.  See \Cube\Command for list of
    // available arguments for each method/command.

    /**
     * @param array $args
     * @return array
     */
    public function eventGet($args)
    {
        throw new \Cube\Exception\UnsupportedMethodException();
    }

    /**
     * @param array $args
     * @return array
     */
    public function metricGet($args)
    {
        throw new \Cube\Exception\UnsupportedMethodException();
    }

    /**
     * @param array $args
     * @return array
     */
    public function typesGet($args)
    {
        throw new \Cube\Exception\UnsupportedMethodException();
    }

    /**
     * @param array $args
     * @return array
     */
    public function eventPut($args)
    {
        throw new \Cube\Exception\UnsupportedMethodException();
    }

    /**
     * @param array $args
     * @return array
     */
    public function collectd($args)
    {
        throw new \Cube\Exception\UnsupportedMethodException();
    }

    abstract public function init(array $args);
}
