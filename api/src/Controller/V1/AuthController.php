<?php

namespace App\Controller\V1;

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
    private $encoderFactory;
    private $jwtManager;

    public function __construct(EncoderFactoryInterface $encoderFactory, JWTTokenManagerInterface $jwtManager)
    {
        $this->encoderFactory = $encoderFactory;
        $this->jwtManager = $jwtManager;
    }

    /**
     * @Rest\Post("/token")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function token(Request $request)
    {
        $user = $this->get('doctrine')
            ->getRepository(User::class)
            ->findOneBy(['email' => $request->request->get('email')]);
        $presentedPassword = $request->request->get('password');

        if ($user && $user->isEnabled()) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $valid = $encoder->isPasswordValid($user->getPassword(), $presentedPassword, $user->getSalt());
            if ($valid) {
                $token = $this->jwtManager->create($user);
                return $this->json(compact('token'));
            }
        }

        $message = $this->get('translator')->trans('security.bad_credentials');
        return $this->json(compact('message'), 401);
    }
}