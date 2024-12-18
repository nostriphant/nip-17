<?php

namespace nostriphant\NIP17;

use nostriphant\NIP59\Gift;
use nostriphant\NIP59\Seal;
use nostriphant\NIP01\Key;
use nostriphant\NIP59\Rumor;

class PrivateDirect {

    static function make(Key $private_key, string $recipient_pubkey, string $message): \nostriphant\NIP01\Event {
        return Gift::wrap($recipient_pubkey, Seal::close($private_key, $recipient_pubkey, new Rumor(
                                        pubkey: $private_key(Key::public()),
                                                created_at: time(),
                                                kind: 14,
                                                content: $message,
                                                tags: [['p', $recipient_pubkey]]
                                )));
    }
}
