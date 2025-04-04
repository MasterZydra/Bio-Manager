<?php

declare(strict_types = 1);

namespace Framework\i18n;

use Exception;

/** The LabelNotFoundException is thrown if a requested label does not exist in the requested language. */
class LabelNotFoundException extends Exception
{
    public function __construct(
        private string $languageCode,
        private string $labelName,
    ) {
        parent::__construct('No translations found for label "' . $this->labelName . '" for language code "' . $this->languageCode . '"');
    }
}