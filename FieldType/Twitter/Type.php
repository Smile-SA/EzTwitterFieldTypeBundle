<?php

namespace Smile\EzTwitterFieldTypeBundle\FieldType\Twitter;

use eZ\Publish\Core\FieldType\Null\Value as NullValue;
use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\Core\FieldType\Value as BaseValue;
use eZ\Publish\SPI\Persistence\Content\FieldValue;

class Type extends FieldType
{
    public function validateValidatorConfiguration($validatorConfiguration)
    {
        $validationErrors = array();

        return $validationErrors;
    }

    public function validate(FieldDefinition $fieldDefinition, SPIValue $fieldValue)
    {
        $validationErrors = array();

        if ($this->isEmptyValue($fieldValue)) {
            return $validationErrors;
        }

        return $validationErrors;
    }

    public function getFieldTypeIdentifier()
    {
        return 'smiletwitter';
    }

    public function getName(SPIValue $value)
    {
        return (string)$value->title;
    }

    public function getEmptyValue()
    {
        return new Value();
    }

    public function isEmptyValue(SPIValue $value)
    {
        return $value->title === null || trim($value->title) === '';
    }

    protected function createValueFromInput($inputValue)
    {
        if (is_array($inputValue)) {
            $inputValue = new Value($inputValue);
        }

        return $inputValue;
    }

    protected function checkValueStructure(BaseValue $value)
    {
    }

    protected function getSortInfo(BaseValue $value)
    {
        return $this->transformationProcessor->transformByGroup((string)$value, 'lowercase');
    }

    public function fromHash($hash)
    {
        if ($hash === null) {
            return $this->getEmptyValue();
        }

        return new Value($hash);
    }

    public function toHash(SPIValue $value)
    {
        if ($value instanceof NullValue || $this->isEmptyValue($value)) {
            return null;
        }

        $dataText = array(
            'title' => $value->title,
            'type' => $value->type,
            'user' => $value->user
        );

        return json_encode($dataText);
    }

    public function fromPersistenceValue(FieldValue $fieldValue)
    {
        $value = new Value(json_decode($fieldValue->data, true));
        if ($this->isEmptyValue($value)) {
            return new NullValue();
        }
        return $this->acceptValue($value);
    }

    public function isSearchable()
    {
        return true;
    }
}
