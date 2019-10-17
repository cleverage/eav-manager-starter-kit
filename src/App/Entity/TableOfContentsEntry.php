<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sidus\EAVModelBundle\Annotation\Family;

/**
 * @ORM\Entity(repositoryClass="CleverAge\EAVManager\EAVModelBundle\Entity\DataRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @Family("TableOfContentsEntry")
 */
class TableOfContentsEntry extends Data
{
}
