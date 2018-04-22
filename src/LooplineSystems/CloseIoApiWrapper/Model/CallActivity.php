<?php

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class CallActivity extends Activity implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    const STATUS_COMPLETED = 'completed';

    const DIRECTION_OUTBOUND = 'outbound';
    const DIRECTION_INBOUND = 'inbound';

    /**
     * @var string
     */
    protected $direction;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $note;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $recording_url;

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     *
     * @return CallActivity
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return CallActivity
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     *
     * @return CallActivity
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     *
     * @return CallActivity
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return CallActivity
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecordingURL()
    {
        return $this->recording_url;
    }

    /**
     * @param string $url
     *
     * @return CallActivity
     */
    public function setRecordingURL($url)
    {
        $this->recording_url = $url;

        return $this;
    }
}
