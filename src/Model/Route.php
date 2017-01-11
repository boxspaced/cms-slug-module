<?php
namespace Boxspaced\CmsSlugModule\Model;

use Boxspaced\EntityManager\Entity\AbstractEntity;
use Boxspaced\CmsCoreModule\Model\Module;

class Route extends AbstractEntity
{

    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * @param int $id
     * @return Route
     */
    public function setId($id)
    {
        $this->set('id', $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->get('slug');
    }

    /**
     * @param string $slug
     * @return Route
     */
    public function setSlug($slug)
    {
        $this->set('slug', $slug);
		return $this;
    }

    /**
     * @return Module
     */
    public function getModule()
    {
        return $this->get('module');
    }

    /**
     * @param Module $module
     * @return Route
     */
    public function setModule(Module $module)
    {
        $this->set('module', $module);
		return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->get('identifier');
    }

    /**
     * @param string $identifier
     * @return Route
     */
    public function setIdentifier($identifier)
    {
        $this->set('identifier', $identifier);
		return $this;
    }

}
