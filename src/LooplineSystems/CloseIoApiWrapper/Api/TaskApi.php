<?php declare(strict_types=1);
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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\UrlNotSetException;
use LooplineSystems\CloseIoApiWrapper\Model\Task;

class TaskApi extends AbstractApi
{
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
     * @return Task[]
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getAllTasks()
    {
        $tasks = [];

        $apiRequest = $this->prepareRequest('get-tasks');

        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
            foreach ($rawData as $task) {
                $tasks[] = new Task($task);
            }
        }

        return $tasks;
    }

    /**
     * @param string $id
     *
     * @return Task
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getTask($id)
    {
        $apiRequest = $this->prepareRequest('get-task', null, ['id' => $id]);

        $result = $this->triggerGet($apiRequest);

        return new Task($result->getData());
    }

    /**
     * @param Task $task
     *
     * @return Task
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function addTask(Task $task)
    {
        $task = json_encode($task);
        $apiRequest = $this->prepareRequest('add-task', $task);

        $result = $this->triggerPost($apiRequest);

        return new Task($result->getData());
    }

    /**
     * @param Task $task
     *
     * @return Task
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function updateTask(Task $task)
    {
        if ($task->getId() == null) {
            throw new InvalidParamException('When updating a task you must provide the task ID');
        }
        $id = $task->getId();
        $task->setId(null);

        $task = json_encode($task);
        $apiRequest = $this->prepareRequest('update-task', $task, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        return new Task($response->getData());
    }

    /**
     * @param string $id
     *
     * @return bool
     *
     * @throws InvalidParamException
     * @throws BadApiRequestException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function deleteTask($id){
        $apiRequest = $this->prepareRequest('delete-task', null, ['id' => $id]);

        $result = $this->triggerDelete($apiRequest);

        return $result->isSuccess();
    }
}
