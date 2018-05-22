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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Model\Task;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;

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
     */
    public function getAllTasks()
    {
        $tasks = array();

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
     * @throws InvalidParamException
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
     * @return CloseIoResponse
     * @throws ResourceNotFoundException
     */
    public function deleteTask($id){
        $apiRequest = $this->prepareRequest('delete-task', null, ['id' => $id]);

        $this->triggerDelete($apiRequest);
    }


    /**
     * @param Curl $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }
}
