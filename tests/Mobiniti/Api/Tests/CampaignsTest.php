<?php namespace Mobiniti\Api\Tests;

class CampaignsTest extends BasicTest
{

    public function testCredentials()
    {
        parent::credentialsTest();
    }

    public function testAuthToken()
    {
        parent::authTokenTest();
    }

    protected $id;

    public function setUP()
    {
        $campaign = $this->client->campaigns()->create([
            'to' => [-1],
            'message' => 'test campaign message'
        ]);
        $this->assertEquals(is_object($campaign), true, 'Should return an object');
        $this->assertEquals(is_object($campaign->data), true, 'Should return an object called "data"');
        $this->assertEquals(strlen($campaign->data->id), 36, 'Returns a non-uuid for campaign');
        $this->assertEquals($campaign->data->to[0], -1, 'Campaign recipient does not match');
        $this->id = $campaign->data->id;
    }

    public function testAll()
    {
        $campaigns = $this->client->campaigns()->all();
        $this->assertEquals(is_object($campaigns), true, 'Should return an object');
        $this->assertEquals(is_array($campaigns->data), true, 'Should return an object containing an array called "data"');
        $this->assertEquals(strlen($campaigns->data[0]->id), 36, 'Returns a non-uuid for campaign');
    }

    public function tearDown()
    {
        $this->assertEquals(strlen($this->id), 36, 'Cannot find a campaign id to test with. Did setUP fail?');
        $campaign = $this->client->campaigns()->delete($this->id);
        $this->assertEquals($campaign->deleted, true, 'Does not return HTTP code 200');
    }

}