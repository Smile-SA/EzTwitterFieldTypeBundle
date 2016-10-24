<?php

namespace Smile\EzTwitterFieldTypeBundle\FieldType\Twitter;

use Symfony\Component\Form\DataTransformerInterface;

class ValueTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (!$value instanceof Value) {
            return null;
        }

        return array(
            $value->title,
            $value->type,
            $value->user
        );
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }

        return new Value($value);
    }
}
