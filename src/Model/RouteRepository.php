<?php
namespace Slug\Model;

use Boxspaced\EntityManager\EntityManager;
use Boxspaced\EntityManager\Collection\Collection;

class RouteRepository
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $id
     * @return Route
     */
    public function getById($id)
    {
        return $this->entityManager->find(Route::class, $id);
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return $this->entityManager->findAll(Route::class);
    }

    /**
     * @param string $slug
     * @return Route
     */
    public function getBySlug($slug)
    {
        $conditions = $this->entityManager->createConditions();
        $conditions->field('slug')->eq($slug);
        return $this->entityManager->findOne(Route::class, $conditions);
    }

    /**
     * @param Route $entity
     * @return RouteRepository
     */
    public function delete(Route $entity)
    {
        $this->entityManager->delete($entity);
        return $this;
    }

}
