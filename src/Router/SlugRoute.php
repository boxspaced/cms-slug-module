<?php
namespace Boxspaced\CmsSlugModule\Router;

use Traversable;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Router\Exception;
use Zend\Router\Http\RouteMatch;
use Zend\Router\Http\RouteInterface;
use Zend\Filter\StaticFilter;
use Zend\Filter\Word\DashToCamelCase;
use Boxspaced\CmsSlugModule\Model;

class SlugRoute implements RouteInterface
{

    /**
     * @var Model\RouteRepository
     */
    protected $routeRepository;

    /**
     * @var array
     */
    protected $defaults;

    /**
     * @param Model\RouteRepository $routeRepository
     * @param array $defaults
     */
    public function __construct(Model\RouteRepository $routeRepository, array $defaults = [])
    {
        $this->routeRepository = $routeRepository;
        $this->defaults = $defaults;
    }

    /**
     * @param mixed $options
     * @return ContentRoute
     * @throws Exception\InvalidArgumentException
     */
    public static function factory($options = [])
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Traversable set of options',
                __METHOD__
            ));
        }

        if (!isset($options['route_repository'])) {
            throw new Exception\InvalidArgumentException('Missing "route_repository" in options array');
        }

        if (!isset($options['defaults'])) {
            $options['defaults'] = [];
        }

        return new static($options['route_repository'], $options['defaults']);
    }

    /**
     * @param Request $request
     * @param int $pathOffset
     * @return RouteMatch
     */
    public function match(Request $request)
    {
        if (!method_exists($request, 'getUri')) {
            return null;
        }

        $requestedPath = $request->getUri()->getPath();

        $slug = ltrim($requestedPath, '/');

        if (!$slug) {
            $slug = $this->defaults['slug'];
        }

        // @todo caching
        //$routes = $container->get('Cache\Long')->getItem(static::ROUTES_CACHE_ID);

        $route = $this->routeRepository->getBySlug($slug);

        if (null !== $route) {

            $module = $route->getModule();

            $controller = str_replace(
                '##',
                StaticFilter::execute($module->getRouteController(), DashToCamelCase::class),
                // @todo get from config controller aliases?
                '##\\Controller\\##Controller'
            );

            $params = [
                'controller' => $controller,
                'action' => $route->getIdentifier(),
            ];

            if ($module->getRouteAction()) {
                $params['action'] = $module->getRouteAction();
                $params['id'] = (int) $route->getIdentifier();
            }

            return new RouteMatch($params, strlen($requestedPath));
        }

        return null;
    }

    /**
     * @param array $params
     * @param array $options
     * @return string
     */
    public function assemble(array $params = [], array $options = [])
    {
        return '/' . $params['slug'];
    }

    /**
     * @return array
     */
    public function getAssembledParams()
    {
        return ['slug'];
    }

}
