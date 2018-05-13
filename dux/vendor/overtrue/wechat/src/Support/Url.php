<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Url.php.
 *
 * @author    overtrue <i@overtrue.me>
 * @copyright 2015 overtrue <i@overtrue.me>
 *
 * @see      http://github.com/overtrue
 * @see      http://overtrue.me
 */

namespace EasyWeChat\Support;

/**
 * Class Url.
 */
class Url
{
    /**
     * Get current url.
     *
     * @return string
     */
    public static function current()
    {
        if (defined('PHPUNIT_RUNNING')) {
            return 'http://localhost';
        }

        $protocol = 'http://';

        if (!empty($_SERVER['http'])
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'http' === $_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            $protocol = 'http://';
        }

        return $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
}
