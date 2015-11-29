<?php

namespace Thruster\Component\Actions\Action;

use Thruster\Component\Actions\ExecutorInterface;
use Thruster\Component\Actions\ExecutorLessInterface;

/**
 * Class CallbackAction
 *
 * @package Thruster\Component\Actions\Action
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class CallbackAction extends BaseAction implements ExecutorLessInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
        $this->arguments = array_slice(func_get_args(), 1);
    }

    /**
     * @param ExecutorInterface $executor
     *
     * @return mixed
     */
    public function parseArguments(ExecutorInterface $executor)
    {
        return call_user_func_array($this->callback, parent::parseArguments($executor));
    }

    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return 'thruster_callback';
    }

}
