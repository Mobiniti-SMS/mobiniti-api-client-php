<?php namespace Mobiniti\Api;

use GuzzleHttp\Client as HttpClient;
use Mobiniti\Api\Exceptions\Http\NotFoundException;
use Mobiniti\Api\Exceptions\Http\BadRequestException;
use Mobiniti\Api\Exceptions\Http\UnauthorizedException;
use Mobiniti\Api\Exceptions\Http\PaymentRequiredException;
use Mobiniti\Api\Exceptions\Http\MethodNotAllowedException;
use Mobiniti\Api\Exceptions\Http\UnprocessableEntityException;

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
            'defaults' => ['exceptions' => false],
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

        $request = $this->http->createRequest($method, $url, [
                'headers' => ['Authorization' => "Bearer {$this->client->getAccessToken()}"],
                'query' => $query,
                'json' => $body,
            ]
        );

        $response = $this->http->send($request);

        if (in_array($response->getStatusCode(), range(200, 299))) {
            return $response->json(['object' => ($this->client->getReturnType() == 'object' ? true : false)]);
        } else {
            $json = $response->json(['object' => true]);

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
                case '404':
                    throw new NotFoundException($json->message, 404);

                    break;
                case '405':
                    throw new MethodNotAllowedException($json->message, 405);

                    break;
                case '422':
                    throw new UnprocessableEntityException($json->message, $json->status, null,
                        isset($json->errors) ? $json->errors : []);

                    break;
                default:

            }
        }
    }

}