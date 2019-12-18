<?php
declare(strict_types=1);

namespace User\Domain\Security;

use InvalidArgumentException;
use LogicException;
use User\Domain\Model\CredentialsHolderInterface;

final class UserPbkdf2PasswordEncoder implements UserPasswordEncoderInterface
{
    private const MAX_PASSWORD_LENGTH = 4096;
    private string $algorithm;
    private bool $encodeHashAsBase64;
    private int $iterations;
    private int $length;

    public function __construct(
        ?string $algorithm = null,
        ?bool $encodeHashAsBase64 = null,
        ?int $iterations = null,
        ?int $length = null
    ) {
        $this->algorithm = $algorithm ?? 'sha512';
        $this->encodeHashAsBase64 = $encodeHashAsBase64 ?? true;
        $this->iterations = $iterations ?? 1000;
        $this->length = $length ?? 40;
    }

    /**
     * @throws LogicException when the algorithm is not supported
     */
    public function encode(CredentialsHolderInterface $user): string
    {
        return $this->encodePassword($user->getPlainPassword(), $user->getSalt());
    }

    /**
     * @throws InvalidArgumentException
     * @throws LogicException when the algorithm is not supported
     */
    private function encodePassword(string $plainPassword, string $salt): string
    {
        if (strlen($plainPassword) > self::MAX_PASSWORD_LENGTH) {
            throw new InvalidArgumentException(
                sprintf('The password must be at most %d characters long.', self::MAX_PASSWORD_LENGTH)
            );
        }

        if (!in_array($this->algorithm, hash_algos(), true)) {
            throw new LogicException(sprintf('The algorithm "%s" is not supported.', $this->algorithm));
        }

        $digest = hash_pbkdf2($this->algorithm, $plainPassword, $salt, $this->iterations, $this->length, true);

        return $this->encodeHashAsBase64 ? base64_encode($digest) : bin2hex($digest);
    }
}
