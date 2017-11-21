<?php

namespace TwoFASLight\Option;

class TwoFASLight_Option
{
    /**
     * @return mixed|void
     */
    public function get_blog_name()
    {
        return get_option('blogname', 'WordPress Account');
    }
}
