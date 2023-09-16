<?php

namespace App\Service\Auth;

use App\Entity\User;
use App\Helpers\SlugFromEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InscriptionService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private SlugFromEmail $slugFromEmail,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validatorInterface
    )
    {}

    public function __invoke(
        string $nom,
        string $email,
        string $password
    ){
        return 'dwed - ' . $nom;
    }

    public function createUser(
        string $nom,
        string $email,
        string $password
    ) : array
    {
        $user = (new User())
        ->setEmail($email)
        ->setSlug(($this->slugFromEmail)(
            email: $email
        ))
        ->setRoles(['ROLE_USER'])
        ->setNom($nom);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $errors = $this->validatorInterface->validate($user);
        if(count($errors) > 0){
            $result = [];
            foreach ($errors as $error) {
                if($error->getMessage() === "This value should be of type array|IteratorAggregate."){
                    continue;
                }
                $result[] = $error->getMessage();
            }
            if(count($result) === 1){
                return ['data' => $result, 'code' => Response::HTTP_UNPROCESSABLE_ENTITY];
            }
            
        }
        $this->manager->persist($user);
        $this->manager->flush();
        return ['data' => $user->__toArray(), 'code' => Response::HTTP_OK];
    }
}
