<?php namespace Mobiniti\Api;

use GuzzleHttp\Client as HttpClient;
use Mobiniti\Api\Exceptions\Http\ForbiddenException;
use Mobiniti\Api\Exceptions\Http\InternalServerErrorException;
use Mobiniti\Api\Exceptions\Http\NotFoundException;
use Mobiniti\Api\Exceptions\Http\BadRequestException;
use Mobiniti\Api\Exceptions\Http\RateLimitException;
use Mobiniti\Api\Exceptions\Http\ServiceUnavailableException;
use Mobiniti\Api\Exceptions\Http\UnauthorizedException;
use Mobiniti\Api\Exceptions\Http\PaymentRequiredException;
use Mobiniti\Api\Exceptions\Http\MethodNotAllowedException;
use Mobiniti\Api\Exceptions\Http\UnprocessableEntityException;
use Mobiniti\Api\Exceptions\MobinitiException;

class Http
{

    protected $client;

    protected $http;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->http = new HttpClient([
            'http_errors' => false,
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }

    /**
     * Make a GET request
     *
     * @param string $uri
     * @param array $params
     * @return mixed
     * @throws BadRequestException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws PaymentRequiredException
     * @throws UnauthorizedException
     * @throws UnprocessableEntityException
     */
    public function get($uri, $params = [])
    {
        return $this->request($uri, 'GET', [], $params);
    }

    /**
     * Make a POST request
     *
     * @param $uri
     * @param array $body
     * @return mixed
     * @throws BadRequestException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws PaymentRequiredException
     * @throws UnauthorizedException
     * @throws UnprocessableEntityException
     */
    public function post($uri, array $body)
    {
        return $this->request($uri, 'POST', $body);
    }

    /**
     * Make a PUT request
     *
     * @param $uri
     * @param array $body
     * @return mixed
     * @throws BadRequestException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws PaymentRequiredException
     * @throws UnauthorizedException
     * @throws UnprocessableEntityException
     */
    public function put($uri, array $body)
    {
        return $this->request($uri, 'PUT', $body);
    }

    /**
     * Make a DELETE request
     *
     * @param $uri
     * @return mixed
     * @throws BadRequestException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws PaymentRequiredException
     * @throws UnauthorizedException
     * @throws UnprocessableEntityException
     */
    public function delete($uri)
    {
        return $this->request($uri, 'DELETE');
    }

    private function request($uri, $method, array $body = [], array $query = [])
    {
        if (!$this->client->getAccessToken()) {
            throw new \InvalidArgumentException("The access_token cannot be empty.");
        }

        $url = "{$this->client->getApiUrl()}/{$this->client->getApiVersion()}/{$uri}";

        $response = $this->http->request($method, $url, [
                'headers' => ['Authorization' => "Bearer {$this->client->getAccessToken()}"],
                'query' => $query,
                'json' => $body,
            ]
        );

        $this->client->setDebug($response->getHeader('X-Request-Id'));

        if (in_array($response->getStatusCode(), range(200, 299))) {
            return json_decode($response->getBody()->getContents(), ($this->client->getReturnType() == 'object' ? false : true));
        } else {
            $json = json_decode($response->getBody()->getContents());

            switch ($response->getStatusCode()) {
                case '400':
                    throw new BadRequestException($json->message, $json->status, null,
                        isset($json->errors) ? $json->errors : []);

                    break;
                case '401':
                    if (isset($json->error) && $json->error == 'access_denied') {
                        $status = 403;
                        $message = 'The server denied the request.';
                    } else {
                        $status = 401;
                        $message = $json->message;
                    }

                    throw new UnauthorizedException($message, $status, null, isset($json->errors) ? $json->errors : []);

                    break;
                case '402':
                    throw new PaymentRequiredException($json->message, 402);

                    break;
                case '403':
                    throw new ForbiddenException('Forbidden', 403);

                    break;
                case '404':
                    throw new NotFoundException('Not Found', 404);

                    break;
                case '405':
                    throw new MethodNotAllowedException($json->message, 405);

                    break;
                case '422':
                    throw new UnprocessableEntityException($json->message, $json->status, null,
                        isset($json->errors) ? $json->errors : []);

                    break;
                case '429':
                    throw new RateLimitException('Too Many Requests', 429);

                    break;
                case '500':
                    throw new InternalServerErrorException('Internal Server Error', 500);

                    break;
                case '503':
                    throw new ServiceUnavailableException('Service Unavailable', 503);

                    break;
                case '504':
                    throw new GatewayTimeoutException('Service Unavailable', 503);

                    break;
                default:
                    Throw new MobinitiException('Not Implemented', 501);
            }
        }
    }

    public function getLastRequestId()
    {
        return $this->lastRequestId;
    }

}