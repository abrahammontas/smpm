<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\User;
use App\Account;

class PostTest extends TestCase
{
    public function testCreate()
    {
        $user = User::where('email', 'abrahammontas@gmail.com')->first();
        $this->actingAs($user)
            ->visit('/post/create')
            ->type('post test deleted', 'text')
            ->type('2017/06/30 12:41:26', 'post_time')
            ->select(Account::where('user_id', $user->id)->first()->id, 'account_id')
            ->press('Add')
            ->seePageIs('/post');
    }

    public function testEdit()
    {
        $post = Post::where('text', 'post test deleted')->first();

        $user = User::where('email', 'abrahammontas@gmail.com')->first();
        $this->actingAs($user)
            ->visit('/post/'.$post->id.'/edit')
            ->type('post test deleted2', 'text')
            ->type('2017/06/30 12:41:26', 'post_time')
            ->select(Account::where('user_id', $user->id)->first()->id, 'account_id')
            ->press('Edit')
            ->seePageIs('/post');
    }

    public function testDelete()
    {
        $post = Post::where('text', 'post test deleted2')->first();

        $response = $this->actingAs(User::where('email', 'abrahammontas@gmail.com')->first())->call('DELETE', '/post/'.$post->id);

        $this->assertEquals(302, $response->status());
    }
}
