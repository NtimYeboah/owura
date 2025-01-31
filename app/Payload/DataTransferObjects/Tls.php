<?php declare(strict_types=1);

namespace NtimYeboah\Owura\Payload\DataTransferObjects;

final Class Tls
{
    public function __construct(
        public string $version,
        public string $cipherSuite,
        public string $clientProvidedHostHeader,
    ) {}

    public static function fromArray(array $details): self
    {
        return new static(
            $details['tlsVersion'],
            $details['cipherSuite'],
            $details['clientProvidedHostHeader'],
        );
    }

    /**
     * Get the TLS version
     *
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Get the cipher suite
     *
     * @return string
     */
    public function cipherSuite(): string
    {
        return $this->cipherSuite;
    }

    /**
     * Get client provided host header.
     *
     * @return string
     */
    public function clientProvidedHostHeader(): string
    {
        return $this->clientProvidedHostHeader;
    }
}
