<?php
declare(strict_types=1);

namespace CBH\UiscomClient;

use CBH\UiscomClient\Configuration\ConfigurationInterface;
use CBH\UiscomClient\Exceptions\RequestException;
use CBH\UiscomClient\Traits\LoggerAwareTrait;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;

/**
 * Class ApiClient
 */
class ApiClient
{
    use LoggerAwareTrait;

    public const METHOD_POST = 'POST';

    public const METHOD_GET = 'GET';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var ConfigurationInterface
     */
    private $config;

    /**
     * ApiClient constructor.
     *
     * @param ConfigurationInterface $configuration
     * @param ClientInterface $client
     * @param null|LoggerInterface $logger
     */
    public function __construct(ConfigurationInterface $configuration,
                                ClientInterface $client,
                                LoggerInterface $logger = null)
    {
        $this->config = $configuration;
        $this->httpClient = $client;
        $this->setLogger($logger);
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfig(): ConfigurationInterface
    {
        return $this->config;
    }

    /**
     * @throws RequestException
     */
    public function startScenarioCall()
    {
        $this->makeRequest(self::METHOD_GET, '');
    }

    /**
     * @param string $method
     * @param string $uri
     *
     * @throws RequestException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function makeRequest(string $method, string $uri): \Psr\Http\Message\ResponseInterface
    {
        try {
            $this->getLogger()->info("Making request: method [{$method}], uri [{$uri}]");
            return $this->httpClient->request($method, $uri, [
                RequestOptions::CONNECT_TIMEOUT => $this->config->getConnectionTimeout(),
            ]);
        } catch (GuzzleException $e) {
            $this->getLogger()->error($e->getMessage());
            throw new RequestException('Error when trying request', 0, $e);
        } catch (\Throwable $t) {
            $this->getLogger()->critical($t->getMessage());
            throw new RequestException('Critical error when trying request', 0, $t);
        }
    }
}
