<?php

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

/**
 * Class NoteActivity
 * @package LooplineSystems\CloseIoApiWrapper\Model
 */
class NoteActivity extends Activity implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /**
     * @var string
     */
    protected $note;

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
     * @return NoteActivity
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }
}
