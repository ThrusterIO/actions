<?php

namespace Thruster\Component\Actions;

use Thruster\Component\Actions\Exception\ActionExecutorNotFoundException;

/**
 * Interface ExecutorInterface
 *
 * @package Thruster\Component\Actions
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface ExecutorInterface
{
    /**
     * @param string                  $actionName
     * @param ActionExecutorInterface $executor
     *
     * @return $this
     */
    public function addExecutor(string $actionName, ActionExecutorInterface $executor);

    /**
     * @param string $actionName
     *
     * @return ActionExecutorInterface
     */
    public function getExecutor(string $actionName) : ActionExecutorInterface;

    /**
     * @param ActionInterface $action
     *
     * @return array
     */
    public function execute(ActionInterface $action);
}
