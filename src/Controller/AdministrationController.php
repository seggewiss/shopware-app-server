<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
    #[Route(
        path: '/admin-sdk',
        name: 'admin-sdk'
    )]
    public function administrationJs(): Response
    {
        return $this->render('admin-sdk.html.twig');
    }
}
