<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * The originating sales channel of an order.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#saleschannel
 */
enum SalesChannel: string
{
    case UNSPECIFIED = 'SALES_CHANNEL_UNSPECIFIED';
    case IN_APP = 'IN_APP';
    case PC_EMULATOR = 'PC_EMULATOR';
    case NATIVE_PC = 'NATIVE_PC';
    case PLAY_STORE = 'PLAY_STORE';
    case OUTSIDE_PLAY_STORE = 'OUTSIDE_PLAY_STORE';
}
