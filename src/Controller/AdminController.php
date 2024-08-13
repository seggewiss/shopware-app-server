<?php declare(strict_types=1);

namespace Segge\AppServer\Controller;

use Segge\AppServer\Entity\ShopEntity;
use Segge\AppServer\Framework\Request\ShopResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class AdminController extends AbstractController
{
    #[Route(
        path: '/admin-sdk',
        name: 'segge.admin-sdk',
        methods: [Request::METHOD_GET]
    )]
    public function adminSdk(SessionInterface $session, ShopEntity $shop): Response
    {
        $session->set(ShopResolver::SHOP_ID, $shop->getShopId());

        $cookie = Cookie::create(\session_name())
            ->withValue(\session_id())
            ->withSameSite(Cookie::SAMESITE_NONE)
            ->withSecure()
            ->withPartitioned();

        $response = $this->render('admin-sdk.html.twig');
        $response->headers->setCookie($cookie);

        return $response;
    }

    #[Route(
        path: '/promotion-module',
        name: 'segge.promotion-module',
        methods: [Request::METHOD_GET]
    )]
    public function promotionModule(SessionInterface $session, ShopEntity $shop): Response
    {
        $session->set(ShopResolver::SHOP_ID, $shop->getShopId());

        $cookie = Cookie::create(\session_name())
            ->withValue(\session_id())
            ->withSameSite(Cookie::SAMESITE_NONE)
            ->withSecure()
            ->withPartitioned();

        $response = $this->render('promotion-module.html.twig');
        $response->headers->setCookie($cookie);

        return $response;
    }
}
