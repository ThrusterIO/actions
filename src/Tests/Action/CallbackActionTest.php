<?php

namespace Thruster\Component\Actions\Tests\Action;

use Thruster\Component\Actions\Action\AllAction;
use Thruster\Component\Actions\Action\CallbackAction;
use Thruster\Component\Actions\Action\PipelineAction;
use Thruster\Component\Actions\Executor;

class CallbackActionTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $action = new CallbackAction(function () {});

        $this->assertSame('thruster_callback', $action->getName());
    }

    public function testAction()
    {
        $action = new CallbackAction(
            function ($input) {
                return $input * 2;
            },
            2
        );

        $executor = $this->getMock('\Thruster\Component\Actions\ExecutorInterface');

        $this->assertEquals(
            4,
            $action->parseArguments($executor)
        );
    }

    public function testPipeline()
    {
        $pipeline = new PipelineAction(
            2,
            new CallbackAction(
                function ($input) {
                    return $input * 2;
                }
            ),
            new CallbackAction(
                function ($input) {
                    return $input * 2;
                }
            )
        );

        $executor = new Executor();
        $this->assertEquals(8, $executor->execute($pipeline));
    }

    public function testAll()
    {
        $pipeline = new AllAction(
            2,
            new CallbackAction(
                function ($input) {
                    return $input * 2;
                },
                2
            ),
            new CallbackAction(
                function ($input) {
                    return $input * 2;
                },
                3
            )
        );

        $executor = new Executor();
        $this->assertEquals([2,4,6], $executor->execute($pipeline));
    }
}
