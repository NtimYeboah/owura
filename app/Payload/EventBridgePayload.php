<?php

namespace NtimYeboah\Owura\Payload;

use NtimYeboah\Owura\Payload\DataTransferObjects\Console;
use NtimYeboah\Owura\Payload\DataTransferObjects\User;
use NtimYeboah\Owura\Payload\DataTransferObjects\Event;
use NtimYeboah\Owura\Payload\DataTransferObjects\Session;
use NtimYeboah\Owura\Payload\DataTransferObjects\Tls;

class EventBridgePayload extends Payload
{
    /** var Tls */
    public Tls $tls;

    /** var User */
    public User $user;

    /** var Event */
    public Event $event;

    /** @var Session */
    public Session $session;

    /** @var Console */
    public Console $console;

    protected function __construct(array $details)
    {
        $this->initializeUser($details);
        $this->initializeEvent($details);
        $this->initializeSession($details);
        $this->initializeConsole($details);
        $this->initializeTls($details);
    }

    /**
     * Capture event from AWS.
     *
     * @param array $details
     * @return static
     */
    public static function capture(array $details): static
    {
        return new static($details);
    }

    /**
     * Get user representation in event.
     *
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * Get console representation in event.
     *
     * @return Console
     */
    public function console(): Console
    {
        return $this->console;
    }

    /**
     * Get TLS representation in event.
     *
     * @return Tls
     */
    public function tls(): Tls
    {
        return $this->tls;
    }

    /**
     * Get session representation in event.
     *
     * @return Session
     */
    public function session(): Session
    {
        return $this->session;
    }

    /**
     * Get event represenation in event.
     *
     * @return Event
     */
    public function event(): Event
    {
        return $this->event;
    }

    /**
     * Initialize user from the User DTO.
     *
     * @param array $details
     * @return void
     */
    private function initializeUser(array $details)
    {
        $this->user = User::fromArray([
            'type' => $details['userIdentity']['type'],
            'principalId' => $details['userIdentity']['principalId'],
            'arn' => $details['userIdentity']['arn'],
            'awsAccountId' => $details['userIdentity']['accountId'],
            'accessKeyId' => $details['userIdentity']['accessKeyId'],
            'userName' => $details['userIdentity']['userName'],
        ]);
    }

    /**
     * Initialize event from the Event DTO.
     *
     * @param array $details
     * @return void
     */
    private function initializeEvent(array $details)
    {
        $this->event = Event::fromArray([
            'eventVersion' => $details['eventVersion'],
            'eventTime' => $details['eventTime'],
            'eventSource' => $details['eventSource'],
            'eventName' => $details['eventName'],
            'eventID' => $details['eventID'],
            'eventType' => $details['eventType'],
            'managementEvent' => $details['managementEvent'],
            'eventCategory' => $details['eventCategory'],
        ]);
    }

    /**
     * Initialize session from the Session DTO.
     *
     * @param array $details
     * @return void
     */
    private function initializeSession(array $details)
    {
        $this->session = Session::fromArray([
            'creationDate' => $details['userIdentity']['sessionContext']['attributes']['creationDate'],
            'mfaAuthenticated' => $details['userIdentity']['sessionContext']['attributes']['mfaAuthenticated'],
            'sourceIpAddress' => $details['sourceIPAddress'],
            'userAgent' => $details['userAgent'],
            'sessionCredentialFromConsole' => $details['sessionCredentialFromConsole'],
        ]);
    }

    /**
     * Initialize tls from the Tls DTO.
     *
     * @param array $details
     * @return void
     */
    private function initializeTls(array $details)
    {
        $this->tls = Tls::fromArray([
            'tlsVersion' => $details['tlsDetails']['tlsVersion'],
            'cipherSuite' => $details['tlsDetails']['cipherSuite'],
            'clientProvidedHostHeader' => $details['tlsDetails']['clientProvidedHostHeader'],
        ]);
    }

    /**
     * Initialize console from the Console DTO. 
     *
     * @param array $details
     * @return void
     */
    private function initializeConsole(array $details)
    {
        $this->console = Console::fromArray([
            'awsRegion' => $details['awsRegion'],
            'requestID' => $details['requestID'],
            'readOnly' => $details['readOnly'],
            'recipientAccountId' => $details['recipientAccountId'],
        ]);
    }
}
