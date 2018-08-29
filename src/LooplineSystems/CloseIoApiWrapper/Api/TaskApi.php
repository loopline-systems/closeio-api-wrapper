<?php

declare(strict_types=1);

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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\Task;

class TaskApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 50;

    const NAME = 'TaskApi';

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
            'delete-task' => '/task/[:id]/'
        ];
    }

    /**
     * Gets up to the specified number of tasks that matches the given criteria.
     *
     * @param int   $offset The offset from which start getting the items
     * @param int   $limit  The maximum number of items to get
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return Task[]
     */
    public function getAll(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var Task[] $tasks */
        $tasks = [];
        $result = $this->triggerGet(
            $this->prepareRequest('get-tasks', null, [], [
                '_skip' => $offset,
                '_limit' => $limit,
                '_fields' => $fields,
            ])
        );

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $task) {
                $tasks[] = new Task($task);
            }
        }

        return $tasks;
    }

    /**
     * Gets the information about the task that matches the given ID.
     *
     * @param string $id The ID of the task
     *
     * @return Task
     *
     * @throws ResourceNotFoundException If a task with the given ID doesn't
     *                                   exists
     */
    public function get(string $id): Task
    {
        $result = $this->triggerGet($this->prepareRequest('get-task', null, ['id' => $id]));

        return new Task($result->getData());
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
        $apiRequest = $this->prepareRequest('add-task', json_encode($task));

        return new Task($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Updates the given task.
     *
     * @param Task $task The task to update
     *
     * @return Task
     *
     * @throws ResourceNotFoundException If a task with the given ID doesn't
     *                                   exists
     */
    public function update(Task $task): Task
    {
        $id = $task->getId();

        $task->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-task', json_encode($task), ['id' => $id]));

        return new Task($response->getData());
    }

    /**
     * Deletes the given task.
     *
     * @param string $taskId The ID of the task to delete
     *
     * @throws ResourceNotFoundException If a task with the given ID doesn't
     *                                   exists
     */
    public function delete(string $taskId): void
    {
        $this->triggerDelete($this->prepareRequest('delete-task', null, ['id' => $taskId]));
    }

    /**
     * Gets up to the specified number of tasks that matches the given criteria.
     *
     * @return Task[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getAll() instead
     */
    public function getAllTasks(): array
    {
        return $this->getAll();
    }

    /**
     * Gets the information about the task that matches the given ID.
     *
     * @param string $id The ID of the task
     *
     * @return Task
     *
     * @throws ResourceNotFoundException If a task with the given ID doesn't
     *                                   exists
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
     * @throws ResourceNotFoundException If a task with the given ID doesn't
     *                                   exists
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
     * @param string $taskId The ID of the task to delete
     *
     * @throws ResourceNotFoundException If a task with the given ID doesn't
     *                                   exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteTask($taskId): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->delete($taskId);
    }
}
