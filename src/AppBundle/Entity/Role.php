<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Role
 *
 * @ORM\Table(name="neosys.g_role")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 */
class Role implements RoleInterface
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;


    /**
    *@ORM\ManyToMany(targetEntity="User", mappedBy="roles")
    */
    private $users;

    
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    
    //Solicita el implement
    public function getRole() {
        return $this->role;
    }
    
    /**
     * Set rol
     *
     * @param string $rol
     *
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

      /**
     * Add users
     *
     * 
     * @return Role
     */
    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
    
        return $this;
    }

    /**
     * Remove users
     *
     * 
     */
    public function removeUser(User $user)
    {
        if (!$this->users->contains($user)) {
            return;
        }
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

}

