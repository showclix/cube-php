<?php
namespace Cube\Connection;
class HttpConnection extends \Cube\Connection\Connection {
    public $connected = false, $uri;

    /**
     * @param array $conf
     *    host: string required ip or hostname
     *    port: int required
     *    secure: bool optional use https?
     */
    public function init(array $conf)
    {
        $secure = empty($conf['secure']) ? '' : 's';
        $this->uri = sprintf('http%s://%s:%s/', $secure, $conf['host'], $conf['port']);

        // Needed to tell httpful to use arrays instead of plain objects for json responses
        \Httpful\Httpful::register(\Httpful\Mime::JSON, new \Httpful\Handlers\JsonHandler(array('decode_as_array' => true)));
    }

    public function eventGet($args)
    {
        $query = http_build_query($args);
        $res = $this->send($this->uri . '1.0/event/get?' . $query);
        return $res->body;
    }

    public function metricGet($args)
    {
        $query = http_build_query($args);
        $res = $this->send($this->uri . '1.0/metric/get?' . $query);
        return $res->body;
    }

    public function typesGet($args)
    {
        $res = $this->send($this->uri . '1.0/types/get');
        return $res->body;
    }

    private function send($url)
    {
        $res = \Httpful\Request::get($url)->expectsJson()->send();
        return $res;
    }
}
