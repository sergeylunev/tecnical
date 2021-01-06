<?php

namespace App\Service;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslatorService
{
    private GoogleTranslate $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    public function translate(string $to, string $string, ?string $from = null): string
    {
        $this->translator->setSource($from);
        $this->translator->setTarget($to);

        return $this->translator->translate($string);
    }

}
