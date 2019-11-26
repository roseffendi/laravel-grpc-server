<?php

namespace App\Grpc;

use Spiral\Debug;
use App\Grpc\Contracts\Dumper;

class RoadrunnerDumper implements Dumper
{
    /**
     * Dumper instance.
     * 
     * @var \Spiral\Debug\Dumper
     */
    protected $dumper;

    /**
     * Create new instance.
     */
    public function __construct()
    {
        $this->dumper = new Debug\Dumper();
        $this->dumper->setRenderer(Debug\Dumper::ERROR_LOG, new Debug\Renderer\ConsoleRenderer());
    }

    /**
     * Dump given value.
     * 
     * @param   mixed   $value
     * 
     * @return  void|null
     */
    public function dump($value)
    {
        $this->dumper->dump($value, Debug\Dumper::ERROR_LOG);
    }
}