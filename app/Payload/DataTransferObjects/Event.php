<?php declare(strict_types=1);

namespace NtimYeboah\Owura\Payload\DataTransferObjects;

use DateTimeImmutable;

final class Event
{
    public function __construct(
        public string $version,
        public string $time,
        public string $source,
        public string $name,
        public string $id,
        public string $type,
        public bool $isManagementEvent,
        public string $category
    ) {}

    public static function fromArray(array $details): self
    {
        return new static(
            $details['eventVersion'],
            $details['eventTime'],
            $details['eventSource'],
            $details['eventName'],
            $details['eventID'],
            $details['eventType'],
            $details['managementEvent'],
            $details['eventCategory'],
        );
    }

    /**
     * Get the event version.
     *
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Get the time the event was triggered.
     *
     * @return DateTimeImmutable
     */
    public function time(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('U', (string) strtotime($this->time));
    }

    /**
     * Get the source of the event.
     *
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }

    /**
     * Get the name of the event.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get the id of the event.
     *
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * Get the type of the event.
     *
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * Determine whether the event is a management event.
     *
     * @return boolean
     */
    public function isManagementEvent(): bool
    {
        return $this->isManagementEvent;
    }

    /**
     * Get the category of the event.
     *
     * @return string
     */
    public function category(): string
    {
        return $this->category;
    }
}
