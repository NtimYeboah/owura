<?php declare(strict_types=1);

namespace NtimYeboah\Owura\Payload;

use NtimYeboah\Owura\Payload\DataTransferObjects\Console;
use NtimYeboah\Owura\Payload\DataTransferObjects\User;
use NtimYeboah\Owura\Payload\DataTransferObjects\Event;
use NtimYeboah\Owura\Payload\DataTransferObjects\Session;
use NtimYeboah\Owura\Payload\DataTransferObjects\Tls;

abstract class Payload
{
    /**
     * Get user representation in event.
     *
     * @return User
     */
    public abstract function user(): User;

    /**
     * Get console representation in event.
     *
     * @return Console
     */
    public abstract function console(): Console;

    /**
     * Get TLS representation in event.
     *
     * @return Tls
     */
    public abstract function tls(): Tls;

    /**
     * Get session representation in event.
     *
     * @return Session
     */
    public abstract function session(): Session;

    /**
     * Get event represenation in event.
     *
     * @return Event
     */
    public abstract function event(): Event;
}
