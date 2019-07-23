<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use App\Entity\ProjectSearch;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
    *@return Query
    *
    */
    public function findAllVisibleQuery(ProjectSearch $search) : Query {
        $query = $this->findVisibleQuery();

            if($search->getMaxArea()){
                $query = $query
                ->andWhere('p.area < :maxarea' )
                ->setParameter('maxarea', $search->getMaxArea());
            }

            if($search->getMinSurface()){
                $query = $query
                ->andWhere('p.surface >= :minsurface' )
                ->setParameter('minsurface', $search->getMinSurface());
            }

            //récupérer la requete
            return $query->getQuery();
           
    }

    /**
     * @return Project[]
     */
    public function findLatest() : array {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            //->where('p.terminé = false')
            //récupérer la requete
            ->getQuery()
            //récupérer le résultat
            ->getResult();
    }



    private function findVisibleQuery() : DoctrineQueryBuilder{
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC');
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

}