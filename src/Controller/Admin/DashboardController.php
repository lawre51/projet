<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Materiel;
use App\Entity\Intervention;


use App\Service\ServiceEvent;
use App\Entity\InterventionUser;
use App\Controller\ProfileController;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{

    
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        // return parent::index();
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //  if ('jane' === $this->getUser()->getUsername()) {
        //    return $this->redirect('...');
        //}

        
        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard')
            ->setFaviconPath('favicon.svg')
            //->renderContentMaximized()
            ->disableDarkMode()
            ->generateRelativeUrls();
           
    }

    
    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Accueil', 'fas fa-home' );
        yield MenuItem::linkToRoute('Administration', 'fas fa-home ', 'admin');
        

        if ('ROLE_SUPER_ADMIN' == $this->getUser()->getRoles()[0]) {
            yield MenuItem::linkToCrud('Salariés', 'fas fa-users', User::class)->setDefaultSort(['nom' => 'ASC']);
        }
        yield MenuItem::linkToCrud('Intervention', 'fas fa-tools', Intervention::class);
        yield MenuItem::linkToCrud('Matériel', 'fas fa-industry', Materiel::class);
       
        
           
        
    }




    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getprenom() )
            // use this method if you don't want to display the name of the user
            ->displayUserName(false)

            
            // you can also pass an email address to use gravatar's service
            ->setGravatarEmail($user->getemail())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                
                MenuItem::section(),
                
            ]);
    }

    

}


