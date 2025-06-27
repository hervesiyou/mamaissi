<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Entity\CommandeExames;
use App\Entity\Consultations;
use App\Entity\Contacts;
use App\Entity\Dossiermedical;
use App\Entity\Entretiens;
use App\Entity\ExamenPrix;
use App\Entity\Examens;
use App\Entity\Patients;
use App\Entity\Personnels;
use App\Entity\Programmes;
use App\Entity\Rendezvous;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


#[AdminDashboard(routePath: '/idm', routeName: 'admin')]
class DashboardController extends AbstractDashboardController{

    public function __construct(
        private EntityManagerInterface $em, 
        private RequestStack $session
    ) {  
    }

    public function index(): Response    {

        $iduser = $this->session->getSession()->get("IDEADM"); 
        if ($iduser == "Edu Hervé") { 

            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(PatientsCrudController::class)->generateUrl());

        } 
        return $this->redirectToRoute("app_aspro_login"); 
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController( PatientsCrudController::class)->generateUrl());
 
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard {
        return Dashboard::new()
            ->setTitle('IPOCRATE - Gestion Application de Suivi des Patients');
    }

    public function configureMenuItems(): iterable  {
        return [
             
              MenuItem::linkToDashboard('Accueil', 'fa fa-home'),
                MenuItem::section('Gestion des Utilisateurs'),
                MenuItem::linkToCrud('Personnels de Santé', 'fa fa-users', Personnels::class),
                MenuItem::linkToCrud('Patients', 'fa fa-gift', Patients::class),

                 MenuItem::section('Gestion des Examens'),
                MenuItem::linkToCrud('Examens ', 'fa fa-cog', Examens::class),
                MenuItem::linkToCrud('Prix des Examens ', 'fa fa-cog', ExamenPrix::class),
                MenuItem::linkToCrud('Rendez vous ', 'fa fa-cog', Rendezvous::class),
                MenuItem::linkToCrud('Consultations ', 'fa fa-cog', Consultations::class),

                 MenuItem::section('Gestion des Suivis'),
                MenuItem::linkToCrud('Programmes de suivis ', 'fa fa-cog', Programmes::class),
                MenuItem::linkToCrud('Conseils ', 'fa fa-cog', Annonces::class),
                MenuItem::linkToCrud('Contacts ', 'fa fa-cog', Contacts::class),
                MenuItem::linkToCrud('Dossier medical ', 'fa fa-cog', Dossiermedical::class),
                MenuItem::linkToCrud('Entretiens personnalisés ', 'fa fa-cog', Entretiens::class),
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        ];
    }
}
