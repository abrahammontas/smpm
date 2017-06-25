<?php

namespace App;

interface Publisher
{
    public function publish($post);

    public function getScheduledPosts();
}
