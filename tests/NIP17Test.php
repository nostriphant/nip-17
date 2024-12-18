<?php

namespace nostriphant\NIP17Tests;

use nostriphant\NIP01\Key;
use nostriphant\NIP59\Gift;
use nostriphant\NIP59\Seal;
use nostriphant\NIP17\PrivateDirect;

it('relays private direct messsage from alice to bob', function (): void {
    $alice_key = \Pest\key_sender();

    $bob_key = \Pest\key_recipient();
    $gift = PrivateDirect::make($alice_key, $bob_key(Key::public()), 'Hello!!');

    expect($gift->kind)->toBe(1059);

    $seal = Gift::unwrap($bob_key, $gift);
    expect($seal->kind)->toBe(13);
    expect($seal->pubkey)->toBeString();
    expect($seal->content)->toBeString();

    $private_message = Seal::open($bob_key, $seal);
    expect($private_message)->toHaveKey('id');
    expect($private_message)->toHaveKey('content');
    expect($private_message->content)->toBe('Hello!!');
});
