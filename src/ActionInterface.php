<?php

namespace Thruster\Component\Actions;

/**
 * Interface ActionInterface
 *
 * @package Thruster\Component\Actions
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface ActionInterface
{
    /**
     * @return array
     */
    public function getArguments() : array;

    /**
     * @param array $arguments
     *
     * @return $this
     */
    public function setArguments(array $arguments);

    /**
     * @return array
     */
    public function parseArguments(ExecutorInterface $executor);

    /**
     * @return string
     */
    public function getName() : string;
}
