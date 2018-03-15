<?php

/**
 * Created by PhpStorm.
 * User: mikake
 * Date: 18/03/15
 * Time: 21:42
 */
class Response
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $status_code = 200;

    /**
     * @var string
     */
    protected $status_text = 'OK';

    /**
     * @var array
     */
    protected $http_headers = array();

    public function send()
    {
        header('HTTP/1.1' . $this->status_code . ' ' . $this->status_text);

        foreach ($this->http_headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param $status_code
     * @param string $status_text
     */
    public function setStatusCode($status_code, $status_text = '')
    {
        $this->status_code = $status_code;
        $this->status_text = $status_text;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setHttpHeader($name, $value)
    {
        $this->http_headers[$name] = $value;
    }
}