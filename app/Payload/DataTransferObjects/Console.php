<?php declare(strict_types=1);

namespace NtimYeboah\Owura\Payload\DataTransferObjects;

final class Console
{
    public function __construct(
        public string $region,
        public string $requestId,
        public bool $readOnly,
        public string $recipientAccountId,
    ) {}

    public static function fromArray(array $details): self
    {
        return new static(
            $details['awsRegion'],
            $details['requestID'],
            $details['readOnly'],
            $details['recipientAccountId'],
        );
    }

    /**
     * Get the AWS Region the event happened.
     *
     * @return string
     */
    public function region(): string
    {
        return $this->region;
    }

    /**
     * Get request Id of the session.
     *
     * @return string
     */
    public function requestId(): string
    {
        return $this->requestId;
    }

    /**
     * Get the read only property.
     *
     * @return boolean
     */
    public function readOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * Get the recipient account Id.
     *
     * @return string
     */
    public function recipientAccountId(): string
    {
        return $this->recipientAccountId;
    }
}
