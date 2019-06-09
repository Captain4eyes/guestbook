<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 04.06.2019
 * Time: 21:46
 */

namespace Guestbook\Form;

use Guestbook\Entity\Entry;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Class GuestbookAddForm
 * @package Guestbook\Form
 */
class GuestbookAddForm extends Form
{

    /**
     * GuestbookAddForm constructor.
     */
    public function __construct()
    {
        parent::__construct('entry-add-form');

        $this->setAttribute('method', 'post');

        $this->addElements();

        $this->addInputFilter();
    }

    /**
     * Add for elements.
     */
    protected function addElements()
    {
        $this->add([
            'type'  => 'text',
            'name' => 'name',
            'attributes' => [
                'id' => 'name'
            ],
            'options' => [
                'label' => 'Имя',
            ],
        ]);

        $this->add([
            'type'  => 'email',
            'name' => 'email',
            'attributes' => [
                'id' => 'email'
            ],
            'options' => [
                'label' => 'Email адрес',
            ],
        ]);

        $this->add([
            'type'  => 'textarea',
            'name' => 'text',
            'attributes' => [
                'id' => 'text'
            ],
            'options' => [
                'label' => 'Текст',
            ],
        ]);

        $this->add([
            'type'  => 'file',
            'name' => 'uploadedFile',
            'attributes' => [
                'id' => 'uploadedFile'
            ],
            'options' => [
                'label' => 'Прикрепить файл',
            ],
        ]);

        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Добавить',
                'id' => 'submitbutton',
            ],
        ]);
    }

    /**
     * Add form filters.
     */
    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'     => 'name',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'text',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 10,
                        'max' => 2000
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'type'     => 'Zend\InputFilter\FileInput',
            'name'     => 'uploadedFile',
            'required' => false,
            'validators' => [
                ['name'    => 'FileUploadFile'],
                [
                    'name'    => 'FileMimeType',
                    'options' => [
                        'mimeType'  => ['image/jpeg', 'image/png', 'image/gif']
                    ]
                ],
                [
                    'name'    => 'FileImageSize',
                    'options' => [
                        'minWidth'  => 128,
                        'minHeight' => 128,
                        'maxWidth'  => 4096,
                        'maxHeight' => 4096
                    ]
                ],
            ],
            'filters'  => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => [
                        'target'=>'./data/uploads',
                        'useUploadName'=>true,
                        'useUploadExtension'=>true,
                        'overwrite'=>true,
                        'randomize'=>false
                    ]
                ]
            ],
        ]);
    }
}