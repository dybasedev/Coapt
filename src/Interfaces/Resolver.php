<?php
/**
 * Resolver.php
 *
 * Created by Chongyi
 * Date & Time 2015/7/30 21:16
 */

namespace Dybasedev\Coapt\Interfaces;

interface Resolver
{
    /**
     * 模板数据
     *
     * @param string $origin
     *
     * @return string
     */
    public function resolve($origin);
}