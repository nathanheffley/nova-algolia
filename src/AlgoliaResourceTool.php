<?php

namespace NathanHeffley\NovaAlgolia;

use Laravel\Nova\ResourceTool;

class AlgoliaResourceTool extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Algolia';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'algolia-resource-tool';
    }
}
