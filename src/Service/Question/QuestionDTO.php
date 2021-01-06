<?php

namespace App\Service\Question;

use JMS\Serializer\Annotation\Type;

class QuestionDTO
{
    /** @Type("string") */
    private string $text;
    /** @Type("DateTimeImmutable<'Y-m-d H:i:s'>") */
    private \DateTimeImmutable $createdAt;
    /**
     * @Type("array<App\Service\Question\ChoiceDTO>")
     * @var ChoiceDTO[]
     */
    private array $choices;

    /**
     * @param string $text
     * @param \DateTimeImmutable $createdAt
     * @param ChoiceDTO[] $choices
     */
    public function __construct(
        string $text,
        \DateTimeImmutable $createdAt,
        array $choices
    ){
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->choices = $choices;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return ChoiceDTO[]
     */
    public function getChoices(): array
    {
        return $this->choices;
    }
}
