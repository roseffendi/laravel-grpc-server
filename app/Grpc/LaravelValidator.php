<?php

namespace App\Grpc;

use Spiral\GRPC\StatusCode;
use App\Grpc\Contracts\Validator;
use Spiral\GRPC\Exception\ServiceException;
use Google\Rpc\BadRequest\FieldViolation;
use Illuminate\Contracts\Validation\Factory;

class LaravelValidator implements Validator
{
    /**
     * Validator factory
     * 
     * @param   \Illuminate\Contracts\Validation\Factory
     */
    protected $validatorFactory;

    /**
     * Create new instance/
     * 
     * @param   \Illuminate\Contracts\Validation\Factory    $validatorFactory
     */
    public function __construct(Factory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Validate data.
     * 
     * @param   array   $data
     * @param   array   $rules
     * 
     * @return  void
     * 
     * @throws  \Throwable
     */
    public function validate(array $data, array $rules): void
    {
        $data = $this->adjustData($data);
        $validator = $this->validatorFactory->make($data, $rules);

        if($validator->fails()) {
            $grpcErrors = [];
            $errors = $validator->errors()->getMessages();

            foreach($errors as $field => $error) {
                $grpcError = new FieldViolation;

                $grpcError->setField($field);
                $grpcError->setDescription($error[0]);

                $grpcErrors[] = $grpcError;
            }

            throw new ServiceException("The given data was invalid.", StatusCode::INVALID_ARGUMENT, $grpcErrors);
        }
    }

    /**
     * Adjust data
     * 
     * @param   array   $data
     * 
     * @return  array
     */
    protected function adjustData(array $data)
    {
        $adjusted = [];

        foreach($data as $key => $item) {
            $adjustedKey = \Str::snake($key);

            $adjusted[$adjustedKey] = $item;
        }

        return $adjusted;
    }
}