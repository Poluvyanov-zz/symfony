<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use App\Serializer\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * Brand controller.
 *
 * @Route("/api")
 */
class UsersController extends AbstractController
{

    private $formErrorSerializer;

    public function __construct(FormErrorSerializer $formErrorSerializer)
    {
        $this->formErrorSerializer = $formErrorSerializer;
    }

    /**
     * Lists all Users.
     * @FOSRest\Get("/users")
     *
     */
    public function index(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(Users::class)->findAllArray();



        return $this->json([
            'message' => 'List of users',
            'data' => $users,
        ],Response::HTTP_ACCEPTED, []);
    }

    /**
     * Save user.
     * @FOSRest\Post("/user/save")
     */
    public function save(Request $request)
    {

        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json([
                'message' => 'User created!',
            ], Response::HTTP_CREATED, []);
        }


        return $this->json([
            'message' => 'User not created!',
            'errors' => $this->formErrorSerializer->convertFormToArray($form),
        ], Response::HTTP_BAD_REQUEST, []);


    }
}
