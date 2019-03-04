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
use LooplineSystems\CloseIoApiWrapper\Model\Task;

class TaskApi extends AbstractApi
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
            'get-tasks' => '/task/',
            'add-task' => '/task/',
            'get-task' => '/task/[:id]/',
            'update-task' => '/task/[:id]/',
            'delete-task' => '/task/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of tasks that matches the given criteria.
     *
     * @param int      $offset The offset from which start getting the items
     * @param int      $limit  The maximum number of items to get
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return Task[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var Task[] $tasks */
        $tasks = [];
        $response = $this->client->get($this->prepareUrlForKey('get-tasks'), [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]);

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $task) {
            $tasks[] = new Task($task);
        }

        return $tasks;
    }

    /**
     * Gets the information about the task that matches the given ID.
     *
     * @param string   $id     The ID of the task
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return Task
     */
    public function get(string $id, array $fields = []): Task
    {
        $response = $this->client->get($this->prepareUrlForKey('get-task', ['id' => $id]), ['_fields' => $fields]);

        return new Task($response->getDecodedBody());
    }

    /**
     * Creates a new task using the given information.
     *
     * @param Task $task The information of the task to create
     *
     * @return Task
     */
    public function create(Task $task): Task
    {
        $response = $this->client->post($this->prepareUrlForKey('add-task'), [], $task->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Task($responseData);
    }

    /**
     * Updates the given task.
     *
     * @param Task $task The task to update
     *
     * @return Task
     */
    public function update(Task $task): Task
    {
        $id = $task->getId();

        $task->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-task', ['id' => $id]), [], $task->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Task($responseData);
    }

    /**
     * Deletes the given task.
     *
     * @param Task $task The task to delete
     */
    public function delete(Task $task): void
    {
        $id = $task->getId();

        $task->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-task', ['id' => $id]));
    }

    /**
     * Gets up to the specified number of tasks that matches the given criteria.
     *
     * @return Task[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead
     */
    public function getAllTasks(): array
    {
        return $this->list();
    }

    /**
     * Gets the information about the task that matches the given ID.
     *
     * @param string $id The ID of the task
     *
     * @return Task
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use get() instead
     */
    public function getTask($id): Task
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get($id);
    }

    /**
     * Creates a new task using the given information.
     *
     * @param Task $task The information of the task to create
     *
     * @return Task
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use create() instead
     */
    public function addTask(Task $task): Task
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use create() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->create($task);
    }

    /**
     * Updates the given task.
     *
     * @param Task $task The task to update
     *
     * @return Task
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use update() instead
     */
    public function updateTask(Task $task): Task
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->update($task);
    }

    /**
     * Deletes the given task.
     *
     * @param string $id The ID of the task to delete
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteTask($id): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->client->delete($this->prepareUrlForKey('delete-task', ['id' => $id]));
    }
}
