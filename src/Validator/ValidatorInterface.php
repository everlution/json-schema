<?php

namespace Everlution\JsonSchema\Validator;

use Everlution\JsonSchema\JsonSchemaInterface;

interface ValidatorInterface
{
    public function validate(JsonSchemaInterface $jsonSchema, array $data): void;
}
