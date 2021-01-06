<?php

namespace App\Service\Question;

use App\Service\TranslatorService;
use Stichoza\GoogleTranslate\GoogleTranslate;

class QuestionTranslator
{
    protected const TRANSLATION_SEPARATOR = '=====';
    private TranslatorService $translator;

    public function __construct(TranslatorService $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param QuestionDTO[] $questions
     * @param string $lang
     * @return QuestionDTO[]
     */
    public function translate(array $questions, string $lang): array
    {
        $result = [];

        foreach ($questions as $question) {
            $result[] = $this->translateQuestion($question, $lang);
        }

        return $result;
    }

    public function translateQuestion(QuestionDTO $question, string $lang): QuestionDTO
    {
        $stringToTranslate = $this->prepareQuestionForTranslation($question);
        $translatedString = $this->translatePreparedString($stringToTranslate, $lang);

        return $this->translatedStringToObject($translatedString, $question->getCreatedAt());
    }

    protected function prepareQuestionForTranslation(QuestionDTO $question): string
    {
        $translationString = $question->getText() . "\n" . self::TRANSLATION_SEPARATOR . "\n";

        foreach ($question->getChoices() as $choice) {
            $translationString .= $choice->getText() . "\n" . self::TRANSLATION_SEPARATOR . "\n";
        }

        return mb_substr(rtrim($translationString), 0, -5);
    }

    protected function translatePreparedString(string $stringToTranslate, string $toLang): string
    {
        return $this->translator->translate($toLang, $stringToTranslate);
    }

    private function translatedStringToObject(string $translatedString, \DateTimeImmutable $createdAt): QuestionDTO
    {
        $translations = explode(self::TRANSLATION_SEPARATOR, $translatedString);

        $choices = [];
        for ($i = 1; $i < count($translations); $i++) {
            $choices[] = new ChoiceDTO(trim($translations[$i]));
        }

        return new QuestionDTO(
            trim($translations[0]),
            $createdAt,
            $choices
        );
    }
}
