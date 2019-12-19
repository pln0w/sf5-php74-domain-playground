<?php

declare(strict_types=1);

namespace User\Domain\Model;

use DateTimeInterface;
use Serializable;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as CoreUserInterface;

interface UserInterface extends
    Serializable,
    CoreUserInterface,
    EncoderAwareInterface
//    CredentialsHolderInterface
{
    public const DEFAULT_ROLE = 'ROLE_USER';

    public function getEmail(): ?string;

    public function setEmail(?string $email): void;

    public function setUsername(?string $username): void;

    public function setLocked(bool $locked): void;

    public function getEmailVerificationToken(): ?string;

    public function setEmailVerificationToken(?string $verificationToken): void;

    public function getPasswordResetToken(): ?string;

    public function setPasswordResetToken(?string $passwordResetToken): void;

    public function getPasswordRequestedAt(): ?DateTimeInterface;

    public function setPasswordRequestedAt(?DateTimeInterface $date): void;

    public function isPasswordRequestNonExpired(\DateInterval $ttl): bool;

    public function isVerified(): bool;

    public function getVerifiedAt(): ?DateTimeInterface;

    public function setVerifiedAt(?DateTimeInterface $verifiedAt): void;

    public function getExpiresAt(): ?DateTimeInterface;

    public function setExpiresAt(?DateTimeInterface $date): void;

    public function getCredentialsExpireAt(): ?DateTimeInterface;

    public function setCredentialsExpireAt(?DateTimeInterface $date): void;

    public function getLastLogin(): ?DateTimeInterface;

    public function setLastLogin(?DateTimeInterface $time): void;

    public function setEncoderName(?string $encoderName): void;

    public function getCreatedAt(): ?DateTimeInterface;

    public function getUpdatedAt(): ?DateTimeInterface;

    /**
     * Never use this to check if this user has access to anything!
     *
     * Use the SecurityContext, or an implementation of AccessDecisionManager
     * instead, e.g.
     *
     *         $securityContext->isGranted('ROLE_USER');
     */
    public function hasRole(string $role): bool;

    public function addRole(string $role): void;

    public function removeRole(string $role): void;

}
