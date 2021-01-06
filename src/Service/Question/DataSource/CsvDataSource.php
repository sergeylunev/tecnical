<?php

namespace App\Service\Question\DataSource;

use App\Service\Question\ChoiceDTO;
use App\Service\Question\DataSourceInterface;
use App\Service\Question\QuestionDTO;

class CsvDataSource implements DataSourceInterface
{
    public const FILE_NAME = 'questions.csv';

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

        $dataArray = explode("\n", trim($dataString));
        $data = array_map('str_getcsv', $dataArray);
        array_shift($data);

        $result = [];
        foreach ($data as $item) {
            $choices = [];
            for ($i = 2; $i < count($item); $i++) {
                $choices[] = new ChoiceDTO($item[$i]);
            }

            $result[] = new QuestionDTO(
                $item[0],
                new \DateTimeImmutable($item[1]),
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
