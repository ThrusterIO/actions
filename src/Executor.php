<?php

namespace Thruster\Component\Actions;

use function Funct\arrayKeyNotExists;
use Thruster\Component\Actions\Exception\ActionExecutorNotFoundException;

/**
 * Class Executor
 *
 * @package Thruster\Component\Actions
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class Executor implements ExecutorInterface
{
    /**
     * @var ActionExecutorInterface[]
     */
    protected $executors;

    public function __construct()
    {
        $this->executors = [];
    }

    /**
     * @inheritDoc
     */
    public function addExecutor(string $actionName, ActionExecutorInterface $executor) : self
    {
        $this->executors[$actionName] = $executor;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExecutor(string $actionName) : ActionExecutorInterface
    {
        if (arrayKeyNotExists($actionName, $this->executors)) {
            throw new ActionExecutorNotFoundException($actionName);
        }

        return $this->executors[$actionName];
    }

    /**
     * @inheritDoc
     */
    public function execute(ActionInterface $action)
    {
        if ($action instanceof ExecutorLessInterface) {
            return $action->parseArguments($this);
        } else {
            return $this->getExecutor($action->getName())->execute($action->parseArguments($this));
        }
    }
}
