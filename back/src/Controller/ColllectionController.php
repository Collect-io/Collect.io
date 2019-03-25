<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Colllection;
use App\Service\ColllectionService;
use League\Flysystem\FileNotFoundException;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ColllectionController extends AbstractController
{
    /**
     * @var ColllectionService
     */
    private $colllectionService;

    public function __construct(ColllectionService $colllectionService)
    {
        $this->colllectionService = $colllectionService;
    }

    /**
     * List all Colllections.
     *
     * @Route("/", name="list", methods={"GET"})
     *
     * @SWG\Tag(name="Colllections")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returned when Colllections are listed",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@ApiDoc\Model(type=Colllection::class))
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function listColllectionsAction(): JsonResponse
    {
        $colllections = $this->colllectionService->list();

        return $this->json($colllections);
    }

    /**
     * Create a Colllection.
     *
     * @Route("/", name="create", methods={"POST"})
     *
     * @SWG\Tag(name="Colllections")
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     description="Name of the colllection",
     *     required=false,
     *     type="string"
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returned when Colllection was created",
     *     @SWG\Schema(ref=@ApiDoc\Model(type=Colllection::class))
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returned when form is invalid"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createColllectionAction(Request $request): JsonResponse
    {
        $response = $this->colllectionService->create($request);

        if ($response instanceof FormInterface) {
            return $this->json($response, Response::HTTP_BAD_REQUEST);
        }

        return $this->json($response, Response::HTTP_CREATED);
    }

    /**
     * Get a Colllection.
     *
     * @Route("/{encodedColllectionPath}", name="get", methods={"GET"})
     *
     * @SWG\Tag(name="Colllections")
     *
     * @SWG\Parameter(
     *     name="encodedColllectionPath",
     *     in="path",
     *     description="Encoded colllection path",
     *     type="string"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returned when Colllection is found",
     *     @SWG\Schema(ref=@ApiDoc\Model(type=Colllection::class))
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returned when Colllection file is not found"
     * )
     *
     * @param string $encodedColllectionPath
     *
     * @return Colllection
     *
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getColllectionAction(string $encodedColllectionPath)
    {
        $colllection = $this->colllectionService->get($encodedColllectionPath);

        return $colllection;
    }

    /**
     * Update a Colllection.
     *
     * @Route("/{encodedColllectionPath}", name="update", methods={"PUT"})
     *
     * @SWG\Tag(name="Colllections")
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     description="Name of the colllection",
     *     required=false,
     *     type="string"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returned when Colllection was updated",
     *     @SWG\Schema(ref=@ApiDoc\Model(type=Colllection::class))
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returned when form is invalid"
     * )
     *
     * @param Request $request
     * @param string  $encodedColllectionPath
     *
     * @return JsonResponse
     */
    public function updateColllectionAction(Request $request, string $encodedColllectionPath): JsonResponse
    {
        try {
            $response = $this->colllectionService->update($encodedColllectionPath, $request);
        } catch (FileNotFoundException $exception) {
            throw $this->createNotFoundException('Colllection not found', $exception);
        }

        return $this->json($response);
    }

    /**
     * Delete a Colllection.
     *
     * @Route("/{encodedColllectionPath}", name="delete", methods={"DELETE"})
     *
     * @SWG\Tag(name="Colllections")
     *
     * @SWG\Parameter(
     *     name="encodedColllectionPath",
     *     in="path",
     *     description="Encoded colllection path",
     *     type="string"
     * )
     *
     * @SWG\Response(
     *     response=204,
     *     description="Returned when Colllection file is deleted"
     * )
     *
     * @param string $encodedColllectionPath
     *
     * @return Response
     */
    public function deleteColllectionAction(string $encodedColllectionPath): Response
    {
        $this->colllectionService->delete($encodedColllectionPath);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}