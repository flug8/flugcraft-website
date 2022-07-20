<?php namespace Tailor\Classes;

use October\Contracts\Element\ListElement;
use October\Contracts\Element\FormElement;
use October\Contracts\Element\FilterElement;
use October\Rain\Element\Form\FieldsetDefinition;
use October\Rain\Database\Schema\Blueprint as DbBlueprint;
use SystemException;

/**
 * Fieldset definition is a group of fields and can come from various sources
 *
 * @method Fieldset contentUuid(string $contentUuid) contentUuid
 * @method Fieldset name(string $name) name
 * @method Fieldset handle(string $handle) handle
 *
 * @package october\tailor
 * @author Alexey Bobkov, Samuel Georges
 */
class Fieldset extends FieldsetDefinition
{
    /**
     * validate all the fields
     */
    public function validate(): void
    {
        foreach ($this->getAllFields() as $field) {
            $field->validate();
        }
    }

    /**
     * applyModelExtensions
     */
    public function applyModelExtensions($model)
    {
        if (!$model) {
            throw new SystemException('Cannot extend an empty model.');
        }

        foreach ($this->getAllFields() as $field) {
            $field->extendModel($model);
        }
    }

    /**
     * defineAllListColumns
     */
    public function defineAllListColumns(ListElement $list, $context = null): void
    {
        foreach ($this->getAllFields() as $field) {
            if ($field->column !== false) {
                $field->defineListColumn($list, $context);
            }
        }
    }

    /**
     * defineAllFilterScopes
     */
    public function defineAllFilterScopes(FilterElement $filter, $context = null): void
    {
        foreach ($this->getAllFields() as $field) {
            if ($field->scope !== false) {
                $field->defineFilterScope($filter, $context);
            }
        }
    }

    /**
     * defineAllFormFields
     */
    public function defineAllFormFields(FormElement $form, $context = null): void
    {
        // Set the default tab
        $form->getFormFieldset()->defaultTab('Content');

        // Define the fields
        foreach ($this->getAllFields() as $field) {
            $field->defineFormField($form, $context);
        }
    }

    /**
     * getContentColumnNames spins over every field to determine the actual column
     * names that it uses in the databse, as opposed to its field name
     */
    public function getContentColumnNames()
    {
        $columnNames = [];

        $table = new DbBlueprint('temp');
        foreach ($this->getAllFields() as $fieldObj) {
            $fieldObj->extendDatabaseTable($table);
        }

        foreach ($table->getColumns() as $column) {
            if (isset($column['name'])) {
                $columnNames[] = $column['name'];
            }
        }

        return $columnNames;
    }
}
