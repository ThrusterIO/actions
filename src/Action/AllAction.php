<?php

namespace Thruster\Component\Actions\Action;

use Thruster\Component\Actions\ExecutorLessInterface;

/**
 * Class AllAction
 *
 * @package Thruster\Component\Actions\Action
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class AllAction extends BaseAction implements ExecutorLessInterface
{
    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return 'thruster_all';
    }
}
