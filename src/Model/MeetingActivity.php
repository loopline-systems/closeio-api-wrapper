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

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class MeetingActivity extends Activity implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /** @var Contact[] */
    protected $attendees;

    /** @var string */
    protected $calendar_event_link;

    /** @var string */
    protected $connected_account_id;

    /** @var int */
    protected $duration;

    /** @var \DateTime */
    protected $ends_at;

    /** @var bool */
    protected $is_recurring;

    /** @var string */
    protected $location;

    /** @var string */
    protected $note;

    /** @var string */
    protected $source;

    /** @var \DateTime */
    protected $starts_at;

    /** @var string */
    protected $status;

    /** @var string */
    protected $title;

    /**
     * @return Contact[]
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * @param Contact[] $attendees
     *
     * @return MeetingActivity
     */
    public function setAttendees(array $attendees)
    {
        $this->attendees = $attendees;

        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarEventLink()
    {
        return $this->calendar_event_link;
    }

    /**
     * @param string $calendar_event_link
     *
     * @return MeetingActivity
     */
    public function setCalendarEventLink($calendar_event_link)
    {
        $this->calendar_event_link = $calendar_event_link;

        return $this;
    }

    /**
     * @return string
     */
    public function getConnectedAccountId()
    {
        return $this->connected_account_id;
    }

    /**
     * @param string $connected_account_id
     *
     * @return MeetingActivity
     */
    public function setConnectedAccountId($connected_account_id)
    {
        $this->connected_account_id = $connected_account_id;

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
     * @return MeetingActivity
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndsAt()
    {
        return $this->ends_at;
    }

    /**
     * @param \DateTime $ends_at
     *
     * @return MeetingActivity
     */
    public function setEndsAt($ends_at)
    {
        $this->ends_at = $ends_at;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsRecurring()
    {
        return $this->is_recurring;
    }

    /**
     * @param bool $is_recurring
     *
     * @return MeetingActivity
     */
    public function setIsRecurring($is_recurring)
    {
        $this->is_recurring = $is_recurring;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $duration
     *
     * @return MeetingActivity
     */
    public function setLocation($location)
    {
        $this->location = $location;

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
     * @return MeetingActivity
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     *
     * @return MeetingActivity
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->starts_at;
    }

    /**
     * @param \DateTime $starts_at
     *
     * @return MeetingActivity
     */
    public function setStartsAt($starts_at)
    {
        $this->starts_at = $starts_at;

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
     * @return MeetingActivity
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return MeetingActivity
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
