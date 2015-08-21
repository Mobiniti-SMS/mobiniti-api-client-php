<?php namespace Mobiniti\Api;

use GuzzleHttp\Client as HttpClient;
use Mobiniti\Api\Exceptions\OauthException;

class Auth
{

    public $client_id;
    public $client_secret;
    public $redirect_uri;

    protected $http;

    protected $base_url = 'https://app.mobiniti.com/oauth2/api/login';

    protected $access_token_url = 'https://app.mobiniti.com/oauth2/api/access_token';

    /**
     * @param $client_id
     * @param $client_secret
     * @param $redirect_uri
     */
    public function __construct($client_id, $client_secret, $redirect_uri)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;

        $this->http = new HttpClient([
            'http_errors' => false,
            'headers' => ['Content-Type' => 'application/json'],
            'verify' => realpath(dirname(__FILE__) . '/../ca-certificates.crt'),
        ]);
    }

    /**
     * Returns the authorization url
     *
     * @param array $scopes
     *
     * @return string
     */
    public function getAuthorizationUrl(array $scopes = [])
    {
        $params = [
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri
        ];

        if (count($scopes) > 0) {
            $params['scope'] = implode(',', $scopes);
        }

        return $this->base_url . '?' . http_build_query($params, '', '&');
    }

    /**
     * Returns an array containing access token fields - 'access_token', 'token_type', 'expires_in'
     *
     * @param string $code The authorization code
     *
     * @return array
     * @throws OauthException
     */
    public function getAccessToken($code)
    {
        $params = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => 'authorization_code',
            'code' => $code,
        ];

        $response = $this->http->post($this->access_token_url, ['body' => $params]);

        if ($response->getStatusCode() === 200) {
            return $response->json();
        } else {
            $json = $response->json();
            throw new OauthException("{$json['error']} - {$json['error_description']}", $response->getStatusCode());
        }
    }

}