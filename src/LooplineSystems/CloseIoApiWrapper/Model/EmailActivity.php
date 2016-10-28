<?php

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

/**
 * Class EmailActivity
 * @package LooplineSystems\CloseIoApiWrapper\Model
 */
class EmailActivity extends Activity implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

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

    /** @var [string] */
    protected $to;

    /** @var [string] */
    protected $bcc;

    /** @var [string] */
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
     * @return EmailActivity
     */
    public function setBodyHtml($body_html)
    {
        $this->body_html = $body_html;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param $direction
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
     * @param $status
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
     * @return EmailActivity
     */
    public function setDateScheduled($date_scheduled)
    {
        $this->date_scheduled = $date_scheduled;
        return $this;
    }
}
