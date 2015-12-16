<?php

namespace Thruster\Component\Actions\Tests\Action;

use Thruster\Component\Actions\Action\OnExceptionRetryAction;
use Thruster\Component\Actions\Executor;

/**
 * Class OnExceptionRetryActionTest
 *
 * @package Thruster\Component\Actions\Tests\Action
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class OnExceptionRetryActionTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $action = new OnExceptionRetryAction(null, ['foo']);

        $this->assertSame('thruster_on_exception_retry', $action->getName());
    }

    public function testAction()
    {
        $count = 0;
        $number = 0;

        $callback = function ($thr) use (&$count, &$number) {
            $this->assertInstanceOf('InvalidArgumentException', $thr);
            $count++;
            $number++;
        };

        $action = new OnExceptionRetryAction(
            function () use (&$number) {
                $number--;
                throw new \InvalidArgumentException;
            },
            ['InvalidArgumentException'],
            3,
            $callback
        );

        $executor = new Executor();
        try {
            $executor->execute($action);
        } catch (\InvalidArgumentException $e) {
        }

        $this->assertSame(3, $count);
        $this->assertSame(-1, $number);
    }
    public function testActionNormal()
    {
        $count = 0;

        $callback = function ($thr) use (&$count) {
            $this->assertInstanceOf('InvalidArgumentException', $thr);
            $count++;
        };

        $action = new OnExceptionRetryAction(
            function () use (&$count) {
                if ($count < 2) {
                    throw new \InvalidArgumentException;
                }

                return 'foo';
            },
            ['InvalidArgumentException'],
            3,
            $callback
        );

        $executor = new Executor();
        $this->assertEquals(['foo'], $executor->execute($action));

        $this->assertSame(2, $count);
    }
}
