<?php

namespace Thruster\Component\Actions\Exception;

/**
 * Class ActionExecutorNotFoundException
 *
 * @package Thruster\Component\Actions\Exception
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ActionExecutorNotFoundException extends \Exception
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $message = sprintf(
            'Action executor "%s" not found',
            $name
        );

        parent::__construct($message);
    }
}
