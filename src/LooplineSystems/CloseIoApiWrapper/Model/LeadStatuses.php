<?php
/**
 * Created by PhpStorm.
 * User: dlima
 * Date: 3/7/16
 * Time: 2:36 PM
 */

namespace LooplineSystems\CloseIoApiWrapper\Model;


use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class LeadStatuses implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    private $label;

    private $id;

    public function __construct(array $fields)
    {
        foreach($fields as $field=>$value)
        {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }

    /**
     * @param $label
     */
    public function setStatusLabel($label)
    {
        $this->label = $label;
    }

    public function getStatusLabel()
    {
        return $this->label;
    }

    public function setStatusId($id)
    {
        $this->id = $id;
    }

    public function getStatusId()
    {
        return $this->id;
    }
}