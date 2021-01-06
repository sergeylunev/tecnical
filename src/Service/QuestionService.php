<?php

namespace App\Service;

use App\Service\Question\DataSourceInterface;
use App\Service\Question\QuestionTranslator;

class QuestionService
{
    private DataSourceInterface $dataSource;
    /**
     * @var QuestionTranslator
     */
    private QuestionTranslator $questionTranslator;

    public function __construct(
        DataSourceInterface $dataSource,
        QuestionTranslator $questionTranslator
    )
    {
        $this->dataSource = $dataSource;
        $this->questionTranslator = $questionTranslator;
    }

    public function getQuestions(string $lang): array
    {
        $questions = $this->dataSource->getAll();
        $questions = $this->questionTranslator->translate($questions, $lang);

        return $questions;
    }
}
