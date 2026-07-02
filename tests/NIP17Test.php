<?php

namespace nostriphant\NIP17Tests;

use nostriphant\NIP01\Key;
use nostriphant\NIP59\Gift;
use nostriphant\NIP59\Seal;
use nostriphant\NIP17\PrivateDirect;

it('relays private direct messsage from alice to bob', function (): void {
    $alice_key = Key::fromHex('a71a415936f2dd70b777e5204c57e0df9a6dffef91b3c78c1aa24e54772e33c3');

    $bob_key = Key::fromHex('6eeb5ad99e47115467d096e07c1c9b8b41768ab53465703f78017204adc5b0cc');
    $gift = PrivateDirect::make($alice_key, Key::derivePublicKey($bob_key), 'Hello!!');

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
