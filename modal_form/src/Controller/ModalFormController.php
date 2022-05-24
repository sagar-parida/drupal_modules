<?php

namespace Drupal\modal_form\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;

/**
 * ModalFormController Class
 */

 class ModalFormController extends ControllerBase {
     /**
      * The form builder
      *
      * @var \Drupal\Core\Form\Form\FormBuilder
      */

      protected $formBuilder;

      /**
       * The ModalFormExampleController constructor
       * 
       * @param \Drupal\Core\Form\FormBuilder $formBuilder
       *    The form builder
       */

       public function __construct(FormBuilder $formBuilder){
           $this->formBuilder = $formBuilder;
       }

       /**
        * {@inheritdoc}
        */

        public static function create(ContainerInterface $container) {
            return new static (
                $container->get('form_builder')
            );
        }

        public function openModalForm() {
            $response = new AjaxResponse();

            $modal_form = $this->formBuilder->getForm('Drupal\modal_form\Form\ModalForm');

            $response->addCommand(new OpenModalDialogCommand('Email Notification',$modal_form, ['width' => '800']));

            return $response;
        }
 }

