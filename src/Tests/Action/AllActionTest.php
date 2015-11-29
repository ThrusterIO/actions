<?php

namespace Thruster\Component\Actions\Tests\Action;

use Thruster\Component\Actions\Action\AllAction;
use Thruster\Component\Actions\Action\BaseAction;
use Thruster\Component\Actions\ExecutorLessInterface;

class AllActionTest extends \PHPUnit_Framework_TestCase
{

    public function testName()
    {
        $action = new AllAction();

        $this->assertSame('thruster_all', $action->getName());
    }

    public function testAction()
    {
        $mock = $this->getMock('stdClass', ['call']);
        $mock->expects($this->once())
            ->method('call')
            ->willReturn('call');

        $actionMock = new class('foo', 'bar') extends BaseAction implements ExecutorLessInterface {
            /**
             * @inheritDoc
             */
            public function getName() : string
            {
                return 'demo';
            }

        };

        $action = new AllAction(
            [$mock, 'call'],
            $actionMock,
            'dummy'
        );

        $executor = $this->getMock('\Thruster\Component\Actions\ExecutorInterface');

        $executor->expects($this->once())
            ->method('execute')
            ->with($actionMock)
            ->willReturn(['foo', 'bar']);

        $this->assertEquals(['call', ['foo', 'bar'], 'dummy'], $action->parseArguments($executor));
    }
}
