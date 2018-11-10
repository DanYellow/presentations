<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findByFirstNameOrLastName($params = [])
    {
        $em = $this->getEntityManager();
        $queryParams = [
            'lastName' => '%' . $params['lastName'] . '%',
            'firstName' => '%' . $params['firstName'] . "%"
        ];

        $dql = 'SELECT a FROM App\Entity\Author a WHERE';

        
        // getEntityManager()
        //     ->getRepository('App\Entity\Author')
        //     ->createQueryBuilder('o');



        if(empty($params['firstName']))
        {
            unset($queryParams['firstName']);
        } else {
            $dql .= ' a.firstName LIKE :firstName';
            // $query->andWhere('o.firstName LIKE :firstName');
        }

        if(!empty($params['firstName']) && !empty($params['lastName'])) {
            $dql .= ' AND';
        }

        if(empty($params['lastName'])) {
            unset($queryParams['lastName']);
        } else {
            $dql .= ' a.lastName LIKE :lastName';
            // $query->andWhere('o.firstName LIKE :firstName');
        }

        // if(empty($params['lastName'])) {
        //     unset($queryParams['lastName']);
        // } else {
        //     $query->andWhere('o.lastName LIKE :lastName');
        // }
        // throw new \Exception(http_build_query($queryParams));
        $query = $em->createQuery($dql);
        $query->setParameters($queryParams)
            ->getResult();
            // ->getQuery()

        return $query;
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
