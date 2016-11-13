<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH.

namespace PleskX\Api;

class Operator
{

    /** @var string|null */
    protected $_wrapperTag = null;

    /** @var \PleskX\Api\Client */
    protected $_client;

    public function __construct($client)
    {
        $this->_client = $client;

        if (is_null($this->_wrapperTag)) {
            $classNameParts = explode('\\', get_class($this));
            $this->_wrapperTag = end($classNameParts);
            $this->_wrapperTag = strtolower(preg_replace('/([a-z])([A-Z])/', '\1-\2', $this->_wrapperTag));
        }
    }

    /**
     * Perform plain API request
     *
     * @param string|array $request
     * @param int $mode
     * @return XmlResponse
     */
    public function request($request, $mode = Client::RESPONSE_SHORT)
    {
        $wrapperTag = $this->_wrapperTag;

        if (is_array($request)) {
            $request = [$wrapperTag => $request];
        } else if (preg_match('/^[a-z]/', $request)) {
            $request = "$wrapperTag.$request";
        } else {
            $request = "<$wrapperTag>$request</$wrapperTag>";
        }

        return $this->_client->request($request, $mode);
    }

    /**
     * @param string $field
     * @param integer|string $value
     * @param string $deleteMethodName
     * @return bool
     */
    public function _delete($field, $value, $deleteMethodName = 'del')
    {
        $response = $this->request("$deleteMethodName.filter.$field=$value");
        return 'ok' === (string)$response->status;
    }

}
