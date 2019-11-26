<?php

namespace App\Grpc\Contracts;

use Spiral\GRPC\ContextInterface;

interface ServiceWrapper
{
    /**
     * Retrive service name.
     * 
     * @return  string
     */
    public function getName(): string;

    /**
     * Retrieve public methods.
     * 
     * @return  array
     */
    public function getMethods(): array;

    /**
     * Invoke service.
     * 
     * @param string                        $method
     * @param \Spiral\GRPC\ContextInterface $context
     * @param string                        $input
     * 
     * @return string
     *
     * @throws \Spiral\GRPC\Exception\NotFoundException
     * @throws \Spiral\GRPC\Exception\InvokeException
     */
    public function invoke(string $method, ContextInterface $context, ?string $input): string;
}