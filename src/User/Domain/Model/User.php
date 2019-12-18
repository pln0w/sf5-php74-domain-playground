<?php
declare(strict_types=1);

namespace User\Domain\Model;

use DateInterval;
use DateTime;
use DateTimeInterface;

final class User implements UserInterface
{
    protected ?int $id = null;
    protected ?string $username = null;
    protected string $salt;
    protected ?string $password = null;
    protected ?string $plainPassword = null;
    protected ?DateTimeInterface $lastLogin = null;
    protected ?string $emailVerificationToken = null;
    protected ?string $passwordResetToken = null;
    protected ?DateTimeInterface $passwordRequestedAt = null;
    protected ?DateTimeInterface $verifiedAt = null;
    protected bool $locked = false;
    protected ?DateTimeInterface $expiresAt = null;
    protected ?DateTimeInterface $credentialsExpireAt = null;
    protected array $roles = [UserInterface::DEFAULT_ROLE];
    protected ?string $email = null;
    protected ?string $encoderName = null;
    protected DateTimeInterface $createdAt;
    protected ?DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->salt = base_convert(bin2hex(random_bytes(20)), 16, 36);
        $this->createdAt = new DateTime();
    }

    public function __toString(): string
    {
        return (string) $this->getUsername();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $password): void
    {
        $this->plainPassword = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getExpiresAt(): ?DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?DateTimeInterface $date): void
    {
        $this->expiresAt = $date;
    }

    public function getCredentialsExpireAt(): ?DateTimeInterface
    {
        return $this->credentialsExpireAt;
    }

    public function setCredentialsExpireAt(?DateTimeInterface $date): void
    {
        $this->credentialsExpireAt = $date;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTimeInterface $time): void
    {
        $this->lastLogin = $time;
    }

    public function getEmailVerificationToken(): ?string
    {
        return $this->emailVerificationToken;
    }

    public function setEmailVerificationToken(?string $verificationToken): void
    {
        $this->emailVerificationToken = $verificationToken;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): void
    {
        $this->passwordResetToken = $passwordResetToken;
    }

    public function isCredentialsNonExpired(): bool
    {
        return !$this->hasExpired($this->credentialsExpireAt);
    }


    public function isAccountNonExpired(): bool
    {
        return !$this->hasExpired($this->expiresAt);
    }

    public function setLocked(bool $locked): void
    {
        $this->locked = $locked;
    }

    public function isAccountNonLocked(): bool
    {
        return !$this->locked;
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function addRole(string $role): void
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }

    public function removeRole(string $role): void
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function isPasswordRequestNonExpired(DateInterval $ttl): bool
    {
        if (null === $this->passwordRequestedAt) {
            return false;
        }

        $threshold = new DateTime();
        $threshold->sub($ttl);

        return $threshold <= $this->passwordRequestedAt;
    }

    public function getPasswordRequestedAt(): ?DateTimeInterface
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequestedAt(?DateTimeInterface $date): void
    {
        $this->passwordRequestedAt = $date;
    }

    public function isVerified(): bool
    {
        return null !== $this->verifiedAt;
    }

    public function getVerifiedAt(): ?DateTimeInterface
    {
        return $this->verifiedAt;
    }

    public function setVerifiedAt(?DateTimeInterface $verifiedAt): void
    {
        $this->verifiedAt = $verifiedAt;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getEncoderName(): ?string
    {
        return $this->encoderName;
    }

    public function setEncoderName(?string $encoderName): void
    {
        $this->encoderName = $encoderName;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function serialize(): string
    {
        return serialize([
            $this->password,
            $this->salt,
            $this->usernameCanonical,
            $this->username,
            $this->locked,
            $this->enabled,
            $this->id,
            $this->encoderName,
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized): void
    {
        $data = unserialize($serialized, ['allowed_classes' => self::class]);
        $data = array_merge($data, array_fill(0, 2, null));
        [
            $this->password,
            $this->salt,
            $this->usernameCanonical,
            $this->username,
            $this->locked,
            $this->enabled,
            $this->id,
            $this->encoderName,
        ] = $data;
    }

    protected function hasExpired(?DateTimeInterface $date): bool
    {
        return null !== $date && new DateTime() >= $date;
    }
}
