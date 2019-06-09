<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 04.06.2019
 * Time: 23:26
 */

namespace Guestbook\Service;

use Guestbook\Entity\Entry;
use WideImage\WideImage as WideImage;

/**
 * Class GuestbookManager.
 * @package Guestbook\Service
 */
class GuestbookManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Guestbook entity manager.
     * GuestbookManager constructor.
     * @param $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Add new entity.
     * @param $data
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNewEntry($data)
    {
        $entry = new Entry();
        $entry->setName($data['name']);
        $entry->setEmail($data['email']);
        $entry->setText($data['text']);
        if (!empty($data['uploadedFile']['name'])) {
            $entry->setUploadedFile($data['uploadedFile']['name']);

            // охраняем миниатюру изхображения
            $this->saveEntryThumbImage($data['uploadedFile']['name']);
        }
        $entry->setDatePublish(new \DateTime());

        $this->entityManager->persist($entry);
        $this->entityManager->flush();
    }

    /**
     * Update existing entry.
     * @param $entry
     * @param $data
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateEntry($entry, $data)
    {
        $entry->setName($data['name']);
        $entry->setEmail($data['email']);
        $entry->setText($data['text']);
        if (!empty($data['uploadedFile']['name'])) {
            $entry->setUploadedFile($data['uploadedFile']['name']);

            // охраняем миниатюру изхображения
            $this->saveEntryThumbImage($data['uploadedFile']['name']);
        }
        $entry->setStatus($data['status']);

        $this->entityManager->flush();
    }

    /**
     * Remove entry.
     * @param $entry
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeEntry($entry)
    {
        $this->entityManager->remove($entry);

        $this->entityManager->flush();
    }

    /**
     * Get status string.
     * @param $entry
     * @return string
     */
    public function getEntryStatusAsString($entry)
    {
        switch ($entry->getStatus()) {
            case Entry::STATUS_DRAFT: return 'Draft';
            case Entry::STATUS_PUBLISHED: return 'Published';
        }

        return 'Unknown';
    }

    /**
     * Get entry scr by name.
     * @param $uploadedFile
     * @return bool|string
     */
    public function getEntryFileSrc($uploadedFile)
    {
        $imgPath = "../data/uploads/thumbs/thumb-$uploadedFile";
        return $imgPath;
    }

    /**
     * Save image as thumbnail.
     * @param $uploadedFile
     */
    public function saveEntryThumbImage($uploadedFile)
    {
        $loadedImg = WideImage::load("./data/uploads/$uploadedFile");
        $loadedImg->resize(200)->saveToFile("./data/uploads/thumbs/thumb-$uploadedFile");
    }
}