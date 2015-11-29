<?php

namespace Thruster\Component\Actions\Tests\Action;

use Thruster\Component\Actions\Action\ArrayToArgumentsAction;

class ArrayToArgumentsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $action = new ArrayToArgumentsAction();

        $this->assertSame('thruster_array_to_arguments', $action->getName());
    }

    public function testAction()
    {
        $action = new ArrayToArgumentsAction(
            [
                1,
                2,
                3,
                [
                    4,
                    5,
                    6
                ]
            ],
            7,
            8
        );

        $executor = $this->getMock('\Thruster\Component\Actions\ExecutorInterface');

        $this->assertEquals(
            [1, 2, 3, [4, 5, 6], 7, 8],
            $action->parseArguments($executor)
        );
    }
}
