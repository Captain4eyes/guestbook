<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 03.06.2019
 * Time: 15:07
 */

namespace Guestbook\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="entry")
 */
class Entry
{
    // Константы статуса поста.
    const STATUS_DRAFT       = 1; // Черновик.
    const STATUS_PUBLISHED   = 2; // Опубликованная запись.

    /**
     * @ORM\id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @ORM\Column(name="email")
     */
    protected $email;

    /**
     * @ORM\Column(name="text", type="text")
     */
    protected $text;

    /**
     * @ORM\Column(name="uploadedFile", nullable=true)
     */
    protected $uploadedFile;

    /**
     * @ORM\Column(name="date_publish", type="datetime")
     */
    protected $datePublish;

    /**
     * @ORM\Column(name="status", nullable=true)
     */
    protected $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param mixed $uploadedFile
     */
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * @return mixed
     */
    public function getDatePublish()
    {
        return $this->datePublish;
    }

    /**
     * @param mixed $datePublish
     */
    public function setDatePublish($datePublish)
    {
        $this->datePublish = $datePublish;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}