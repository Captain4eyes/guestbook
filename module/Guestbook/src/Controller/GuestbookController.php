<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 03.06.2019
 * Time: 13:22
 */

namespace Guestbook\Controller;

use Guestbook\Form\GuestbookAddForm;
use Guestbook\Form\GuestbookEditForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Guestbook\Entity\Entry;

/**
 * Class GuestbookController
 * @package Guestbook\Controller
 */
class GuestbookController extends AbstractActionController
{
    /**
     * EntityManager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * GuestbookManager.
     * @var \Guestbook\Service\GuestbookManager
     */
    private $guestbookManager;

    /**
     * GuestbookController constructor.
     * @param $entityManager
     * @param $guestbookManager
     */
    public function __construct($entityManager, $guestbookManager)
    {
        $this->entityManager = $entityManager;
        $this->guestbookManager = $guestbookManager;
    }

    public function adminAction()
    {
        $entries = $this->entityManager->getRepository(Entry::class)
            ->findBy([], ['datePublish' => 'DESC']);

        return new ViewModel([
            'entries' => $entries,
            'gbManager' => $this->guestbookManager,
        ]);
    }


    /**
     * Guestbook index action
     * @return ViewModel
     */
    public function indexAction()
    {
        // Получаем список всех записей гостевой книги
        $entries = $this->entityManager->getRepository(Entry::class)
            ->findBy(['status' => '2'], ['datePublish' => 'DESC']);

        // Визуализируем шаблон представления.
        return new ViewModel([
            'entries' => $entries,
            'gbManager' => $this->guestbookManager,
        ]);
    }


    /**
     * Guestbook add action
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addAction()
    {
        // Создаем форму.
        $form = new GuestbookAddForm();

        // Проверяем есть ли данные формы в $_POST.
        if ($this->getRequest()->isPost()) {

            // Получаем POST и FILES -данные и объединяем в 1 массив.
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            // Заполняем форму данными.
            $form->setData($data);
            if ($form->isValid()) {

                // Получаем валидированные данные формы.
                $data = $form->getData();

                // Используем менеджер гостевой книги для добавления нового поста в базу данных.
                $this->guestbookManager->addNewEntry($data);

                // Перенаправляем пользователя на страницу "index".
                return $this->redirect()->toRoute('guestbook', ['action'=>'index']);
            }
        }

        // Визуализируем шаблон представления.
        return new ViewModel([
            'form' => $form,
            'gbManager' => $this->guestbookManager,
        ]);
    }

    /**
     * Guestbook edit action
     * @return void|\Zend\Http\Response|ViewModel
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editAction()
    {
        // Создаем форму.
        $form = new GuestbookEditForm();

        // Получаем ID записи.
        $entryId = $this->params()->fromRoute('id', -1);

        // Находим существующую запись в базе данных.
        $entry = $this->entityManager->getRepository(Entry::class)
            ->findOneById($entryId);
        if ($entry == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Проверяем POST-запросом.
        if ($this->getRequest()->isPost()) {

            // Получаем POST и FILES -данные и объединяем в 1 массив.
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            // Заполняем форму данными.
            $form->setData($data);
            if ($form->isValid()) {

                // Получаем валидированные данные формы.
                $data = $form->getData();

                // Используем менеджер постов, чтобы добавить новый пост в базу данных.
                $this->guestbookManager->updateEntry($entry, $data);

                // Перенаправляем пользователя на страницу "admin".
                return $this->redirect()->toRoute('guestbook', ['action'=>'admin']);
            }
        } else {
            $data = [
                'name'  => $entry->getName(),
                'email' => $entry->getEmail(),
                'text'  => $entry->getText(),
                'uploadedFile'  => $entry->getUploadedFile()
            ];

            $form->setData($data);
        }

        // Визуализируем шаблон представления.
        return new ViewModel([
            'form' => $form,
            'entry' => $entry
        ]);
    }

    /**
     * Guestbook delete action
     */
    public function deleteAction()
    {
        $entryId = $this->params()->fromRoute('id', -1);

        $entry = $this->entityManager->getRepository(Entry::class)
            ->findOneById($entryId);
        if ($entry == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->guestbookManager->removeEntry($entry);

        // Перенаправляем пользователя на страницу "index".
        return $this->redirect()->toRoute('guestbook', ['action'=>'admin']);
    }
}