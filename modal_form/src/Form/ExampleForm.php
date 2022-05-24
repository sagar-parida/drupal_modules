<?php

namespace Drupal\modal_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * ExampleForm class
 */

 class ExampleForm extends FormBase {

    /**
     * {@inheritdoc}
     */

     public function buildForm(array $form, FormStateInterface $form_state, $options = NULL){
         $form['open_modal'] = [
             '#type' => 'link',
             '#title' => $this->t('Open Modal'),
             '#url' => Url::fromRoute('modal_form.open_modal_form'),
             '#attributes' => [
                 'class' => [
                     'use-ajax',
                     'button',
                 ],
                ],
            ];

            $form['#attached']['library'][] = 'core/drupal.dialog.ajax';

            return $form;
     }

     public function submitForm(array &$form, FormStateInterface $form_state){

     }

     public function getFormId(){
         return 'modal_form_exampe_form';
     }
 }