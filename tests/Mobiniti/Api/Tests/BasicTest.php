<?php namespace Mobiniti\Api\Tests;

abstract class BasicTest extends \PHPUnit_Framework_TestCase
{

    protected $client;
    protected $access_token;

    public function __construct()
    {
        $this->access_token = getenv('ACCESS_TOKEN');

        $this->client = new \Mobiniti\Api\Client($this->access_token);
    }

    public function setUp()
    {
        parent::setUp();
    }

    public function credentialsTest()
    {
        $this->assertNotEmpty($this->access_token, 'Expecting $this->access_token parameter; does phpunit.xml exist?');
    }

    public function authTokenTest()
    {
        $contacts = $this->client->contacts()->all(1);
        $this->assertObjectHasAttribute('data',$contacts);
    }
}