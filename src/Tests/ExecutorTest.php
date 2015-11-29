<?php

namespace Thruster\Component\Actions\Tests;

use Thruster\Component\Actions\Action\AllAction;
use Thruster\Component\Actions\Action\ArrayToArgumentsAction;
use Thruster\Component\Actions\Action\CallbackAction;
use Thruster\Component\Actions\Action\PipelineAction;
use Thruster\Component\Actions\ActionExecutorInterface;
use Thruster\Component\Actions\Executor;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddExecutor()
    {
        $actionExecutor = new class implements ActionExecutorInterface
        {
            /**
             * @inheritDoc
             */
            public static function getSupportedAction() : string
            {
                return 'foo_bar';
            }

            /**
             * @inheritDoc
             */
            public function execute(array $arguments)
            {
            }
        };

        $executor = new Executor();
        $executor->addExecutor($actionExecutor->getSupportedAction(), $actionExecutor);

        $this->assertEquals($actionExecutor, $executor->getExecutor('foo_bar'));
    }

    /**
     * @expectedException \Thruster\Component\Actions\Exception\ActionExecutorNotFoundException
     * @expectedExceptionMessage Action executor "foo_bar" not found
     */
    public function testNotExistingActionExecutor()
    {
        $executor = new Executor();
        $executor->getExecutor('foo_bar');
    }

    public function testExecute()
    {
        $expected = [1, 2, 3];

        $actionExecutor = new class implements ActionExecutorInterface
        {
            /**
             * @inheritDoc
             */
            public static function getSupportedAction() : string
            {
                return 'foo_bar';
            }

            /**
             * @inheritDoc
             */
            public function execute(array $arguments)
            {
                return array_reverse($arguments);
            }
        };

        $executor = new Executor();
        $executor->addExecutor($actionExecutor->getSupportedAction(), $actionExecutor);

        $actionMock = $this->getMockForAbstractClass('\Thruster\Component\Actions\ActionInterface');

        $actionMock->expects($this->once())
                   ->method('parseArguments')
                   ->with($executor)
                   ->willReturn(array_reverse($expected));

        $actionMock->expects($this->once())
                   ->method('getName')
                   ->willReturn('foo_bar');

        $this->assertEquals($expected, $executor->execute($actionMock));
    }

    public function testExecuteExecutorLess()
    {
        $expected = [1, 2, 3];

        $executor = new Executor();

        $actionMock = $this->getMockForAbstractClass('\Thruster\Component\Actions\ExecutorLessInterface');

        $actionMock->expects($this->once())
                   ->method('parseArguments')
                   ->with($executor)
                   ->willReturn($expected);

        $this->assertEquals($expected, $executor->execute($actionMock));
    }

    public function testHardActions()
    {
        $action = new AllAction(
            new CallbackAction(
                function ($result) {
                    return $result * $result;
                },
                new PipelineAction(
                    new ArrayToArgumentsAction(
                        function () {
                            return [1, 2, 3, 4];
                        }
                    ),
                    new CallbackAction(
                        function (array $input) {
                            return array_sum($input);
                        }
                    )
                )
            )
        );

        $executor = new Executor();
        $this->assertSame([100], $executor->execute($action));
    }
}
