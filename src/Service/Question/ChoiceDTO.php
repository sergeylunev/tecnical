<?php

namespace App\Service\Question;

use JMS\Serializer\Annotation\Type;

class ChoiceDTO
{
    /** @Type("string") */
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
