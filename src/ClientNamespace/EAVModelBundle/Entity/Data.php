<?php

namespace ClientNamespace\EAVModelBundle\Entity;

use CleverAge\EAVManager\EAVModelBundle\Entity\Data as BaseData;
use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 * @ORM\Table(name="client_data", indexes={
 *     @ORM\Index(name="family", columns={"family_code"})
 * })
 * @ORM\Entity(repositoryClass="CleverAge\EAVManager\EAVModelBundle\Entity\DataRepository")
 */
class Data extends BaseData
{
}
