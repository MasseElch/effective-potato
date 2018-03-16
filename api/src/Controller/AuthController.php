<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @Route("/auth")
 */
class AuthController extends Controller
{
    /**
     * @Rest\Post("/token")
     *
     * @param Request $request
     * @param EncoderFactoryInterface $encoderFactory
     * @param JWTTokenManagerInterface $jwtManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function token(Request $request, EncoderFactoryInterface $encoderFactory, JWTTokenManagerInterface $jwtManager)
    {
        $user = $this->get('doctrine')
            ->getRepository(User::class)
            ->findOneBy(['email' => $request->request->get('email')]);
        $presentedPassword = $request->request->get('password');

        if ($user && $user->isEnabled()) {
            $encoder = $encoderFactory->getEncoder($user);
            $valid = $encoder->isPasswordValid($user->getPassword(), $presentedPassword, $user->getSalt());
            if ($valid) {
                $token = $jwtManager->create($user);
                return $this->json(compact('token'));
            }
        }

        $message = $this->get('translator')->trans('security.bad_credentials');
        return $this->json(compact('message'), 401);
    }
}