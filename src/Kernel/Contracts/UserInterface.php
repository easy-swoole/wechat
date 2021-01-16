<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


interface UserInterface
{
    public function getId(): ?string;

    public function getName(): ?string;

    public function getNickname(): ?string;

    public function getAvatar(): ?string;

    public function getRaw(): array;

    public function getAccessToken(): ?string;

    public function getRefreshToken(): ?string;

    public function getExpiresIn(): ?int;

    public function getTokenResponse(): array;
}