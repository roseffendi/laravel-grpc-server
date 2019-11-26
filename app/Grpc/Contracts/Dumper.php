<?php

namespace App\Grpc\Contracts;

interface Dumper
{
    /**
     * Dump given value.
     * 
     * @param   mixed   $value
     * 
     * @return  void|null
     */
    public function dump($value);
}