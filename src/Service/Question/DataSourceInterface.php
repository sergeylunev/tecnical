<?php

namespace App\Service\Question;

interface DataSourceInterface
{
    public function getAll(): array;
    public function add(QuestionDTO $question): QuestionDTO;
}
