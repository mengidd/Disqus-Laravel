<?php

namespace Mengidd\Disqus\Resources;

use Mengidd\Disqus\DisqusAPI;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

abstract class Resource
{
    /**
     * Holds the parameters that we will pass on to Disqus
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * @var DisqusAPI
     */
    protected $api;

    /**
     * How many minutes we will cache the data
     *
     * @var int
     */
    protected $cache = 0;

    /**
     * Threads constructor.
     *
     */
    public function __construct()
    {
        $config = app(ConfigRepository::class);
        $cache = app(CacheRepository::class);

        $this->api = new DisqusAPI($config, $cache);
    }

    /**
     * Sets the cache time in minutes
     *
     * @param int $minutes
     * @return $this
     */
    public function cache($minutes)
    {
        $this->cache = $minutes;

        return $this;
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

        $result = $this->api
            ->setParameters($this->parameters)
            ->cache($this->cache)
            ->request($resource);

        return $result;
    }
}
