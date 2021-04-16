<?php

/**
 * This file contains the PushHttpSendTest class.
 *
 * @package ApnsPHP
 * @author  Martijn van Berkum <m.vanberkum@m2mobi.com>
 */

namespace ApnsPHP\Push\Tests;

/**
 * This class contains tests for the httpSend function
 *
 * @covers \ApnsPHP\Push\Server
 */
class ServerRunTest extends ServerTest
{

    /**
     * Test that run() returns false when the server is not running
     *
     * @covers \ApnsPHP\Push\Server::run
     */
    public function testRunReturnsFalseWhenServerIsNotRunning()
    {
        $this->mock_function('pcntl_signal_dispatch', function () {
            return false;
        });

        $this->set_reflection_property_value('runningProcesses', 0);

        $result = $this->class->run();

        $this->assertFalse($result);

        $this->unmock_function('pcntl_signal_dispatch');
    }

    /**
     * Test that run() returns true when the server is running
     *
     * @covers \ApnsPHP\Push\Server::run
     */
    public function testRunReturnstrueWhenServerIsRunning()
    {
        $this->mock_function('pcntl_signal_dispatch', function () {
            return true;
        });

        $this->set_reflection_property_value('runningProcesses', 1);

        $result = $this->class->run();

        $this->assertTrue($result);

        $this->unmock_function('pcntl_signal_dispatch');
    }
}
