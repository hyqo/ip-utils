<?php

namespace Hyqo\Utils\Ip;

class Ipv4 implements IpInterface
{
    public static function isValid(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    public static function isMatch(string $ip, array|string $subnets): bool
    {
        foreach ((array)$subnets as $subnet) {
            if (self::doMatch($ip, $subnet)) {
                return true;
            }
        }

        return false;
    }

    protected static function doMatch(string $ip, string $subnet): bool
    {
        if ($subnet === '0.0.0.0/0') {
            return true;
        }

        if (!str_contains($subnet, '/')) {
            $address = $subnet;
            $netmask = -1;
        } else {
            [$address, $bits] = explode('/', $subnet, 2);
            $netmask = ~((1 << (32 - (int)$bits)) - 1);
        }

        $intIp = ip2long($ip);
        $intAddress = ip2long($address);

        if (!$intIp || !$intAddress) {
            return false;
        }

        return ($intIp & $netmask) === ($intAddress & $netmask);
    }

    public static function normalize(string $ip): string
    {
        if ($i = strpos($ip, ':')) {
            return substr($ip, 0, $i);
        }

        return $ip;
    }

    public static function port(string $ip): ?int
    {
        if ($i = strpos($ip, ':')) {
            return (int)substr($ip, $i + 1);
        }

        return null;
    }
}
