<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1')]
class TestController extends AbstractController
{

    public const USERS_DATA = [
        [
            'id'    => '1',
            'email' => 'ipz233_saye@student.ztu.edu.ua',
            'full_name'  => 'Anna Svintsitska'
        ],
        [
            'id'    => '2',
            'email' => 'alpha2@example.com',
            'full_name'  => 'Bob Smith'
        ],
        [
            'id'    => '3',
            'email' => 'alpha3@example.com',
            'full_name'  => 'Charlie Johnson'
        ],
        [
            'id' => '4',
            'email'   => 'alpha4@example.com',
            'full_name'  => 'Diana White'
        ],
        [
            'id' => '5',
            'email'   => 'alpha5@example.com',
            'full_name'  => 'Ethan Davis'
        ],
        [
            'id' => '6',
            'email'   => 'alpha6@example.com',
            'full_name'  => 'Fiona Wilson'
        ],
        [
            'id' => '7',
            'email'  => 'alpha7@example.com',
            'full_name'  => 'George Martinez'
        ],
    ];

    #[Route('/users', name: 'app_collection_users', methods: ['GET'])]
    public function getCollection(): JsonResponse
    {
        return new JsonResponse([
            'data' => self::USERS_DATA
        ], Response::HTTP_OK);
    }

    #[Route('/users/{id}', name: 'app_item_users', methods: ['GET'])]
    public function getItem(string $id): JsonResponse
    {
        $userData = $this->findUserById($id);

        return new JsonResponse([
            'data' => $userData
        ], Response::HTTP_OK);
    }

    #[Route('/users', name: 'app_create_users', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function createItem(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['email'], $requestData['full_name'])) {
            throw new UnprocessableEntityHttpException("full name and email are required");
        }

        // TODO check by regex

        $countOfUsers = count(self::USERS_DATA);

        $newUser = [
            'id'    => $countOfUsers + 1,
            'full_name'  => $requestData['full_name'],
            'email' => $requestData['email']
        ];

        // TODO add new user to collection

        return new JsonResponse([
            'data' => $newUser
        ], Response::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'app_delete_users', methods: ['DELETE'])]
    #[IsGranted("ROLE_ADMIN")]
    public function deleteItem(string $id): JsonResponse
    {
        $this->findUserById($id);

        // TODO remove user from collection

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    #[Route('/users/{id}', name: 'app_update_users', methods: ['PATCH'])]
    public function updateItem(string $id, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['full_name'])) {
            throw new UnprocessableEntityHttpException("full name is required");
        }

        $userData = $this->findUserById($id);

        // TODO update user name

        $userData['full_name'] = $requestData['full_name'];

        return new JsonResponse(['data' => $userData], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return string[]
     */
    public function findUserById(string $id): array
    {
        $userData = null;

        foreach (self::USERS_DATA as $user) {
            if (!isset($user['id'])) {
                continue;
            }

            if ($user['id'] == $id) {
                $userData = $user;

                break;
            }

        }

        if (!$userData) {
            throw new NotFoundHttpException("User with id " . $id . " not found");
        }

        return $userData;
    }

}
