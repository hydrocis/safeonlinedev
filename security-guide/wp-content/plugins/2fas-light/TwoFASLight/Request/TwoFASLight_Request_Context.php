<?php

namespace TwoFASLight\Request;

class TwoFASLight_Request_Context
{
    /**
     * @var array
     */
    private $get;
    
    /**
     * @var array
     */
    private $post;
    
    /**
     * @var array
     */
    private $server;
    
    /**
     * @var array
     */
    private $cookie;

    /**
     * @var array
     */
    private $request;
    
    /**
     * @param array $get
     * @param array $post
     * @param array $server
     * @param array $cookie
     * @param array $request
     */
    public function fill_with_global_arrays(array $get, array $post, array $server, array $cookie, array $request)
    {
        $this->get     = $get;
        $this->post    = $post;
        $this->server  = $server;
        $this->cookie  = $cookie;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function get_request()
    {
        return $this->request;
    }
    
    /**
     * @return array
     */
    public function get_get()
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function get_post()
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function get_server()
    {
        return $this->server;
    }

    /**
     * @return array
     */
    public function get_cookie()
    {
        return $this->cookie;
    }
}
