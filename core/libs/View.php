<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-13
 * Time: 09:32
 */

namespace core\libs;

class View
{
    public static function display($template, $data = [], $cache = false)
    {
        $filename = sprintf('%s/%s/%s.php', APP_PATH, config::item('viewDir'), $template);

        if (is_file($filename)) {
            if ( ! empty($cache)) {
                ob_start();
            }

            if ( ! empty($data)) {
                extract($data);
            }

            include_once $filename;

            if ( ! empty($cache)) {
                $str = ob_get_contents();
                ob_end_clean();

                return $str;
            }
        }
    }
}