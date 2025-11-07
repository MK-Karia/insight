<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $article): void
    {
        $this->_em->persist($article);
        $this->_em->flush();
    }

    public function remove(Article $article): void
    {
        $this->_em->remove($article);
        $this->_em->flush();
    }

    public function findArticle(string $articleId): ?array
    {
        $qb = $this->createQueryBuilder('a')
            ->select([
                'a.articleId AS id',
                'a.title AS title',
                'author AS author',
                'a.createdAt AS createdAt',
                'a.updatedAt AS updatedAt',
                'a.image AS image',
                'a.description AS description',
                'a.content AS content',
                'SUM(CASE WHEN ar.like = true THEN 1 ELSE 0 END) AS likes',
                'SUM(CASE WHEN ar.like = false THEN 1 ELSE 0 END) AS dislikes',
                'COUNT(c.commentId) AS commentsCount',
            ])
            ->leftJoin('a.author', 'author')
            ->leftJoin('App\Entity\ArticleRating', 'ar', 'WITH', 'ar.article = a')
            ->leftJoin('App\Entity\Comment', 'c', 'WITH', 'c.article = a')
            ->andWhere('a.articleId = :id')
            ->setParameter('id', $articleId)
            ->groupBy('a.articleId');

        $result = $qb->getQuery()->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $result ?: null;
    }

    public function findArticleList(): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select([
                'a.articleId AS id',
                'a.title AS title',
                'author AS author',
                'a.createdAt AS createdAt',
                'a.updatedAt AS updatedAt',
                'a.image AS image',
                'a.description AS description',
                'SUM(CASE WHEN ar.like = true THEN 1 ELSE 0 END) AS likes',
                'SUM(CASE WHEN ar.like = false THEN 1 ELSE 0 END) AS dislikes',
                'COUNT(c.commentId) AS commentsCount',
            ])
            ->leftJoin('a.author', 'author')
            ->leftJoin('App\Entity\ArticleRating', 'ar', 'WITH', 'ar.article = a')
            ->leftJoin('App\Entity\Comment', 'c', 'WITH', 'c.article = a')
            ->groupBy('a.articleId');

        return $qb->getQuery()->getArrayResult();
    }
}
