<?php

use PHPUnit\Framework\TestCase;
use Microsoft\Dynamics\Http\DynamicsCollectionRequest;
use Microsoft\Dynamics\Model;

class DynamicsCollectionRequestTest extends TestCase
{
    private $collectionRequest;
    private $client;
    private $reflectedRequestUrlHandler;

    public function setUp(): void
    {
        $this->collectionRequest = new DynamicsCollectionRequest("GET", "/endpoint", "token", "url", "version");
        $this->collectionRequest->setReturnType(Model\Lead::class);
        $this->collectionRequest->setPageSize(2);

        $body = json_encode(array('body' => 'content', '@odata.nextLink' => 'url/version/endpoint?skiptoken=link'));
        $body2 = json_encode(array('body' => 'content'));
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, ['foo' => 'bar'], $body),
            new GuzzleHttp\Psr7\Response(200, ['foo' => 'bar'], $body2),
            new GuzzleHttp\Psr7\Response(200, ['foo' => 'bar'], $body2),
        ]);
        $handler = GuzzleHttp\HandlerStack::create($mock);
        $this->client = new GuzzleHttp\Client(['handler' => $handler]);

        $this->reflectedRequestUrlHandler = new ReflectionMethod('Microsoft\Dynamics\Http\DynamicsRequest', 'getRequestUrl');
        $this->reflectedRequestUrlHandler->setAccessible(true);
    }

    public function testHitEndOfCollection()
    {
        $this->expectException(PHPUnit_Framework_Error::class);

        //First page
        $this->collectionRequest->setPageCallInfo(false);
        $response = $this->collectionRequest->execute($this->client);
        $this->collectionRequest->processPageCallReturn($response);

        //Last page
        $this->collectionRequest->setPageCallInfo(false);
        $response = $this->collectionRequest->execute($this->client);
        $result1 = $this->collectionRequest->processPageCallReturn($response);

        $this->assertTrue($this->collectionRequest->isEnd());

        //Expect error
        $this->collectionRequest->setPageCallInfo(false);
    }

    public function testProcessPageCallReturn()
    {
        $this->collectionRequest->setPageCallInfo(false);
        $response = $this->collectionRequest->execute($this->client);
        $result = $this->collectionRequest->processPageCallReturn($response);
        $this->assertInstanceOf(Microsoft\Dynamics\Model\Lead::class, $result);
    }

    public function testEndpointManipulation()
    {
        //Page should be 1
        $this->assertFalse($this->collectionRequest->isEnd());

        $requestUrl = $this->reflectedRequestUrlHandler->invokeArgs($this->collectionRequest, array());

        $this->assertEquals($requestUrl, 'version/endpoint');

        $this->collectionRequest->setPageCallInfo(false);

        $requestUrl = $this->reflectedRequestUrlHandler->invokeArgs($this->collectionRequest, array());
        $this->assertEquals('version/endpoint?$top=2', $requestUrl);

        $response = $this->collectionRequest->execute($this->client);
        $this->collectionRequest->processPageCallReturn($response);

        $requestUrl = $this->reflectedRequestUrlHandler->invokeArgs($this->collectionRequest, array());
        $this->assertEquals('version/endpoint', $requestUrl);
    }

    public function testGetPrevPage()
    {
        $this->collectionRequest->setPageCallInfo(true);

        $requestUrl = $this->reflectedRequestUrlHandler->invokeArgs($this->collectionRequest, array());
        $this->assertEquals('version/endpoint?$top=2&previous-page=true', $requestUrl);

        $response = $this->collectionRequest->execute($this->client);
        $this->collectionRequest->processPageCallReturn($response);

        $requestUrl = $this->reflectedRequestUrlHandler->invokeArgs($this->collectionRequest, array());
        $this->assertEquals('version/endpoint', $requestUrl);
    }
}
