<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\ZipController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Tests\TestCase;

#[CoversClass(ZipController::class)]
class ZipControllerTest extends TestCase
{
    #[Test]
    public function it_returns_a_successful_response_for_a_zip_request(): void
    {
        $controller = $this->container->get(ZipController::class);

        $request = $this->createMock(Request::class);
        $request->method('getQueryParams')->willReturn(['zip' => 'subdir']);

        chdir($this->filePath('.'));
        $response = $controller($request, new Response);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/zip', $response->getHeader('Content-Type')[0]);
    }

    #[Test]
    public function it_returns_a_404_error_when_not_found(): void
    {
        $controller = $this->container->get(ZipController::class);

        $request = $this->createMock(Request::class);
        $request->method('getQueryParams')->willReturn(['zip' => '404']);

        chdir($this->filePath('.'));
        $response = $controller($request, new Response);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    #[Test]
    public function it_returns_a_404_error_when_disabled_via_config(): void
    {
        $this->container->set('zip_downloads', false);

        $controller = $this->container->get(ZipController::class);

        $request = $this->createMock(Request::class);
        $request->method('getQueryParams')->willReturn(['zip' => 'subdir']);

        chdir($this->filePath('.'));
        $response = $controller($request, new Response);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
