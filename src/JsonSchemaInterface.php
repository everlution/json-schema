<?php

namespace Everlution\JsonSchema;

interface JsonSchemaInterface
{
    const STRING_FORMAT_DATETIME = 'date-time';
    const STRING_FORMAT_EMAIL = 'email';
    const STRING_FORMAT_HOSTNAME = 'hostname';
    const STRING_FORMAT_IPV4 = 'ipv4';
    const STRING_FORMAT_IPV6 = 'ipv6';
    const STRING_FORMAT_URI = 'uri';

    public function toArray(): array;

    public function generate(): string;
}
