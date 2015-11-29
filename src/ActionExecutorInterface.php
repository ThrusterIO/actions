<?php

namespace Thruster\Component\Actions;

/**
 * Interface ActionExecutorInterface
 *
 * @package Thruster\Component\Actions
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface ActionExecutorInterface
{
    /**
     * @return string
     */
    public static function getSupportedAction() : string;

    /**
     * @param array $arguments
     *
     * @return mixed
     */
    public function execute(array $arguments);
}
