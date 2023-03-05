<?php

namespace Hyqo\Utils\Ip\Test;

use Hyqo\Utils\Ip\Ipv4;
use PHPUnit\Framework\TestCase;

class Ipv4Test extends TestCase
{
    public function test_is_valid(): void
    {
        $this->assertTrue(Ipv4::isValid('127.0.0.1'));
        $this->assertFalse(Ipv4::isValid('127.0.0'));
        $this->assertFalse(Ipv4::isValid('fake'));
    }

    public function test_is_match(): void
    {
        $this->assertTrue(Ipv4::isMatch('192.168.1.1', '0.0.0.0/0'));

        $this->assertTrue(Ipv4::isMatch('192.168.1.1', '192.168.1.0/31'));
        $this->assertFalse(Ipv4::isMatch('192.168.1.2', '192.168.1.0/31'));

        $this->assertTrue(Ipv4::isMatch('192.168.1.3', '192.168.1.0/30'));
        $this->assertFalse(Ipv4::isMatch('192.168.1.4', '192.168.1.0/30'));

        $this->assertTrue(Ipv4::isMatch('192.168.1.100', '192.168.0.0/23'));
        $this->assertFalse(Ipv4::isMatch('192.168.2.100', '192.168.0.0/23'));

        $this->assertTrue(Ipv4::isMatch('131.0.72.199', '131.0.72.0/22'));
        $this->assertTrue(Ipv4::isMatch('131.0.73.199', '131.0.72.0/22'));
        $this->assertFalse(Ipv4::isMatch('131.0.76.199', '131.0.72.0/22'));

        $this->assertFalse(Ipv4::isMatch('131.0.76.199', 'fake'));
        $this->assertFalse(Ipv4::isMatch('}{}', 'fake'));

        $this->assertTrue(Ipv4::isMatch('131.0.72.199', ['131.0.72.0/22', '192.168.1.0/31']));
        $this->assertFalse(Ipv4::isMatch('132.0.72.199', ['131.0.72.0/22', '192.168.1.0/31']));
    }

    public function test_normalize(): void
    {
        $this->assertEquals('127.0.0.1', Ipv4::normalize('127.0.0.1:80'));
        $this->assertEquals('127.0.0.1', Ipv4::normalize('127.0.0.1'));
        $this->assertEquals('fake', Ipv4::normalize('fake'));
    }

}
