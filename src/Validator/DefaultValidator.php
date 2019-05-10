<?php

namespace Everlution\JsonSchema\Validator;

use Everlution\JsonSchema\JsonSchemaInterface;
use JsonSchema\Validator;

class DefaultValidator implements ValidatorInterface
{
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param JsonSchemaInterface $jsonSchema
     * @param array $data
     * @throws ValidatorException
     */
    public function validate(JsonSchemaInterface $jsonSchema, array $data): void
    {
        $data = $this->arrayToObject($data);

        $this
            ->validator
            ->validate($data, $jsonSchema->toArray());

        if (!$this->validator->isValid()) {
            throw new ValidatorException(json_encode($data), $this->validator->getErrors());
        }
    }

    /**
     * This must be recursive, so the whole array and sub arrays must be stdClass
     *
     * @param $array
     * @return mixed
     */
    private function arrayToObject($array): object
    {
        if (count($array) == 0) {
            return new \stdClass();
        }

        // First we convert the array to a json string
        $json = json_encode($array);

        // The we convert the json string to a stdClass()
        $object = json_decode($json);

        return $object;
    }
}
