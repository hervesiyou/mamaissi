<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class IndexController extends AbstractController{

    public function __construct(
        private EntityManagerInterface $em, 
        // private CoreService $core,
        private RequestStack $session
    ) {  
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response  {
        return $this->render('base.html.twig', [
            'controller_name' => ' ',
        ]);
    }

    #[Route(path: '/logad', name: 'app_aspro_login')]
    public function admlogin( Request $request ): Response  {

        if ($request->isMethod('POST')) {
            
            $email = $request->request->get('email');
            $pwd = $request->request->get('pwd');            
            
            if( $email == "HERVE" && $pwd == "herve" ){

                $iduser = $this->session->getSession()->set("IDEADM", "Edu Hervé"); 
                return $this->redirectToRoute("admin");

            }else{
                // $message = "Utilisateur inexistant !";                
            }
        } 

        return $this->render('admin/logineadmin.html.twig', [
            //"message" => $message,
        ]);
    }
}
