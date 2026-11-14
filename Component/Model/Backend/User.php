<?php


namespace PM\PlentyMarketsBundle\Component\Model\Backend;


/**
 * Class User
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Backend
 */
class User
{
    /** @var int|null */
    private ?int $id = 0;

    /** @var string|null */
    private ?string $realName = '';

    /** @var string|null */
    private ?string $email = '';

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    public function getRealName(): string
    {
        return $this->realName;
    }

    /**
     * @return User
     */
    public function setRealName(string $realName): User
    {
        $this->realName = $realName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

}