<?php

/**
 * This file contains the ServerStartTest class.
 *
 * @package ApnsPHP
 * @author  Martijn van Berkum <m.vanberkum@m2mobi.com>
 */

namespace ApnsPHP\Push\Tests;

use ApnsPHP\SharedConfig;

/**
 * This class contains tests for the start function
 *
 * @covers \ApnsPHP\Push\Server
 */
class ServerStartTest extends ServerTest
{

    /**
     * Test that start() does nothing when the process cannot be forked
     *
     * @covers \ApnsPHP\Push\Server::start
     */
    public function testStartDoesNothingWhenProcessCannotBeForked()
    {
        $this->mock_function('pcntl_fork', function () {
            return -1;
        });

        $this->class->expects($this->exactly(3))
                    ->method('logger')
                    ->will($this->returnValue($this->logger));

        $this->logger->expects($this->exactly(3))
                     ->method('warning')
                     ->with('Could not fork');

        $this->class->start();

        $this->unmock_function('pcntl_fork');
    }

    /**
     * Test that start() starts a parent process
     *
     * @covers \ApnsPHP\Push\Server::start
     */
    public function testStartStartsParentProcess()
    {
        $this->mock_function('pcntl_fork', function () {
            return 1;
        });

        $this->class->setProcesses(1);

        $this->class->expects($this->once())
                    ->method('logger')
                    ->will($this->returnValue($this->logger));

        $this->logger->expects($this->once())
                     ->method('info')
                     ->with('Forked process PID 1');

        $this->class->start();

        $runningProcesses = $this->get_accessible_reflection_property('runningProcesses')->getValue($this->class);

        $this->assertEquals(1, $runningProcesses);

        $this->unmock_function('pcntl_fork');
    }

    /**
     * Test that start() starts a child process
     *
     * @covers \ApnsPHP\Push\Server::start
     */
//    public function testStartStartsChildProcess()
//    {
//        $this->mock_function('pcntl_fork', function () {
//            return 0;
//        });
//
//        $this->class->setProcesses(1);
//
////        $this->class->expects($this->once())
////                    ->method('connect')
////                    ->will($this->returnValue(null));
//
//        $this->class->expects($this->once())
//                    ->method('mainLoop')
//                    ->will($this->returnValue(null));
//
////        $this->class->expects($this->once())
////                    ->method('disconnect')
////                    ->will($this->returnValue(null));
//
//        $this->class->start();
//
//        $this->unmock_function('pcntl_fork');
//    }
}
