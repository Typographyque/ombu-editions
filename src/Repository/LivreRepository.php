<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Livre::class);
    }


    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */

    public function findOneRandom()
    {
        $rsm = new ResultSetMappingBuilder(
            $this->getEntityManager()
        );

        $rsm->addRootEntityFromClassMetadata(Livre::class, 'livre');

        $sql = "SELECT * FROM livre ORDER BY RAND() LIMIT 1";

        return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getOneOrNullResult();
    }

    public function findLasted()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
