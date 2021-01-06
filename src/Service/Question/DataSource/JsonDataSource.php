<?php

namespace App\Service\Question\DataSource;

use App\Service\Question\ChoiceDTO;
use App\Service\Question\DataSourceInterface;
use App\Service\Question\QuestionDTO;

class JsonDataSource implements DataSourceInterface
{
    public const FILE_NAME = 'questions.json';

    private string $dataFolderPath;

    public function __construct(string $dataFolderPath)
    {
        $this->dataFolderPath = $dataFolderPath;
    }

    /**
     * @return QuestionDTO[]
     */
    public function getAll(): array
    {
        $fileName = $this->dataFolderPath . DIRECTORY_SEPARATOR . self::FILE_NAME;

        if (!file_exists($fileName)) {
            throw new \Exception("{$fileName} dont exists.");
        }

        $dataString = file_get_contents($fileName);

        if (!$dataString) {
            throw new \Exception("Can't read data from {$fileName}");
        }

        $data = json_decode($dataString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(json_last_error_msg());
        }

        $result = [];
        foreach ($data as $item) {
            $choices = [];
            foreach ($item['choices'] as $choice) {
                $choices[] = new ChoiceDTO($choice['text']);
            }

            $result[] = new QuestionDTO(
                $item['text'],
                new \DateTimeImmutable($item['createdAt']),
                $choices
            );
        }

        return $result;
    }

    public function add(QuestionDTO $question): QuestionDTO
    {
        // TODO: Implement add() method.
    }
}
