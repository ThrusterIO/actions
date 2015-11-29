<?php

namespace Thruster\Component\Actions\Action;

use Thruster\Component\Actions\ActionInterface;
use Thruster\Component\Actions\ExecutorInterface;

/**
 * Class BaseAction
 *
 * @package Thruster\Component\Actions\Action
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
abstract class BaseAction implements ActionInterface
{
    /**
     * @var array
     */
    protected $arguments;

    public function __construct()
    {
        $this->arguments = func_get_args();
    }

    /**
     * @inheritdoc
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     *
     * @return $this
     */
    public function setArguments(array $arguments) : self
    {
        $this->arguments = $arguments;

        return $this;
    }

    public function parseArguments(ExecutorInterface $executor) : array
    {
        $result = [];

        foreach ($this->getArguments() as $argument) {
            if ($argument instanceof ActionInterface) {
                $result[] = $executor->execute($argument);
            } elseif (is_callable($argument)) {
                $result[] = call_user_func($argument);
            } else {
                $result[] = $argument;
            }
        }

        return $result;
    }
}
