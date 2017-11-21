<?php

namespace TwoFASLight;

use TwoFASLight\Cookie\TwoFASLight_Cookie;
use TwoFASLight\Device\TwoFASLight_Trusted_Device;
use TwoFASLight\Option\TwoFASLight_Option;
use TwoFASLight\Action\TwoFASLight_Router;
use TwoFASLight\Request\TwoFASLight_Request;
use TwoFASLight\Request\TwoFASLight_Request_Context;
use TwoFASLight\TOTP\TwoFASLight_TOTP;
use TwoFASLight\User\TwoFASLight_User;
use TwoFASLight\View\TwoFASLight_View_Renderer;

abstract class TwoFASLight_App
{
    /**
     * @var TwoFASLight_Request_Context
     */
    protected $request_context;

    /**
     * @var TwoFASLight_Request
     */
    protected $request;

    /**
     * @var TwoFASLight_Router
     */
    protected $router;

    /**
     * @var TwoFASLight_View_Renderer
     */
    protected $view_renderer;

    /**
     * @var TwoFASLight_TOTP
     */
    protected $totp;

    /**
     * @var TwoFASLight_User
     */
    protected $user;

    /**
     * @var TwoFASLight_Option
     */
    protected $options;

    /**
     * @var TwoFASLight_Cookie
     */
    protected $cookie;

    /**
     * TwoFASLight_App constructor.
     */
    public function __construct()
    {
        $this->request_context = new TwoFASLight_Request_Context();
        $this->request_context->fill_with_global_arrays($_GET, $_POST, $_SERVER, $_COOKIE, $_REQUEST);

        $this->router = new TwoFASLight_Router();

        $this->view_renderer = new TwoFASLight_View_Renderer();
        $this->view_renderer->init();
        
        $this->user = new TwoFASLight_User(wp_get_current_user()->ID);
        
        $this->options = new TwoFASLight_Option();
        
        $this->totp = new TwoFASLight_TOTP($this);
        
        $this->cookie = new TwoFASLight_Cookie();
    }

    /**
     * @return TwoFASLight_View_Renderer
     */
    public function get_view_renderer()
    {
        return $this->view_renderer;
    }

    /**
     * @return TwoFASLight_TOTP
     */
    public function get_totp()
    {
        return $this->totp;
    }

    /**
     * @return TwoFASLight_User
     */
    public function get_user()
    {
        return $this->user;
    }

    /**
     * @return TwoFASLight_Option
     */
    public function get_options()
    {
        return $this->options;
    }

    /**
     * @return TwoFASLight_Request
     */
    public function get_request()
    {
        return $this->request;
    }

    /**
     * @return TwoFASLight_Cookie
     */
    public function get_cookie()
    {
        return $this->cookie;
    }

    /**
     * @return TwoFASLight_Trusted_Device
     */
    public function get_trusted_device()
    {
        return new TwoFASLight_Trusted_Device($this->get_request(), $this->get_user(), $this->get_cookie());
    }

    abstract public function run();
}
