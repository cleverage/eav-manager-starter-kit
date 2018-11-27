<?php

namespace App\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\AbstractData;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_eav_data", indexes={
 *     @ORM\Index(name="family", columns={"family_code"}),
 *     @ORM\Index(name="updated_at", columns={"updated_at"}),
 *     @ORM\Index(name="created_at", columns={"created_at"})
 * })
 * @ORM\Entity(repositoryClass="CleverAge\EAVManager\EAVModelBundle\Entity\DataRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Data extends AbstractData
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
