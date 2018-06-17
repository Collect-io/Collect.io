<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="colllect_user")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\UserRepository")
 * @UniqueEntity("email", message="already_used")
 * @Serializer\ExclusionPolicy("all")
 */
class User implements UserInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_DEFAULT = self::ROLE_USER;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email(message="not_a_valid_email")
     * @Assert\NotBlank(message="cannot_be_blank")
     * @Assert\Length(max="255", maxMessage="too_long")
     * @Serializer\Expose
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255)
     * @Assert\NotBlank(message="cannot_be_blank")
     * @Assert\Length(max="255", maxMessage="too_long")
     * @Serializer\Expose
     */
    private $nickname;

    /**
     * @var string[]
     *
     * @ORM\Column(name="roles", type="json_array")
     * @Serializer\Type("array<string>")
     * @Serializer\Accessor(getter="getRoles",setter="setRoles")
     * @Serializer\Expose
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(message="cannot_be_blank")
     * @Assert\Length(min="8", minMessage="too_short")
     */
    private $plainPassword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Serializer\Expose
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="dropbox_token", type="string", length=255, nullable=true)
     */
    private $dropboxToken;


    public function __construct()
    {
        $this->roles = [];
        $this->createdAt = new \DateTime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get username is an alias for getEmail needed by the UserInterface
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return User
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set roles
     *
     * @param string[] $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string[]
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // we need to make sure to have at least one role
        $roles[] = self::ROLE_DEFAULT;
        return array_unique($roles);
    }

    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === self::ROLE_DEFAULT) {
            return $this;
        }
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get plain password
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set plain password
     *
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null; // change entity to 'dirty' for Doctrine
    }

    /**
     * Clean plain password
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set dropboxToken
     *
     * @param string $dropboxToken
     *
     * @return User
     */
    public function setDropboxToken($dropboxToken)
    {
        $this->dropboxToken = $dropboxToken;

        return $this;
    }

    /**
     * Get dropboxToken
     *
     * @return string
     */
    public function getDropboxToken()
    {
        return $this->dropboxToken;
    }
}
