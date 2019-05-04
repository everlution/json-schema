<?php

namespace Everlution\JsonSchema;

abstract class AbstractJsonSchema implements JsonSchemaInterface
{
    protected function makeAllPropertiesRequiredRecursive(array &$array): void
    {
        foreach ($array as $k => &$v) {
            if (!is_array($v)) {
                continue;
            }

            if ($k == 'properties') {
                $array['required'] = array_keys($v);
            }

            $this->makeAllPropertiesRequiredRecursive($v);
        }
    }

    protected function makeAllPropertiesRequired(array &$array): void
    {
        foreach ($array as $k => &$v) {
            if (!is_array($v)) {
                continue;
            }

            if ($k == 'properties') {
                $array['required'] = array_keys($v);
            }
        }
    }

    protected function addAdditionalPropertiesFalseRecursive(array &$array): void
    {
        foreach ($array as $k => &$v) {
            if (!is_array($v)) {
                continue;
            }

            if ($k == 'properties') {
                $array['additionalProperties'] = false;
            }

            $this->addAdditionalPropertiesFalseRecursive($v);
        }
    }

    protected function addAdditionalPropertiesFalse(array &$array): void
    {
        foreach ($array as $k => &$v) {
            if (!is_array($v)) {
                continue;
            }

            if ($k == 'properties') {
                $array['additionalProperties'] = false;
            }
        }
    }

    public function generate(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function getTypeString(
        ?bool $nullable = false,
        ?int $minLength = null,
        ?int $maxLength = null,
        ?string $pattern = null,
        ?string $format = null
    ): array {
        $data = [
            'type' => 'string',
        ];

        if ($nullable) {
            $data['type'] = [
                'string',
                'null',
            ];
        }

        if ($minLength) {
            $data['minLength'] = $minLength;
        }

        if ($maxLength) {
            $data['maxLength'] = $maxLength;
        }

        if ($pattern) {
            $data['pattern'] = $pattern;
        }

        if ($format) {
            $data['format'] = $format;
        }

        return $data;
    }

    public function getTypeBoolean(bool $nullable = false): array
    {
        if ($nullable) {
            $type = ['boolean', 'null'];
        } else {
            $type = 'boolean';
        }

        return [
            'type' => $type,
        ];
    }

    public function getTypeInteger(bool $nullable = false): array
    {
        if ($nullable) {
            $data = ['type' => ['integer', 'null']];
        } else {
            $data = ['type' => 'integer'];
        }

        return $data;
    }

    public function getTypeNumber(bool $nullable = false): array
    {
        if ($nullable) {
            $data = ['type' => ['number', 'null']];
        } else {
            $data = ['type' => 'number'];
        }

        return $data;
    }
}
