<?php

namespace Hyqo\Utils\Ip;

interface IpInterface
{
    public static function isValid(string $ip): bool;

    public static function isMatch(string $ip, array|string $subnets): bool;

    public static function normalize(string $ip): string;

    public static function port(string $ip): ?int;
}
