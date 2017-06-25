<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\FacebookPublisher;
use App\TwitterPublisher;

class PublishScheduleContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish every post that is pending.';

    public $fbPublisher;

    public $twPublisher;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->fbPublisher = new FacebookPublisher();
        $this->twPublisher = new TwitterPublisher();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fbPosts = $this->fbPublisher->getScheduledPosts();
        $this->info(count($fbPosts).' post for facebook');
        $twPosts = $this->twPublisher->getScheduledPosts();
        $this->info(count($twPosts).' post for twitter');

        $i=0;
        $j=0;

        foreach($fbPosts as $post)
        {
            $i++;
            $this->fbPubliser->publish($post);
            $this->info($i.'/'.count($twPosts));
        }

        foreach($twPosts as $post)
        {
            $j++;
            $this->twPublisher->publish($post);
            $this->info($j.'/'.count($twPosts));
        }
    }
}
