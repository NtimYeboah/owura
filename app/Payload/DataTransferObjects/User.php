<?php declare(strict_types=1);

namespace NtimYeboah\Owura\Payload\DataTransferObjects;

final class User
{
    public function __construct(
        public string $type,
        public string $principalId,
        public string $arn,
        public string $awsAccountId,
        public string $accessKeyId,
        public string $userName
    ) {}

    public static function fromArray(array $details): self
    {
        return new static(
            $details['type'],
            $details['principalId'],
            $details['arn'],
            $details['awsAccountId'],
            $details['accessKeyId'],
            $details['userName'],
        );
    }

    /**
     * Get the type of user.
     *
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * Get the Amazone resource name of the user.
     *
     * @return string
     */
    public function amazonResourceName(): string
    {
        return $this->arn;
    }

    /**
     * Get the account Id of the AWS account that was accessed.
     *
     * @return string
     */
    public function awsAccountId(): string
    {
        return $this->awsAccountId;
    }

    /**
     * The access key id of the user.
     *
     * @return string
     */
    public function accessKeyId(): string
    {
        return $this->accessKeyId;
    }

    /**
     * The IAM name of the user.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->userName;
    }
}
