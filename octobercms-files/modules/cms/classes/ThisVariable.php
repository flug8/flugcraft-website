<?php namespace Cms\Classes;

use October\Rain\Element\ElementBase;

/**
 * ThisVariable for the controller
 *
 * @package october\cms
 * @author Alexey Bobkov, Samuel Georges
 */
class ThisVariable extends ElementBase
{
    /**
     * get an attribute from the element instance, with closure support
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->config)) {
            return value($this->config[$key]);
        }

        return value($default);
    }
}
