<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH.

namespace PleskX\Api\Struct\Certificate;

class PoolInfo extends \PleskX\Api\Struct
{
    /** @var string */
    public $name;

    public function __construct($apiResponse)
    {
        $this->_initScalarProperties($apiResponse, [
            ['name' => 'name'],
        ]);
    }
}