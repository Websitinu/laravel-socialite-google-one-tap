<?php

namespace LaravelSocialite\GoogleOneTap;

use Illuminate\Support\Arr;

class GoogleOneTapUser
{
    protected array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function toArray(): array
    {
        return [
            'id' => Arr::get($this->payload, 'sub'),
            'name' => Arr::get($this->payload, 'name'),
            'email' => Arr::get($this->payload, 'email'),
            'avatar' => Arr::get($this->payload, 'picture'),
            'nickname' => Arr::get($this->payload, 'family_name'),
        ];
    }
}
