<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\Security\InvalidCredentialsException;
use App\Exception\Security\UserNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Login
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param string $email
     * @param string $password
     * @return string
     */
    public function getUserToken(string $email, string $password): string
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->findOneBy(['email' => $email]);

        // Email not found
        if (null === $user) {
            throw new UserNotFoundException();
        }

        // Password not valid
        $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $password);
        if (false === $isPasswordValid) {
            throw new InvalidCredentialsException();
        }

        // Return the token
        return $user->getToken();
    }
}
