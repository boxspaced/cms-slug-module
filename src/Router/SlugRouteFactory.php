<?php
namespace Boxspaced\CmsSlugModule\Router;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Boxspaced\CmsSlugModule\Model;

class SlugRouteFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (!isset($options['defaults'])) {
            $options['defaults'] = [];
        }

        return new SlugRoute($container->get(Model\RouteRepository::class), $options['defaults']);
    }

}
