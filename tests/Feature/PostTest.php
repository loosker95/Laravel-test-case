<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Events\CreatePostEvent;
use App\Listeners\CreatePostListener;
use App\Mail\CreatePostMail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class PostTest extends TestCase
{

    use RefreshDatabase;

    private User $admin;

    public function setUp():void{
        parent::setUp();

        $this->admin = User::factory()->create([
            'isAdmin' => true
        ]);
    }

    public function test_create_post_page_load_successfully(): void
    {
        $response = $this->actingAs($this->admin)->get(route('create.post'));
        $response->assertStatus(200);
    }

    public function test_post_can_store_successfully(): void
    {
        $post = Post::factory()->create();
        $response = $this->actingAs($this->admin)->post(route('store.post'), $post->toArray());
        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', ['title' => $post->title]);
    }

    public function test_post_event_is_attached_to_listener(){
        Event::fake();
        Event::assertListening(
            CreatePostEvent::class,
            CreatePostListener::class
        );
    }

    public function test_post_store_dispatch_event_successfully(): void
    {
        Event::fake();
        $post = Post::factory()->create();
        $response = $this->actingAs($this->admin)->post(route('store.post'), $post->toArray());
        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', ['title' => $post->title]);

        // Dispatch the event
        event(new CreatePostEvent($post));
        // Assert that the event was dispatched
        Event::assertDispatched(CreatePostEvent::class);

    }

    public function test_email_has_been_sent_successfully(){
        Mail::fake();
        //  Notification::fake();
        $post = Post::factory()->create();
        $response = $this->actingAs($this->admin)->post(route('store.post'), $post->toArray());
        $response->assertStatus(302);

        $this->assertDatabaseHas('posts', ['title' => $post->title]);

        Mail::assertSent(CreatePostMail::class);
        // Notification::assertSentTo($this->admin, MyNotification::class);
    }
}
