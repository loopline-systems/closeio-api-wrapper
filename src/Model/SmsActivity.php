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

class SmsActivity extends Activity implements \JsonSerializable
{
    use JsonSerializableHelperTrait;
    use ObjectHydrateHelperTrait;

    const DIRECTION_OUTBOUND = 'outbound';
    const DIRECTION_INBOUND = 'inbound';

    const STATUS_INBOX = 'inbox'; // to log an already received SMS.
    const STATUS_DRAFT = 'draft'; // to create a draft SMS.
    const STATUS_SCHEDULED = 'scheduled'; // to send an SMS at a scheduled date and time, which must be specified in the date_scheduled field.
    const STATUS_OUTBOX = 'outbox'; // to actually send an SMS. To delay SMS sending by a few seconds (to allow undo), specify send_in in seconds (must be less than 60).
    const STATUS_SENT = 'sent'; // to log an already sent SMS.

    /** @var string */
    protected $date_sent;

    /** @var string */
    protected $date_scheduled;

    /** @var string */
    protected $direction;

    /** @var string */
    protected $status = self::STATUS_DRAFT;

    /** @var string */
    protected $local_phone;

    /** @var string */
    protected $remote_phone;

    /** @var string */
    protected $remote_phone_formatted;

    /** @var string */
    protected $text;

    /**
     * @return string
     */
    public function getDateSent()
    {
        return $this->date_sent;
    }

    /**
     * @param string $date_sent
     */
    public function setDateSent($date_sent)
    {
        $this->date_sent = $date_sent;
    }

    /**
     * @return string
     */
    public function getDateScheduled()
    {
        return $this->date_scheduled;
    }

    /**
     * @param string $date_scheduled
     */
    public function setDateScheduled($date_scheduled)
    {
        $this->date_scheduled = $date_scheduled;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
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
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getLocalPhone()
    {
        return $this->local_phone;
    }

    /**
     * @param string $local_phone
     */
    public function setLocalPhone($local_phone)
    {
        $this->local_phone = $local_phone;
    }

    /**
     * @return string
     */
    public function getRemotePhone()
    {
        return $this->remote_phone;
    }

    /**
     * @param string $remote_phone
     */
    public function setRemotePhone($remote_phone)
    {
        $this->remote_phone = $remote_phone;
    }

    /**
     * @return string
     */
    public function getRemotePhoneFormatted()
    {
        return $this->remote_phone_formatted;
    }

    /**
     * @param string $remote_phone_formatted
     */
    public function setRemotePhoneFormatted($remote_phone_formatted)
    {
        $this->remote_phone_formatted = $remote_phone_formatted;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}
