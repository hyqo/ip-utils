<?php

namespace Hyqo\Utils\Ip;

class Ip implements IpInterface
{
    public static function version(string $ip): int
    {
        return substr_count($ip, ':') > 1 ? 6 : 4;
    }

    public static function isValid(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    public static function isMatch(string $ip, array|string $subnets): bool
    {
        $version = self::version($ip);
        $subnets = array_filter((array)$subnets, static function (string $subnet) use ($version) {
            return $version === self::version($subnet);
        });

        /** @var IpInterface $class */
        $class = $version === 6 ? Ipv6::class : Ipv4::class;

        return $class::isMatch($ip, $subnets);
    }

    public static function normalize(string $ip): string
    {
        return self::callVersionMethod(__FUNCTION__, $ip);
    }

    public static function port(string $ip): ?int
    {
        return self::callVersionMethod(__FUNCTION__, $ip);
    }

    protected static function callVersionMethod(string $method, string $ip, ...$args)
    {
        $version = self::version($ip);

        /** @var IpInterface $class */
        $class = $version === 6 ? Ipv6::class : Ipv4::class;

        return $class::$method($ip, ...$args);
    }
}
