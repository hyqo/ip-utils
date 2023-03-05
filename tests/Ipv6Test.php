<?php

namespace Hyqo\Utils\Ip\Test;

use Hyqo\Utils\Ip\Ipv6;
use PHPUnit\Framework\TestCase;

class Ipv6Test extends TestCase
{

    public function test_is_valid(): void
    {
        $this->assertTrue(Ipv6::isValid('::1'));
        $this->assertFalse(Ipv6::isValid(':1'));
        $this->assertFalse(Ipv6::isValid('fake'));
    }

    public function test_is_match(): void
    {
        $this->assertTrue(Ipv6::isMatch('2a01:198:603:0:396e:4789:8e99:890f', '::0/0'));

        $this->assertFalse(Ipv6::isMatch('0:0:0:0:0:0:0:1', '192.168.1.0/31'));

        $this->assertTrue(Ipv6::isMatch('0:0:0:0:0:0:0:1', '::1'));
        $this->assertFalse(Ipv6::isMatch('0:0:603:0:396e:4789:8e99:0001', '::1'));

        $this->assertTrue(Ipv6::isMatch('2a01:198:603:0:396e:4789:8e99:890f', '2a01:198:603:0::/0'));
        $this->assertTrue(Ipv6::isMatch('0:0:603:0:396e:4789:8e99:0001', '::1/0'));
        $this->assertFalse(Ipv6::isMatch('0:0:603:0:396e:4789:8e99:0001', '::1'));

        $this->assertFalse(Ipv6::isMatch('0:0:603:0:396e:4789:8e99:0001', 'fake'));
        $this->assertFalse(Ipv6::isMatch('}{}', '::1'));
        $this->assertFalse(Ipv6::isMatch('', '::1'));

        $this->assertTrue(Ipv6::isMatch('2a01:198:603:0:396e:4789:8e99:890f', ['2a01:198:603:0::/0', '192.168.1.0/31']));
        $this->assertFalse(Ipv6::isMatch('2a01:198:603:0:396e:4789:8e99:890f', ['1a01:198:603:0::/65', '::1']));

        $this->assertFalse(Ipv6::isMatch('2a01:198:603:0:396e:4789:8e99:890f', ['1a01:198:603:0::/12345', '::1']));
    }

    public function test_normalize(): void
    {
        $this->assertEquals('::1', Ipv6::normalize('[::1]:80'));
        $this->assertEquals('::1', Ipv6::normalize('::1'));
        $this->assertEquals('fake', Ipv6::normalize('fake'));
    }
}
