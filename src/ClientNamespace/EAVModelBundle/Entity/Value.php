<?php

namespace ClientNamespace\EAVModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CleverAge\EAVManager\EAVModelBundle\Entity\Value as BaseValue;

/**
 * Value
 *
 * @ORM\Table(name="client_value")
 * @ORM\Entity(repositoryClass="CleverAge\EAVManager\EAVModelBundle\Entity\ValueRepository")
 */
class Value extends BaseValue
{
}
