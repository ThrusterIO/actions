<?php

namespace Thruster\Component\Actions\Action;

use Thruster\Component\Actions\ExecutorInterface;
use Thruster\Component\Actions\ExecutorLessInterface;

/**
 * Class OnExceptionRetryAction
 *
 * @package Thruster\Component\Actions\Action
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class OnExceptionRetryAction extends BaseAction implements ExecutorLessInterface
{
    /**
     * @var array
     */
    protected $exceptions;

    /**
     * @var int
     */
    protected $retries;

    /**
     * @var callable
     */
    protected $beforeRetry;

    /**
     * @param               $action
     * @param array         $exceptions
     * @param int           $retries
     * @param callable $beforeRetry
     */
    public function __construct($action, array $exceptions, int $retries = 3, callable $beforeRetry = null)
    {
        $this->exceptions = $exceptions;
        $this->retries = $retries;
        $this->beforeRetry = $beforeRetry;

        parent::__construct($action);
    }

    public function parseArguments(ExecutorInterface $executor) : array
    {
        $result = [];

        for ($i = $this->retries; $i >= 0; $i--) {
            try {
                $result = parent::parseArguments($executor);
            } catch (\Throwable $thr) {
                if (in_array(get_class($thr), $this->exceptions)) {
                    if ($i > 0) {
                        call_user_func($this->beforeRetry, $thr);

                        continue;
                    }
                }

                throw new $thr;
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return 'thruster_on_exception_retry';
    }

}
