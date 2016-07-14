<?php

namespace Mengidd\Disqus\Resources;

use Mengidd\Disqus\DisqusAPI;
use Illuminate\Contracts\Config\Repository;

abstract class Resource
{
    /**
     * Holds the parameters that we will pass on to Disqus
     * @var array
     */
    protected $parameters = [];

    /**
     * @var DisqusAPI
     */
    protected $api;

    /**
     * Threads constructor.
     *
     */
    public function __construct()
    {
        $config = app(Repository::class);
        $this->api = new DisqusAPI($config);
    }

    /**
     * Will return entries
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        // Convert class name to Disqus resource (ie. PostsList -> posts/list)
        $classParts = explode('\\', get_class($this));
        $className = $classParts[count($classParts) - 1];
        $resource = snake_case($className, '/');

        $result = $this->api->setParameters($this->parameters)->request($resource);

        return $result;
    }
}
