# Everlution JSON Schema (Definition and Validation)

A library for creating and validating JSON Schemas in PHP.

You won't need to write any JSON string.

## Installation

```
composer require everlution/json-schema
```

## JSON Schema definition

Rather than writing JSON Schema directly in JSON we create a new PHP class where we have helpers for writing less.

```php
<?php

namespace App\JsonSchema;

use Everlution\JsonSchema\AbstractJsonSchema;

class JwtTokensRequestJsonSchema extends AbstractJsonSchema
{
    public function toArray(): array
    {
        $data = [
            'title' => 'JWT Token Request',
            'description' => 'Get a new token',
            'type' => 'object',
            'properties' => [
                'key' => [
                    'type' => 'string',
                ],
                'secret' => [
                    'type' => 'string',
                ],
                // you can use helpers like this to reduce the amount of code to write and reduce mistakes
                // 'whateverString' => $this->getTypeString(?bool $nullable, ?int $minLength, ?int $maxLength, ?string $pattern, ?string $format)
            ],
        ];
        
        // on this level add "additionalProperties": false
        $this->addAdditionalPropertiesFalse($data);
        // same as above but recursively in every sub level
        $this->addAdditionalPropertiesFalseRecursive($data);
        
        // on this level add "required": [...] for all the defined properties
        $this->makeAllPropertiesRequired($data);
        // same as above but recursively in every sub level
        $this->makeAllPropertiesRequiredRecursive($data);
        
        return $data;
    }
}
```

We can then generate the actual JSON Schema with:

```php
use App\JsonSchema\JwtTokensRequestJsonSchema;

$jsonSchema = new JwtTokensRequestJsonSchema();

$jsonSchemaString = $jsonSchema->generate();
```

## JSON Schema Validation against data

The library provides the `Everlution\JsonSchema\Validator\ValidatorInterface` and an actual implementation of it with the `justinrainbow/json-schema` library.

You can add your own validator by implementing the interface.

```php
use App\JsonSchema\JwtTokensRequestJsonSchema;
use Everlution\JsonSchema\Validator\DefaultValidator;
use Everlution\JsonSchema\Validator\ValidatorException;
use JsonSchema\Validator as JustinrainbowJsonSchema;

$jsonSchema = new JwtTokensRequestJsonSchema();

$validator = new DefaultValidator(new JustinrainbowJsonSchema());

$data = [
    'key' => '123132',
    'secret' => '123213',
];

try {
    // validate() throws an exception only when the data cannot be validated against the JSON Schema
    $validator->validate($jsonSchema, $data);
} catch (ValidatorException $e) {
    var_dump($e->getErrors());
}

```