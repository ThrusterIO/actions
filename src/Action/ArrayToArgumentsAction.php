<?php

namespace Thruster\Component\Actions\Action;

use Thruster\Component\Actions\ExecutorInterface;
use Thruster\Component\Actions\ExecutorLessInterface;

/**
 * Class ArrayToArgumentsAction
 *
 * @package Thruster\Component\Actions\Action
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ArrayToArgumentsAction extends BaseAction implements ExecutorLessInterface
{
    public function parseArguments(ExecutorInterface $executor) : array
    {
        $result = [];

        foreach (parent::parseArguments($executor) as $argument) {
            if (is_array($argument)) {
                $result = array_merge($result, $argument);
            } else {
                $result[] = $argument;
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return 'thruster_array_to_arguments';
    }

}
