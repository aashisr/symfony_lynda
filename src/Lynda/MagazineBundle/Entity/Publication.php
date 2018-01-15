<?php

namespace Lynda\MagazineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Publication
 *
 * @ORM\Table(name="publications")
 * @ORM\Entity(repositoryClass="Lynda\MagazineBundle\Repository\PublicationRepository")
 */
class Publication
{
    //Add private property issues (other table) to contain issues

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="publication")
     */
    private $issues;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    //Define constructor
    public function __construct(){
        $this->issues = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Publication
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add issue
     *
     * @param \Lynda\MagazineBundle\Entity\Issue $issue
     *
     * @return Publication
     */
    public function addIssue(\Lynda\MagazineBundle\Entity\Issue $issue)
    {
        $this->issues[] = $issue;

        return $this;
    }

    /**
     * Remove issue
     *
     * @param \Lynda\MagazineBundle\Entity\Issue $issue
     */
    public function removeIssue(\Lynda\MagazineBundle\Entity\Issue $issue)
    {
        $this->issues->removeElement($issue);
    }

    /**
     * Get issues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIssues()
    {
        return $this->issues;
    }


    /**
     * Render a Publication as a string
     *
     * @return type string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }
}
