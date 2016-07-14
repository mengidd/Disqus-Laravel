<?php

namespace Mengidd\Disqus;

use Mengidd\Disqus\Resources\PostsList;
use Mengidd\Disqus\Resources\ThreadsList;

class Disqus
{
    /**
     * Get posts
     */
    public function postsList()
    {
        return new PostsList();
    }

    /**
     * Get threads
     */
    public function threadsList()
    {
        return new ThreadsList();
    }
}
