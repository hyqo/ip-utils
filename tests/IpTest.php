<?php

namespace Hyqo\Utils\Ip\Test;

use Hyqo\Utils\Ip\Ip;
use PHPUnit\Framework\TestCase;

class IpTest extends TestCase
{
    public function test_is_valid(): void
    {
        $this->assertTrue(Ip::isValid('192.168.1.0'));
        $this->assertTrue(Ip::isValid('0:0:0:0:0:0:0:1'));
    }

    public function test_version(): void
    {
        $this->assertEquals(4, Ip::version('192.168.1.0/31'));
        $this->assertEquals(6, Ip::version('0:0:0:0:0:0:0:1'));
    }

    public function test_is_match(): void
    {
        $this->assertTrue(Ip::isMatch('192.168.1.0', '192.168.1.0/31'));
        $this->assertFalse(Ip::isMatch('192.168.1.0', '::1'));

        $this->assertTrue(Ip::isMatch('0:0:0:0:0:0:0:1', '::1/64'));
        $this->assertFalse(Ip::isMatch('0:0:0:0:0:0:0:1', '192.168.1.0/31'));

        $this->assertTrue(Ip::isMatch('131.0.72.199', ['131.0.72.0/22', '192.168.1.0/31']));
        $this->assertFalse(Ip::isMatch('132.0.72.199', ['131.0.72.0/22', '192.168.1.0/31']));

        $this->assertTrue(Ip::isMatch('2a01:198:603:0:396e:4789:8e99:890f', ['2a01:198:603:0::/0', '192.168.1.0/31']));
        $this->assertFalse(Ip::isMatch('2a01:198:603:0:396e:4789:8e99:890f', ['1a01:198:603:0::/65', '::1']));
    }

    public function test_normalize(): void
    {
        $this->assertEquals('127.0.0.1', Ip::normalize('127.0.0.1:80'));
        $this->assertEquals('::1', Ip::normalize('[::1]:80'));
    }

    public function test_port(): void
    {
        $this->assertNull(Ip::port('127.0.0.1'));
        $this->assertEquals(80, Ip::port('127.0.0.1:80'));

        $this->assertNull(Ip::port('::1'));
        $this->assertEquals(443, Ip::port('[::1]:443'));
    }
}
