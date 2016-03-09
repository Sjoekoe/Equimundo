<?php
namespace EQM\Policies;

trait Policies
{
    protected $commentPolicies = [
        'edit-comment',
    ];

    protected $commentPrivilegePolicies = [
        'delete-comment',
    ];

    protected $conversationPolicies = [
        'read-conversation', 'delete-conversation', 'reply-to',
    ];

    protected $horsePolicies = [
        'follow-horse', 'unfollow-horse',
    ];

    protected $horseTeamPolicies = [
        'edit-horse', 'delete-horse', 'create-album', 'edit-album', 'delete-album', 'upload-picture', 'delete-picture',
        'create-palmares', 'edit-palmares', 'delete-palmares', 'create-pedigree', 'edit-pedigree', 'delete-pedigree',
        'create-disciplines', 'unlink'
    ];

    protected $notificationPolicies = [
        'mark-as-read', 'delete-notification'
    ];

    protected $statusPolicies = [
        'edit-status', 'delete-status',
    ];
}
