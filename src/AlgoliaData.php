<?php

namespace NathanHeffley\NovaAlgolia;

class AlgoliaData
{
    /**
     * The name of the index this resource is stored in.
     *
     * @var string
     */
    public $index;

    /**
     * The data indexed in Algolia for searching this record.
     *
     * @var array
     */
    public $data;
}
