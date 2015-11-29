<?php

namespace Thruster\Component\Actions\Tests\Action;

use Thruster\Component\Actions\Action\BaseAction;
use Thruster\Component\Actions\Action\PipelineAction;
use Thruster\Component\Actions\Executor;
use Thruster\Component\Actions\ExecutorLessInterface;

class PipelineActionTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $action = new PipelineAction();

        $this->assertSame('thruster_pipeline', $action->getName());
    }

    public function testAction()
    {
        $given = 1;
        $expected = 10;

        $mock = $this->getMock('stdClass', ['a', 'b', 'c']);
        $mock->expects($this->once())
            ->method('a')
            ->with($given)
            ->willReturn(2);

        $mock->expects($this->once())
            ->method('b')
            ->with(2)
            ->willReturn(5);

        $mock->expects($this->once())
            ->method('c')
            ->with(5)
            ->willReturn($expected);

        $action = new PipelineAction(
            $given,
            [$mock, 'a'],
            [$mock, 'b'],
            [$mock, 'c']
        );

        $executor = $this->getMock('\Thruster\Component\Actions\ExecutorInterface');
        $this->assertSame($expected, $action->parseArguments($executor));
    }
    public function testActionWithActionArgument()
    {
        $given = 1;
        $expected = 10;

        $mock = $this->getMock('stdClass', ['a', 'b', 'c']);
        $mock->expects($this->once())
            ->method('a')
            ->with($given)
            ->willReturn(2);

        $mock->expects($this->once())
            ->method('b')
            ->with(2)
            ->willReturn(5);

        $mock->expects($this->once())
            ->method('c')
            ->with(5)
            ->willReturn($expected);

        $subAction = new class extends BaseAction implements ExecutorLessInterface {
                /**
                 * @inheritDoc
                 */
                public function getName() : string
                {
                    return 'demo';
                }

            };

        $action = new PipelineAction(
            $given,
            [$mock, 'a'],
            [$mock, 'b'],
            [$mock, 'c'],
            $subAction
        );

        $executor = $this->getMock('\Thruster\Component\Actions\ExecutorInterface');
        $executor->expects($this->once())
            ->method('execute')
            ->with($subAction)
            ->willReturn(20);

        $this->assertSame(20, $action->parseArguments($executor));
    }

    public function testRealExecution()
    {
        $action = new PipelineAction(
            10,
            function ($input) {
                return $input * 10;
            },
            function ($input) {
                return $input + 10;
            },
            function ($input) {
                return $input / 10;
            }
        );

        $executor = new Executor();

        $this->assertEquals(11, $executor->execute($action));
    }
}
