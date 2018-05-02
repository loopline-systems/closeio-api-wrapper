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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
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
     */
    public function getAllUsers()
    {
        /** @var User[] $users */
        $users = array();

        $query = ['_limit' => 500, '_skip' => 0];

        $apiRequest = $this->prepareRequest('get-users', null, [], $query);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_ALL_RESPONSE_DATA_KEY];
            foreach ($rawData as $user) {
                $users[] = new User($user);
            }
        }

        return $users;
    }

    /**
     * @param $id
     * @return User
     * @throws ResourceNotFoundException
     */
    public function getUser($id)
    {
        $apiRequest = $this->prepareRequest('get-user', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
            $opportunity = new User($result->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $opportunity;
    }

    /**
     * @param Curl $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
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
