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

class EmailActivity extends Activity implements \JsonSerializable
{
    use JsonSerializableHelperTrait;
    use ObjectHydrateHelperTrait;

    const DIRECTION_OUTBOUND = 'outbound';
    const DIRECTION_INBOUND = 'inbound';

    const STATUS_INBOX = 'inbox';
    const STATUS_DRAFT = 'draft';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_OUTBOX = 'outbox';
    const STATUS_SENT = 'sent';

    /** @var string */
    protected $status;

    /** @var string */
    protected $direction;

    /** @var string */
    protected $subject;

    /** @var string */
    protected $sender;

    /** @var mixed */
    protected $to;

    /** @var mixed */
    protected $bcc;

    /** @var mixed */
    protected $cc;

    /** @var string */
    protected $body_text;

    /** @var string */
    protected $body_html;

    /** @var string */
    protected $date_scheduled;

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return EmailActivity
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     *
     * @return EmailActivity
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     *
     * @return EmailActivity
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param mixed $bcc
     *
     * @return EmailActivity
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param mixed $cc
     *
     * @return EmailActivity
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyText()
    {
        return $this->body_text;
    }

    /**
     * @param string $body_text
     *
     * @return EmailActivity
     */
    public function setBodyText($body_text)
    {
        $this->body_text = $body_text;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyHtml()
    {
        return $this->body_html;
    }

    /**
     * @param string $body_html
     *
     * @return EmailActivity
     */
    public function setBodyHtml($body_html)
    {
        $this->body_html = $body_html;

        return $this;
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
     *
     * @return EmailActivity
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
     * @return EmailActivity
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
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
     *
     * @return EmailActivity
     */
    public function setDateScheduled($date_scheduled)
    {
        $this->date_scheduled = $date_scheduled;

        return $this;
    }
}
