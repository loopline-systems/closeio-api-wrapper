<?php

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Model\Activity;
use LooplineSystems\CloseIoApiWrapper\Model\Call;

class ActivityApi extends AbstractApi
{

	const NAME = 'ActivityApi';

	/**
	 * @description initialize the routes array
	 */
	protected function initUrls()
	{
		$this->urls = [
			'add-note' => '/activity/note/',
			'get-note' => '/activity/note/[:id]/',
			'add-call' => '/activity/call/'
		];
	}

	/**
	 * @param Activity $activity
	 * @return CloseIoResponse
	 */
	public function addNote(Activity $activity)
	{
		$this->validateActivityForPost($activity);

		$activity = json_encode($activity);
		$apiRequest = $this->prepareRequest('add-note', $activity);
		return $this->triggerPost($apiRequest);
	}

	/**
	 * @param Call $call
	 * @return CloseIoResponse
	 */
	public function addCall(Call $call)
	{
		$this->validateActivityForPost($call);

		$call = json_encode($call);
		$apiRequest = $this->prepareRequest('add-call', $call);
		return $this->triggerPost($apiRequest);
	}

	/**
	 * @param $id
	 * @return Lead
	 * @throws ResourceNotFoundException
	 */
	public function getNote($id)
	{
		$apiRequest = $this->prepareRequest('get-note', null, ['id' => $id]);

		/** @var CloseIoResponse $result */
		$result = $this->triggerGet($apiRequest);

		var_dump($result);die;
		if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
			$lead = new Lead($result->getData());
		} else {
			throw new ResourceNotFoundException();
		}

		return $lead;
	}

	/**
	 * @param $activity
	 * @return bool
	 */
	private function validateActivityForPost($activity)
	{
		return true;
	}
	
}