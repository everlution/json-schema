<?php

namespace Everlution\JsonSchema\Validator;

use Throwable;

class ValidatorException extends \Exception
{
    private $json;

    private $errors;

    public function __construct(string $json, array $errors, int $code = 0, Throwable $previous = null)
    {
        $message = 'AWS Firehose Record Validation error ' . json_encode($errors);

        parent::__construct($message, $code, $previous);

        $this->json = $json;
        $this->errors = $errors;
    }

    public function getJson(): string
    {
        return $this->json;
    }

    public function getErrors(): array
    {
        $final = [];

        foreach ($this->errors as $error) {
            $e = [];
            foreach ($error as $key => $value) {
                if (in_array($key, ['property', 'message', 'constraint'])) {
                    $e[$key] = $value;
                }
            }

            $final[] = $e;
        }

        return $final;
    }
}
