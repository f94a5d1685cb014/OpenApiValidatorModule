<?php

declare(strict_types=1);

namespace Codeception\Module;

use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Exception;
use GuzzleHttp\Client as HttpClient;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ResponseValidator;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Psr\Http\Message\ResponseInterface;

class OpenApiValidator extends Module
{
    protected ResponseValidator $validator;
    protected HttpClient $httpClient;

    public function _beforeSuite($settings = [])
    {
        $this->validator = (new ValidatorBuilder)
            ->fromJson(file_get_contents($this->getSchemaUrl()))
            ->getResponseValidator();
        $this->httpClient = new HttpClient($this->getHttpClientConfig());
    }

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
    }

    /**
     * @throws Exception
     */
    public function validateResponse(string $path, string $method, ResponseInterface $response)
    {
        $operationAddress = new OperationAddress($path, $method);
        $this->validator->validate($operationAddress, $response);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(string $method, string $path, array $params)
    {
        return $this->httpClient->request($method, $this->getCallableUrl($path), $params);
    }

    public function getCallableUrl(string $path): string
    {
        return $this->config['host'] . $path;
    }

    public function getSchemaUrl(): string
    {
        return $this->config['host'] . '/' . $this->config['swagger-file'];
    }

    public function getHttpClientConfig() : array
    {
        return [
            'auth'=> [$this->config['username'], $this->config['password']],
            'headers' => [
                'content' => $this->config['content'],
                'content-type' => $this->config['contentType']
            ]
        ];
    }
}
