<?php

namespace Mengidd\Disqus;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class DisqusAPI
{

    /**
     * The URL to the Disqus API
     *
     * @var string
     */
    private $url = 'disqus.com/api';

    /**
     * The version of the API we are going to use
     *
     * @var string
     */
    private $apiVersion = '3.0';

    /**
     * If we want to use SSL or not
     *
     * @var bool
     */
    private $useSecure = true;

    /**
     * How many minutes we want to cache data
     *
     * @var int
     */
    private $cache = 0;

    /**
     * The API key for Disqus
     *
     * @var String
     */
    private $apiKey;

    /**
     * The access token for requests that require authentication
     *
     * @var string
     */
    private $accessToken;

    /**
     * The forum we will get posts from
     *
     * @var string
     */
    private $forum;

    /**
     * Holds the parameters that we will send to Disqus
     *
     * @var array
     */
    private $parameters;

    /**
     * The Guzzle Client
     *
     * @var Client
     */
    private $client;

    /**
     * The cache repository
     *
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * DisqusAPI constructor.
     *
     * @param ConfigRepository $config
     */
    public function __construct(ConfigRepository $config, CacheRepository $cacheRepository)
    {
        $this->apiKey = $config['disqus']['secret'];
        $this->accessToken = $config['disqus']['access_token'];
        $this->forum = $config['disqus']['forum'];
        $this->cacheRepository = $cacheRepository;

        $this->client = new Client([
            'base_uri' => ($this->useSecure ? 'https' : 'http') . '://' . $this->url . '/' . $this->apiVersion . '/',
        ]);
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Sets the cache time in minutes
     *
     * @param $minutes
     * @return $this
     */
    public function cache($minutes)
    {
        $this->cache = $minutes;

        return $this;
    }

    /**
     * Send a request to Disqus
     *
     * @param        $resource
     * @param string $method
     *
     * @return Collection
     */
    public function request($resource, $method = 'GET')
    {
        $this->setRequiredParametersIfNotSet();

        // Remove the indexes from array parameters (param[0]=example&param[1]=test into param[]=example&param[]=test)
        $queryParameters = preg_replace('/\%5B\d+\%5D/', '%5B%5D', http_build_query($this->parameters));

        // If cache is set to more than 0 minutes check if we have cached this request
        if ($this->cache > 0) {
            $cacheKey = md5($resource . $queryParameters);

            if ($this->cacheRepository->has($cacheKey)) {
                return $this->cacheRepository->get($cacheKey);
            }
        }

        // Send request to the Disqus endpoint
        $response = $this->client->request($method, $resource . '.json', [
            'query' => $queryParameters
        ]);

        echo 'Request sent';

        $data = json_decode($response->getBody(), true);

        $response = new Collection($data['response']);

        // If cache is set to more than 0 minutes cache the data
        if ($this->cache > 0) {
            $this->cacheRepository->put($cacheKey, $response, $this->cache);
        }

        return $response;
    }

    /**
     * Will set all the required parameters if they aren't manually overwritten
     */
    private function setRequiredParametersIfNotSet()
    {
        if (!isset($this->parameters['api_secret'])) {
            $this->parameters['api_secret'] = $this->apiKey;
        }

        if (!isset($this->parameters['forum'])) {
            $this->parameters['forum'] = $this->forum;
        }
    }
}
