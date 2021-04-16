<?php

/**
 * This file contains the ServerOnSignalTest class.
 *
 * @package ApnsPHP
 * @author  Martijn van Berkum <m.vanberkum@m2mobi.com>
 */

namespace ApnsPHP\Push\Tests;

/**
 * This class contains tests for the onSignal function
 *
 * @covers \ApnsPHP\Push\Server
 */
class ServerOnSignalTest extends ServerTest
{

    /**
     * Test that onSignal() exits on signal type TERM (15)
     *
     * @covers \ApnsPHP\Push\Server::onSignal
     */
    public function testOnSignalExitsOnSignalTypeTerm()
    {
        $this->mock_function('posix_getpid', function () {
            return 1;
        });

        $this->set_reflection_property_value('runningProcesses', 1);

        $this->class->expects($this->once())
                    ->method('logger')
                    ->will($this->returnValue($this->logger));

        $this->logger->expects($this->once())
                     ->method('info')
                     ->with('Child 1 received signal #15, shutdown...');

        $this->class->onSignal(15);

        $runningProcesses = $this->get_accessible_reflection_property('runningProcesses')->getValue($this->class);

        $this->assertEquals(0, $runningProcesses);

        $this->unmock_function('posix_getpid');
    }

    /**
     * Test that onSignal() exits on signal type QUIT (3)
     *
     * @covers \ApnsPHP\Push\Server::onSignal
     */
    public function testOnSignalExitsOnSignalTypeQuit()
    {
        $this->mock_function('posix_getpid', function () {
            return 1;
        });

        $this->set_reflection_property_value('runningProcesses', 1);

        $this->class->expects($this->once())
                    ->method('logger')
                    ->will($this->returnValue($this->logger));

        $this->logger->expects($this->once())
                     ->method('info')
                     ->with('Child 1 received signal #3, shutdown...');

        $this->class->onSignal(3);

        $runningProcesses = $this->get_accessible_reflection_property('runningProcesses')->getValue($this->class);

        $this->assertEquals(0, $runningProcesses);

        $this->unmock_function('posix_getpid');
    }

    /**
     * Test that onSignal() exits on signal type INT (2)
     *
     * @covers \ApnsPHP\Push\Server::onSignal
     */
    public function testOnSignalExitsOnSignalTypeInt()
    {
        $this->mock_function('posix_getpid', function () {
            return 1;
        });

        $this->set_reflection_property_value('runningProcesses', 1);

        $this->class->expects($this->once())
                    ->method('logger')
                    ->will($this->returnValue($this->logger));

        $this->logger->expects($this->once())
                     ->method('info')
                     ->with('Child 1 received signal #2, shutdown...');

        $this->class->onSignal(2);

        $runningProcesses = $this->get_accessible_reflection_property('runningProcesses')->getValue($this->class);

        $this->assertEquals(0, $runningProcesses);

        $this->unmock_function('posix_getpid');
    }

    /**
     * Test that onSignal() does nothing when it gets called with an invalid signal
     *
     * @covers \ApnsPHP\Push\Server::onSignal
     */
    public function testOnSignalDoesNothingOnInvalidSignal()
    {
        $this->class->expects($this->once())
                    ->method('logger')
                    ->will($this->returnValue($this->logger));

        $this->logger->expects($this->once())
                     ->method('info')
                     ->with('Ignored signal #1.');

        $this->class->onSignal(1);
    }
}
