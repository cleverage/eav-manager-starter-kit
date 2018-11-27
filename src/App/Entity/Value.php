<?php

namespace App\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\AbstractValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_eav_value", indexes={
 *     @ORM\Index(name="attribute", columns={"attribute_code"}),
 *     @ORM\Index(name="string_search", columns={"attribute_code", "string_value"}),
 *     @ORM\Index(name="int_search", columns={"attribute_code", "integer_value"}),
 *     @ORM\Index(name="position", columns={"position"})
 * })
 * @ORM\Entity(repositoryClass="Sidus\EAVModelBundle\Entity\ValueRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Value extends AbstractValue
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
