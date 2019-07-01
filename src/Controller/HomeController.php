<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProjectRepository;

//hérite de la classe controller permettant de rendre une vue plutôt que d'injecter le container
class HomeController extends AbstractController{

    /**
    *@Route("/", name="home")
    *@return Response
    *
    */


    public function index(ProjectRepository $repository): Response{
        //Obtenir les derniers projets
        $projects = $repository->findLatest();

        //Dans mon objet vue on aura une methode render
        return $this->render('pages/home.html.twig',
        ['projects' => $projects]); //Page sur laquelle se rendre
    }

}
