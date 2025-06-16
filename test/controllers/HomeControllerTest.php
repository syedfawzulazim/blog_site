<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;
use App\Models\BlogPost;
use App\Core\View;

class HomeControllerTest extends TestCase
{
    private BlogPost $blogPostMock;
    private View $viewMock;

    protected function setUp(): void
    {
        // Mock BlogPost
        $this->blogPostMock = $this->createMock(BlogPost::class);

        // Fake View render method with return string
        $this->viewMock = $this->createMock(View::class);
    }

    public function testIndexWithUserIdInSession(): void
    {
        $_SESSION['user_id'] = 1;

        $expectedPosts = [
            ['title' => 'First Post', 'content' => 'Hello World'],
            ['title' => 'Second Post', 'content' => 'PHPUnit Rocks!'],
        ];

        $this->blogPostMock
            ->method('getAllPostsByUserId')
            ->willReturn($expectedPosts);
        $this->viewMock->method('render')->willReturnCallback(function ($template, $data) {
            return $data['posts'][0]['title'];
        });

        $controller = new HomeController($this->blogPostMock, $this->viewMock);
        $output = $controller->index();

        $this->assertStringContainsString('First Post', $output);
    }

    public function testIndexWithoutUserId(): void
    {
        unset($_SESSION['user_id']);

        $this->blogPostMock
            ->expects($this->never())
            ->method('getAllPostsByUserId');
        $this->viewMock->method('render')->willReturn('home');

        $controller = new HomeController($this->blogPostMock, $this->viewMock);
        $output = $controller->index();

        $this->assertStringContainsString('home', $output);
    }
}
