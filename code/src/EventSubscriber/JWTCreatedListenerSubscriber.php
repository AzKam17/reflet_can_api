<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JWTCreatedListenerSubscriber implements EventSubscriberInterface
{

    public function onLexikJwtAuthenticationOnJwtCreated(JWTCreatedEvent $event): void
    {
        /**
         * @var User $user
         */
        $user = $event->getUser();
        $payload = $event->getData();
        // On ajoute le mail
        $payload['nom'] = $user->getNom();
        $payload['score_points'] = $user->getScorePoints();
        // On retire les roles et le username pour l'appli
        unset($payload['roles']);
        unset($payload['username']);
        $event->setData($payload);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onLexikJwtAuthenticationOnJwtCreated',
        ];
    }
}
