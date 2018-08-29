<?php

namespace NathanHeffley\NovaAlgolia\Actions;

use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;

class RemoveAlgolia extends Action
{
    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Remove from Algolia';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->unsearchable();
        }

        return Action::message(sprintf('%s removed from Algolia!', $models->count()));
    }
}
