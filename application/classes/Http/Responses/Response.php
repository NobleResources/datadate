<?php

namespace DataDate\Http\Responses;

class Response
{
    private $headers;
    private $content;
    private $cookies;
    private $code;

    public function __construct($content, $code = 200, $headers = [], $cookies = [])
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->code = $code;
    }

    public function send()
    {
        http_response_code($this->code);

        foreach ($this->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value));
        }

        foreach ($this->cookies as $name => $value) {
            setcookie($name, $value);
        }

        echo $this->content;

        exit();
    }
}