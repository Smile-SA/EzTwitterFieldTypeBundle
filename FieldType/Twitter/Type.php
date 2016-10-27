<?php

namespace Smile\EzTwitterFieldTypeBundle\FieldType\Twitter;

use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\Core\FieldType\Null\Value as NullValue;
use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\Core\FieldType\ValidationError;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\Core\FieldType\Value as BaseValue;
use eZ\Publish\SPI\Persistence\Content\FieldValue;

class Type extends FieldType
{
    protected $validatorConfigurationSchema = array(
        'TwitterValueValidator' => array(
            'integerValue' => array(
                'type' => 'int',
                'default' => null,
            ),
            'hexaValue' => array(
                'type' => 'hexa',
                'default' => null,
            ),
        ),
    );

    public function validateValidatorConfiguration($validatorConfiguration)
    {
        $validationErrors = array();

        foreach ($validatorConfiguration as $validatorIdentifier => $constraints) {
            if ($validatorIdentifier !== 'TwitterValueValidator') {
                $validationErrors[] = new ValidationError(
                    "Validator '%validator%' is unknown",
                    null,
                    array(
                        '%validator%' => $validatorIdentifier,
                    ),
                    "[$validatorIdentifier]"
                );

                continue;
            }
            foreach ($constraints as $name => $value) {
                switch ($name) {
                    case 'integerValue':
                        $exp = '/[0-9]*/';
                        if ($value !== null
                            && isset($value->options['tweet-limit'])
                            && !empty($value->options['tweet-limit'])
                            && !preg_match($exp, $value->options['tweet-limit'])) {
                            $validationErrors[] = new ValidationError(
                                "Validator parameter %parameter% 'tweet-limit' value must be of integer type",
                                null,
                                array(
                                    '%parameter%' => $name,
                                ),
                                "[$validatorIdentifier][$name]"
                            );
                        }

                        if ($value !== null
                            && isset($value->options['width'])
                            && !empty($value->options['width'])
                            && !preg_match($exp, $value->options['width'])) {
                            $validationErrors[] = new ValidationError(
                                "Validator parameter %parameter% 'width' value must be of integer type",
                                null,
                                array(
                                    '%parameter%' => $name,
                                ),
                                "[$validatorIdentifier][$name]"
                            );
                        }

                        if ($value !== null
                            && isset($value->options['height'])
                            && !empty($value->options['height'])
                            && !preg_match($exp, $value->options['height'])) {
                            $validationErrors[] = new ValidationError(
                                "Validator parameter %parameter% 'height' value must be of integer type",
                                null,
                                array(
                                    '%parameter%' => $name,
                                ),
                                "[$validatorIdentifier][$name]"
                            );
                        }
                        break;
                    case 'hexaValue':
                        $exp = '/([a-f0-9]{3}){1,2}\b/i';
                        if ($value !== null
                            && isset($value->options['link-color'])
                            && !empty($value->options['link-color'])
                            && !preg_match($exp, $value->options['link-color'])) {
                            $validationErrors[] = new ValidationError(
                                "Validator parameter %parameter% 'link-color' value must be an hexadecimal code",
                                null,
                                array(
                                    '%parameter%' => $name,
                                ),
                                "[$validatorIdentifier][$name]"
                            );
                        }

                        if ($value !== null
                            && isset($value->options['border-color'])
                            && !empty($value->options['border-color'])
                            && !preg_match($exp, $value->options['border-color'])) {
                            $validationErrors[] = new ValidationError(
                                "Validator parameter %parameter% 'border-color' value must be an hexadecimal code",
                                null,
                                array(
                                    '%parameter%' => $name,
                                ),
                                "[$validatorIdentifier][$name]"
                            );
                        }
                        break;
                    default:
                        $validationErrors[] = new ValidationError(
                            "Validator parameter '%parameter%' is unknown",
                            null,
                            array(
                                '%parameter%' => $name,
                            ),
                            "[$validatorIdentifier][$name]"
                        );
                }
            }
        }

        return $validationErrors;
    }

    public function validate(FieldDefinition $fieldDefinition, SPIValue $fieldValue)
    {
        $validationErrors = array();

        if ($fieldValue instanceof NullValue ||
            $this->isEmptyValue($fieldValue)) {
            return $validationErrors;
        }

        $validatorConfiguration = $fieldDefinition->getValidatorConfiguration();
        $constraints = isset($validatorConfiguration['TwitterValueValidator']) ?
            $validatorConfiguration['TwitterValueValidator'] :
            array();

        $validationErrors = array();

        // 0 and False are unlimited value for maxIntegerValue
        if (isset($constraints['integerValue']) &&
            $constraints['integerValue'] !== false
        ) {
            $validationErrors[] = new ValidationError(
                'The limit, width and/or height should be integer.',
                null,
                array(),
                'value'
            );
        }

        if (isset($constraints['hexaValue'])
            && $constraints['minIntegerValue'] !== false) {
            $validationErrors[] = new ValidationError(
                'The link-color and/or border-color value should be hexadecimal code.',
                null,
                array(),
                'value'
            );
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
        $exp = '/[0-9]*/';
        if (isset($value->options['tweet-limit'])
            && !empty($value->options['tweet-limit'])
            && !preg_match($exp, $value->options['tweet-limit'])) {
            throw new InvalidArgumentType(
                '$value->options[\'tweet-limit\']',
                'integer',
                $value->options['tweet-limit']
            );
        }

        if (isset($value->options['width'])
            && !empty($value->options['width'])
            && !preg_match($exp, $value->options['width'])) {
            throw new InvalidArgumentType(
                '$value->options[\'width\']',
                'integer',
                $value->options['width']
            );
        }

        if (isset($value->options['height'])
            && !empty($value->options['height'])
            && !preg_match($exp, $value->options['height'])) {
            throw new InvalidArgumentType(
                '$value->options[\'height\']',
                'integer',
                $value->options['height']
            );
        }
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
            'user' => $value->user,
            'options' => $value->options,
        );

        return json_encode($dataText);
    }

    public function fromPersistenceValue(FieldValue $fieldValue)
    {
        $value = new Value(json_decode($fieldValue->data, true));
        if ($this->isEmptyValue($value)) {
            return new Value();
        }
        return $this->acceptValue($value);
    }

    public function isSearchable()
    {
        return true;
    }
}
