<?php

namespace App\Repository;

use App\Entity\PostReaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostReaction>
 *
 * @method PostReaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostReaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostReaction[]    findAll()
 * @method PostReaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostReaction::class);
    }
    
    public function getReactionCounts($postId)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r.type, COUNT(r.id) as count')
            ->leftJoin('r.postId', 'p')
            ->where('p.id = :postId')
            ->groupBy('r.type')
            ->setParameter('postId', $postId);

        $result = $qb->getQuery()->getResult();

        $reactionCounts = [];
        foreach ($result as $row) {
            $reactionCounts[$row['type']] = $row['count'];
        }

        return $reactionCounts;
    }
    

//    /**
//     * @return PostReaction[] Returns an array of PostReaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PostReaction
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
