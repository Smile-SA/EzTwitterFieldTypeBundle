<?php

namespace Smile\EzTwitterFieldTypeBundle\FieldType\Twitter;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    /**
     * Title
     *
     * @var string
     */
    public $title;

    public $type;

    public $user;

    public $options;

    public function __construct($value = array())
    {
        if (is_array($value) && isset($value['title']))
            $this->title = $value['title'];

        if (is_array($value) && isset($value['type']))
            $this->type = $value['type'];

        if (is_array($value) && isset($value['user']))
            $this->user = $value['user'];

        if (is_array($value) && isset($value['options']))
            $this->options = $value['options'];
    }

    public function __toString()
    {
        return (string)$this->title;
    }
}
