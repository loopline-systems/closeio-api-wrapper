<?php

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems.
 *
 * @see      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 *
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

declare(strict_types=1);

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Model\User;

class UserApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default.
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-current-user' => '/me/',
            'get-users' => '/user/',
            'get-user' => '/user/[:id]',
        ];
    }

    /**
     * Gets all the users who are members of the same organizations as the user
     * currently making the request.
     *
     * @param int      $offset The offset from which start getting the items
     * @param int      $limit  The maximum number of items to get
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return User[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var User[] $users */
        $users = [];
        $response = $this->client->get($this->prepareUrlForKey('get-users'), [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]);

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $user) {
            $users[] = new User($user);
        }

        return $users;
    }

    /**
     * Gets the information about the user that matches the given ID.
     *
     * @param string   $id     The ID of the user
     * @param string[] $fields The subset of fields to get (defaults to all)
     */
    public function get(string $id, array $fields = []): User
    {
        $response = $this->client->get($this->prepareUrlForKey('get-user', ['id' => $id]), ['_fields' => $fields]);

        return new User($response->getDecodedBody());
    }

    /**
     * Gets the information about the current logged-in user.
     *
     * @param string[] $fields The subset of fields to get (defaults to all)
     */
    public function getCurrent(array $fields = []): User
    {
        $response = $this->client->get($this->prepareUrlForKey('get-current-user'), ['_fields' => $fields]);

        return new User($response->getDecodedBody());
    }

    /**
     * Gets the information about the current logged-in user.
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getCurrent() instead
     */
    public function getCurrentUser(): User
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getCurrent() instead.', __METHOD__), \E_USER_DEPRECATED);

        return $this->getCurrent();
    }

    /**
     * Gets all the users.
     *
     * @return User[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead
     */
    public function getAllUsers(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use list() instead.', __METHOD__), \E_USER_DEPRECATED);

        return $this->list();
    }

    /**
     * Gets the information about the user that matches the given ID.
     *
     * @param string $id The ID of the user
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use get() instead
     */
    public function getUser(string $id): User
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), \E_USER_DEPRECATED);

        return $this->get($id);
    }
}
