<?php

namespace Integrity;

interface StreamInterface
{

    public function readData();
    public function sendData($data);
}
