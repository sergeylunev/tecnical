<?php

namespace App\Controller;

use App\Service\Question\QuestionDTO;
use App\Service\QuestionService;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController
{
    public function list(
        QuestionService $questionService,
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $lang = $request->query->get('lang');

        $questions = $questionService->getQuestions($lang);
        $json = $serializer->serialize($questions, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    public function add(
        QuestionService $questionService,
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $content = $request->getContent();
        $question = $questionService->addQuestion(QuestionDTO::createFromJson($content));

        $json = $serializer->serialize($question, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
