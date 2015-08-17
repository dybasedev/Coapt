<?php
/**
 * FastResolver.php
 *
 * Created by Chongyi
 * Date & Time 2015/7/30 20:10
 */

namespace Dybasedev\Coapt;

use Dybasedev\Coapt\Interfaces\Resolver;

class FastResolver implements Resolver
{
    public function resolve($origin)
    {
        $result = $this->structureResolve($origin);

        return $result;
    }

    public function structureResolve($data)
    {
        $result = preg_replace_callback(
            "/(?<!@){(\\w+)\\s*(\\((.*?)\\))?}/u",
            function ($matches) {
                $structure = strtolower($matches[1]);

                if (in_array($matches[1], ['else', 'default'])) {
                    return "<?php {$matches[1]}: ?>";
                } elseif (in_array($matches[1],
                    ['endif', 'endwhile', 'endswitch', 'endwhile', 'endfor', 'endforeach', 'break'])) {
                    return "<?php {$matches[1]}; ?>";
                }

                $structure = ucfirst($structure);

                $method = "structure{$structure}Resolve";

                if (method_exists($this, $method)) {
                    return call_user_func([$this, $method], $matches);
                }

                return '';
            },
            $data
        );

        return $result;
    }

    protected function structureIfResolve($expression)
    {
        return "<?php if({$expression[3]}): ?>";
    }
}