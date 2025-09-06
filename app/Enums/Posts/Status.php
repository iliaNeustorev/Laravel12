<?php

namespace App\Enums\Posts;

enum Status : int
{
    case DRAFT = 0;
    case MODERATING = 5;
    case PUBLISHED = 10;
    case REJECTED = 15;

    public const TEXTS = [
        0 => 'Draft',
        5 => 'On Moderation',
        10 => 'Published',
        15 => 'Rejected by moder'
    ];

    public function text(){
        return self::TEXTS[$this->value];
    }
}
