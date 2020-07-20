<?php

namespace App\Controller;

use App\Exception\Security\InvalidCredentialsException;
use App\Exception\Security\UserNotFoundException;
use App\Service\Login;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class LoginController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/login")
     * @param Request $request
     * @param Login $loginService
     * @return View
     */
    public function loginAction(Request $request, Login $loginService): View
    {
        $email = $request->request->get('email');
        if (null === $email) {
            return $this->view(['email' => 'Missing field'], Response::HTTP_BAD_REQUEST);
        }

        $password = $request->request->get('password');
        if (null === $password) {
            return $this->view(['password' => 'Missing field'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $userToken = $loginService->getUserToken($email, $password);
        } catch (UserNotFoundException $e) {
            return $this->view(['email' => 'User not found'], $e->getCode());
        } catch (InvalidCredentialsException $e) {
            return $this->view(['email' => 'Invalid credentials'], $e->getCode());
        }

        return $this->view(['token' => $userToken], Response::HTTP_OK);
    }
}
