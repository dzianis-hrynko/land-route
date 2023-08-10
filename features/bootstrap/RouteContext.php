<?php

use App\Service\RouteService;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Imbo\BehatApiExtension\Context\ApiContext;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Defines application features from the specific context.
 */
class RouteContext extends ApiContext implements Context
{

    /**
     * Send API request using params of authorization from AuthContext
     * Using only for API requests from feature
     *
     * @When I send request :path
     * @When I send request :path using HTTP :method
     *
     * @param string $path
     * @param string $method
     *
     * @return ApiContext
     */
    public function iSendRequestUsingHTTPGET(string $path, string $method): ApiContext
    {
        return $this->requestPath($path, $method);
    }
}
