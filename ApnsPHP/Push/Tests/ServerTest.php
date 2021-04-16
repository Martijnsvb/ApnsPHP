<?php

/**
 * This file contains the ServerTest class.
 *
 * @package ApnsPHP
 * @author  Martijn van Berkum <m.vanberkum@m2mobi.com>
 */

namespace ApnsPHP\Push\Tests;

use ApnsPHP\Push\Server;
use ApnsPHP\SharedConfig;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Server class.
 *
 * @covers \ApnsPHP\SharedConfig
 */
abstract class ServerTest extends LunrBaseTest
{

    /**
     * Mock instance of the EmbeddedLogger class.
     * @var \ApnsPHP\Log\EmbeddedLogger
     */
    protected $logger;

    /**
     * Mock instance of the Message class.
     * @var \ApnsPHP\Message
     */
    protected $message;

    protected $sharedConfig;

    /**
     * TestCase constructor
     */
    public function setUp(): void
    {
        $constructorArgs = [
            SharedConfig::ENVIRONMENT_SANDBOX,
            'ApnsPHP/Tests/SharedConfigTest.php'
        ];

        $this->logger = $this->getMockBuilder('ApnsPHP\Log\EmbeddedLogger')->getMock();

        $this->message = $this->getMockBuilder('ApnsPHP\Message')
                              ->disableOriginalConstructor()
                              ->getMock();

        $constructorArgs = [
            SharedConfig::ENVIRONMENT_SANDBOX,
            'ApnsPHP/Tests/SharedConfigTest.php',
            SharedConfig::PROTOCOL_HTTP
        ];
//        $this->sharedConfig = $this->getMockBuilder('ApnsPHP\SharedConfig')
//            ->setConstructorArgs($constructorArgs)
//            ->onlyMethods([ 'connect', 'mainLoop', 'disconnect' ])
//            ->getMockForAbstractClass();

        $this->class = $this->getMockBuilder('ApnsPHP\Push\Server')
                            ->disableOriginalConstructor()
                            ->setConstructorArgs($constructorArgs)
                            ->onlyMethods([ 'logger', 'connect', 'mainLoop', 'disconnect' ])
                            ->getMock();

        $this->reflection = new ReflectionClass('ApnsPHP\Push\Server');
    }

    /**
     * TestCase destructor
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
    }
}
