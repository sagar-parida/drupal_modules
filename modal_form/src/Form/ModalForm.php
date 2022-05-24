<?php

namespace Drupal\modal_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * ModalForm class.
 */

 class ModalForm extends FormBase {

    /**
     * {@inheritdoc}
     */

     public function getFormId() {
         return 'modal_form_example_modal_form';
     }

     public function buildForm(array $form, FormStateInterface $form_state, $options = NULL) {
         $form['#prefix'] ='<div id="modal_form">';
         $form['#suffix'] ="</div>";

         $form['status_messages'] = [
             '#type' => 'status_messages',
             '#weight' => -10,
         ];

         $form['email_box'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Enter email to sign up for Email Notification'),
            '#required' => TRUE,
        ];
         $form['our_checkbox'] = [
             '#type' => 'checkbox',
             '#title' => $this->t('I Agree to sign up for email notifications!'),
             '#required' => TRUE,
         ];

         $form['actions'] = array('#type' => 'actions');
         $form['actions']['send'] = [
             '#type' => 'submit',
             '#value' => $this->t('Submit Modal Form'),
             '#attributes' => [
                 'class' => [
                     'use-ajax',
                 ],
                ],
                '#ajax' => [
                    'callback' => [$this, 'submitModalFormAjax'],
                    'event' => 'click',
                ],
            ];


            $form['#attached']['library'][] = 'core/drupal.dialog.ajax';

            return $form;
     }

     public function submitModalFormAjax(array $form, FormStateInterface $form_state){

        $response = new AjaxResponse();

        if($form_state->hasAnyErrors()){
            $response->addCommand(new ReplaceCommand('#modal_form',$form));
        }
        else{
            $response->addCommand(new OpenModalDialogCommand("Success!","You have been signed up for E-mail notifications",['width' => '800']));
        }

        return $response;
     }

     public function validateForm(array &$form, FormStateInterface $form_state){
         $value = $form_state->getValue('email_box');
         if( $value == !\Drupal::service('email.validator')->isValid($value)){
             $form_state->setErrorByName('email_box',t("The email address $value is not valid"));
         }
     }

     public function submitForm(array &$form, FormStateInterface $form_state){
         
     }
 }