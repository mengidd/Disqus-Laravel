<?php

namespace Mengidd\Disqus;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
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
     * DisqusAPI constructor.
     *
     * @param ConfigRepository $config
     */
    public function __construct(ConfigRepository $config)
    {
        $this->apiKey = $config['disqus']['secret'];
        $this->accessToken = $config['disqus']['access_token'];
        $this->forum = $config['disqus']['forum'];

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

        $response = $this->client->request($method, $resource . '.json', [
            'query' => $queryParameters
        ]);

        $data = json_decode($response->getBody(), true);

        $response = new Collection($data['response']);

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