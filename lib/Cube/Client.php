<?php
/**
 * Primary client
 */

namespace Cube;

class Client
{
    private $connection;

    const INT_TEN_SECOND    = '1e4';
    const INT_ONE_MINUTE    = '6e4';
    const INT_FIVE_MINUTES  = '3e5';
    const INT_ONE_HOUR      = '36e5';
    const INT_ONE_DAY       = '864e5';

    /**
     * @param \Cube\Connection\Connection $connection
     */
    public function __construct(\Cube\Connection\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Convenience method for creating a new Cube Client using the http
     * connection class
     *
     * @return Cube\Client
     * @param array $conf See Connection\HttpConnection for conf
     */
    public static function createHttpClient(array $args = array())
    {
        $conn = new Connection\HttpConnection($args);
        return new Client($conn);
    }

    public function __call($name, $args)
    {
        if (!Command::isValidCommand($name)) {
            throw new \Cube\Exception\InvalidCommandException();
        }
        $options = isset($args[0]) ? $args[0] : array();
        if (!Command::areValidOptions($name, $options)) {
            throw new \Cube\Exception\InvalidOptionException();
        }
        return $this->connection->call($name, $options);
    }
}