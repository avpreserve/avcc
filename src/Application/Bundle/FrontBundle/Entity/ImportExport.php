<?php

namespace Application\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImportExport
 *
 * @ORM\Table(name="import_export")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 *
 */
class ImportExport
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime $createdOn
     *
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;

    /**
     * @var \DateTime $updatedOn
     *
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     */
    private $updatedOn;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @ORM\Column(name="type", type="string",length=50, nullable=true)
     * @var string
     *
     */
    private $type;

    /**
     * @ORM\Column(name="format", type="text", nullable=true)
     * @var string
     *
     */
    private $format;

    /**
     * @ORM\Column(name="query_or_id", type="string")
     * @var string
     */
    private $queryOrId;

    /**
     * @ORM\Column(name="merge_to_file", type="string", nullable=true)
     * @var string
     */
    private $mergeToFile;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true, options={"default" = 0}) )
     */
    private $status;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedOnValue()
    {
        if (!$this->getCreatedOn()) {
            $this->createdOn = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedOnValue()
    {
        $this->updatedOn = new \DateTime();
    }

    /**
     * Returns title
     *
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getQueryOrId()
    {
        return $this->queryOrId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
    }

    public function setUpdatedOn(\DateTime $updatedOn)
    {
        $this->updatedOn = $updatedOn;
    }

    public function setUser(\Application\Bundle\FrontBundle\Entity\Users $user)
    {
        $this->user = $user;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function setQueryOrId($queryOrId)
    {
        $this->queryOrId = $queryOrId;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set merge to file field
     * 
     * @param string $file
     */
    public function setMergeToFile(File $file = null)
    {
        $this->mergeToFile = $file;
    }

    /**
     * Return merge to file name
     * 
     * @return string
     */
    public function getMergeToFile()
    {
        return $this->mergeToFile;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getMergeToFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getMergeToFile()->move(
                $this->getUploadRootDir(), $this->getMergeToFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->mergeToFile = $this->getMergeToFile()->getClientOriginalName();
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        if ($this->mergeToFile) {

            return $this->getUploadRootDir() . '/' . $this->mergeToFile;
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        if ($this->mergeToFile) {
            return '/web/' . $this->getUploadDir() . '/' . $this->mergeToFile;
        }

        return null;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'merge';
    }

}
