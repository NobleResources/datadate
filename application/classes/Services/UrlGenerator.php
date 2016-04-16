<?php

namespace DataDate\Services;

use DataDate\Http\Request;

class UrlGenerator
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var string
     */
    private $baseUri;

    /**
     * UrlGenerator constructor.
     *
     * @param Request $request
     * @param string  $baseUri
     */
    public function __construct(Request $request, $baseUri)
    {
        $this->request = $request;
        $this->baseUri = $this->removeTrailingSlash($baseUri);
    }

    /**
     * Generate a uri to a resource
     *
     * @param $to
     *
     * @return string
     */
    public function generate($to)
    {
        if ($this->full($to)) {
            return $to;
        }

        if ($this->isAbsolute($to)) {
            return $this->baseUri . $to;
        }

        return $this->removeTrailingSlash($this->current()) . '/' . $to;
    }

    /**
     * Get the uri of the current request
     *
     * @return mixed
     */
    public function current()
    {
        return $this->request->uri();
    }

    /**
     * @param $to
     *
     * @return bool
     */
    private function isAbsolute($to)
    {
        return strpos($to, '/') === 0;
    }

    /**
     * @param $baseUri
     *
     * @return mixed
     */
    private function removeTrailingSlash($baseUri)
    {
        return rtrim($baseUri, '/');
    }

    /**
     * @param $to
     *
     * @return bool
     */
    private function full($to)
    {
        return strpos($to, 'http://') !== false || strpos($to, 'https://') !== false;
    }
}