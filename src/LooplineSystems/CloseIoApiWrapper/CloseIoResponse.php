<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper;

class CloseIoResponse
{

    const GET_RESPONSE_DATA_KEY = 'data';
    const GET_ALL_RESPONSE_HAS_MORE_KEY = 'has_more';
    const GET_ALL_RESPONSE_TOTAL_RESULTS_KEY = 'total_results';

    /**
     * @var int
     */
    private $returnCode;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $rawData;

    /**
     * @var array
     */
    private $curlInfoRaw;

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $rawData
     */
    public function setRawData($rawData)
    {
        $this->rawData = $rawData;
    }

    /**
     * @return string
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @param int $returnCode
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
    }

    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }


    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->returnCode >= 200 && $this->returnCode < 300;
    }

    /**
     * @param array $curlInfoRaw
     */
    public function setCurlInfoRaw($curlInfoRaw)
    {
        $this->curlInfoRaw = $curlInfoRaw;
    }

    /**
     * @return array
     */
    public function getCurlInfoRaw()
    {
        return $this->curlInfoRaw;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        $errors = array();
        $data = $this->getData();

        if (isset($data['errors'])) $errors['errors'] = $data['errors'];
        if (isset($data['error'])) $errors['error'] = $data['error'];
        if (isset($data['field-errors'])) $errors['field-errors'] = $data['field-errors'];

        return $errors;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        $errors = $this->getErrors();
        if (!empty($errors)) {
            return true;
        }
        return false;
    }
}
