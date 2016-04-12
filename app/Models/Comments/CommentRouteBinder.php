<?php
namespace EQM\Models\Comments;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class CommentRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Comments\CommentRepository
     */
    private $comments;

    /**
     * @param \EQM\Models\Comments\CommentRepository $comments
     */
    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param int|string $slug
     * @return mixed
     */
    public function find($slug)
    {
        return $this->comments->findById($slug);
    }
}
