# ip-utils

![Packagist Version](https://img.shields.io/packagist/v/hyqo/ip-utils?style=flat-square)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/hyqo/ip-utils?style=flat-square)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/hyqo/ip-utils/tests.yml?branch=main&label=tests&style=flat-square)

## Install

```sh
composer require hyqo/ip-utils
```
## Methods
```php
IpInterface::isValid(string $ip): bool;
IpInterface::isMatch(string $ip, string|array $subnets): bool;
IpInterface::normalize(string $ip): string;
IpInterface::port(string $ip): ?int;
```

## Usage

```php
use Hyqo\Utils\Ip\Ip;

Ip::isValid('192.168.1.0'); //true
Ip::isValid('0:0:0:0:0:0:0:1'); //true

Ip::isMatch('131.0.72.199', '131.0.72.0/22'); //true
Ip::isMatch('131.0.76.199', '131.0.72.0/22'); //false

Ip::isMatch('132.0.72.199', ['131.0.72.0/22', '192.168.1.0/31']); //true

Ip::normalize('127.0.0.1:80'); //127.0.0.1
Ip::normalize('[::1]:80'); //::1

Ip::port('127.0.0.1:80'); //80
Ip::port('[::1]:80'); //80
```

The `Ip` class automatically detects IP version, but you can use `Ipv4` and `Ipv6` classes with the same methods as well.
