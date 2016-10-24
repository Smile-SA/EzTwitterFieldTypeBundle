<?php

namespace Smile\EzTwitterFieldTypeBundle\FieldType\Twitter;

use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition;
use eZ\Publish\SPI\FieldType\Indexable;
use eZ\Publish\SPI\Search;
use Smile\EzTwitterFieldTypeBundle\Search\FieldType\TwitterField;

class SearchField implements Indexable
{
    public function getIndexData(Field $field, FieldDefinition $fieldDefinition)
    {
        return array(
            new Search\Field(
                'value',
                $field->value->data,
                new TwitterField()
            ),
            new Search\Field(
                'fulltext',
                $field->value->data,
                new Search\FieldType\FullTextField()
            ),
        );
    }

    public function getIndexDefinition()
    {
        return array(
            'value' => new TwitterField(),
        );
    }

    public function getDefaultMatchField()
    {
        return 'value';
    }

    public function getDefaultSortField()
    {
        return $this->getDefaultMatchField();
    }
}
