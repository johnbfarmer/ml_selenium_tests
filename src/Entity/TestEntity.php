<?php 

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="configs")
 */
class TestEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $value;

    public function setUid($uid) {
        $this->uid = $uid;
    }

    public function setValue($value) {
        $this->value = $value;
    }

}