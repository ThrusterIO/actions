<?php

namespace Thruster\Component\Actions\Action;

use Thruster\Component\Actions\ActionInterface;
use Thruster\Component\Actions\ExecutorInterface;
use Thruster\Component\Actions\ExecutorLessInterface;
use function Funct\null;

/**
 * Class PipelineAction
 *
 * @package Thruster\Component\Actions\Action
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class PipelineAction extends BaseAction implements ExecutorLessInterface
{
    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return 'thruster_pipeline';
    }

    public function parseArguments(ExecutorInterface $executor)
    {
        $first = true;
        $value = null;

        foreach ($this->getArguments() as $argument) {
            $arguments = null($value) ? [] : [$value];

            if ($argument instanceof ActionInterface) {
                if (false === $first) {
                    $argument->setArguments($arguments);
                }

                $value = $executor->execute($argument);
            } elseif (is_callable($argument)) {
                $value = call_user_func_array($argument, $arguments);
            } else {
                $value = $argument;
            }

            if (true === $first) {
                $first = false;
            }
        }

        return $value;
    }
}
