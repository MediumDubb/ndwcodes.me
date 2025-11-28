<?php

namespace SilverStripe\Core\Validation\FieldValidation;

use SilverStripe\Core\Validation\ValidationResult;

/**
 * Validates a value in DBYear field
 * This FieldValidator is not intended to be used in fields other than DBYear
 */
class YearFieldValidator extends IntFieldValidator
{
    /**
     * Special year value which is less than DBYear::MIN_YEAR and is considered valid
     */
    private const SPECIAL_YEAR = 0;

    protected function validateValue(): ValidationResult
    {
        if ($this->value === YearFieldValidator::SPECIAL_YEAR) {
            return ValidationResult::create();
        }
        return parent::validateValue();
    }
}
