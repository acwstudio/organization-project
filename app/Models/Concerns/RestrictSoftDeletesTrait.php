<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Exceptions\DeleteRestrictionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use LogicException;

trait RestrictSoftDeletesTrait
{
    /**
     * Boot the trait.
     *
     * Listen for the deleting event of a soft deleting model, and run
     * the delete operation for any configured relationship methods.
     *
     * @throws \LogicException
     */
    protected static function bootRestrictSoftDeletesTrait(): void
    {
        static::deleting(function ($model) {
            if (!$model->implementsSoftDeletes()) {
                throw new LogicException(sprintf(
                    '%s does not implement Illuminate\Database\Eloquent\SoftDeletes',
                    get_called_class()
                ));
            }
            if ($invalidRestrictedRelationships = $model->hasInvalidRestrictedRelationships()) {
                throw new LogicException(sprintf(
                    '%s [%s] must exist and return an object of type Illuminate\Database\Eloquent\Relations\Relation',
                    Str::plural('Relationship', count($invalidRestrictedRelationships)),
                    join(', ', $invalidRestrictedRelationships)
                ));
            }

            $restrictions = [];
            foreach ($model->getActiveRestrictedDeletes() as $relationship) {
                if ($model->{$relationship} instanceof Model) {
                    if (!self::isSoftDeleted($model->{$relationship})) {
                        $restrictions[$relationship] = $relationship;
                    }
                    continue;
                }
                foreach ($model->{$relationship} as $child) {
                    if (!self::isSoftDeleted($child)) {
                        $restrictions[$relationship] = $relationship;
                    }
                }
            }

            if ($restrictions) {
                $modelNameParts = explode('\\', get_class($model));
                $modelName = array_pop($modelNameParts);
                $message = "This $modelName can not be deleted, because it has existing ";
                $message .= implode(' and ', $restrictions);
                $message .= " connected to it. Please delete the connecting entities first!";
                throw new DeleteRestrictionException($message, 403);
            }
        });
    }

    protected static function isSoftDeleted(Model $model)
    {
        return method_exists($model, 'runSoftDelete') && $model->trashed();
    }

    /**
     * Determine if the current model implements soft deletes.
     *
     * @return bool
     */
    protected function implementsSoftDeletes()
    {
        return method_exists($this, 'runSoftDelete');
    }

    /**
     * Determine if the current model has any invalid cascading relationships defined.
     *
     * A relationship is considered invalid when the method does not exist, or the relationship
     * method does not return an instance of Illuminate\Database\Eloquent\Relations\Relation.
     *
     * @return array
     */
    protected function hasInvalidRestrictedRelationships()
    {
        return array_filter($this->getRestrictedDeletes(), function ($relationship) {
            return !method_exists($this, $relationship) || !$this->{$relationship}() instanceof Relation;
        });
    }

    /**
     * Fetch the defined cascading soft deletes for this model.
     *
     * @return array
     */
    protected function getRestrictedDeletes()
    {
        return isset($this->restrictDeletes) ? (array)$this->restrictDeletes : [];
    }

    /**
     * For the cascading deletes defined on the model, return only those that are not null.
     *
     * @return array
     */
    protected function getActiveRestrictedDeletes()
    {
        return array_filter($this->getRestrictedDeletes(), function ($relationship) {
            return !is_null($this->{$relationship});
        });
    }
}
