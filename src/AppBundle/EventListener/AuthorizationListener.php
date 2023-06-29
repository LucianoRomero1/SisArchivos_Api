<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Base\BaseController;
use AppBundle\Handlers\LoginHandler as HandlersLoginHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

//Este archivo es super importante, es un listener que está todo el tiempo pendiente de mis controladores revisando si está o no el auth, excepto el login
class AuthorizationListener
{
    private $loginHandler;
    private $loginRoute;

    public function __construct(HandlersLoginHandler $loginHandler, string $loginRoute)
    {
        $this->loginHandler = $loginHandler;
        $this->loginRoute = $loginRoute;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        // Verificar si el controlador es una instancia de tu controlador base
        if (is_array($controller) && $controller[0] instanceof BaseController) {
            $request = $event->getRequest();

            // Obtener la ruta actual de la solicitud
            $currentRoute = $request->attributes->get('_route');

            // Verificar si la ruta actual es la ruta de inicio de sesión
            if ($currentRoute !== $this->loginRoute) {
                $authorizationHeader = $request->headers->get('Authorization');

                try {
                    $authCheck = $this->loginHandler->validateAuthorization($authorizationHeader);
                    if (!$authCheck) {
                        $response = new JsonResponse('No autorizado', JsonResponse::HTTP_UNAUTHORIZED);
                        $event->setController(function () use ($response) {
                            return $response;
                        });
                    }
                } catch (\Exception $e) {
                    $response = new JsonResponse($e->getMessage(), JsonResponse::HTTP_UNAUTHORIZED);
                    $response->setData([
                        "status"    => 'error',
                        "code"      => 401,
                        "message"   => $e->getMessage()
                    ]);
                    $event->setController(function () use ($response) {
                        return $response;
                    });
                }
            }
        }
    }
}
