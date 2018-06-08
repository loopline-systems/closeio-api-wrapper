<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\UrlNotSetException;
use LooplineSystems\CloseIoApiWrapper\Model\User;

class UserApi extends AbstractApi
{
    const NAME = 'UserApi';

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-users' => '/user/',
            'get-user' => '/user/[:id]',
        ];
    }

    /**
     * @return User[]
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getAllUsers()
    {
        /** @var User[] $users */
        $users = array();

        $apiRequest = $this->prepareRequest('get-users');

        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
            foreach ($rawData as $user) {
                $users[] = new User($user);
            }
        }

        return $users;
    }

    /**
     * @param string $id
     * @return User
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws ResourceNotFoundException
     * @throws UrlNotSetException
     */
    public function getUser($id)
    {
        $apiRequest = $this->prepareRequest('get-user', null, ['id' => $id]);

        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && (!empty($result->getData()))) {
            $opportunity = new User($result->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $opportunity;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function validateUserForPost(User $user)
    {
        return true;
    }

}
