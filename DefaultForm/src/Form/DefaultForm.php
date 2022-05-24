<?php

namespace Drupal\defaultForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;

/**
 * Provides a Default Form
 */

 class DefaultForm extends FormBase {
     /**
      * {@inheritdoc}
      */

      public function getFormId() {
          return 'default_form';
      }

      /**
       * {@inheritdoc}
       */

       public function buildForm(array $form, FormStateInterface $form_state){
           // Create a select field that will update the contents
           // of the textbox below

       $form['example_select'] = [
           '#type' => 'select',
           '#title' => $this->t('Select Element'),
           '#options' => [
               '1' => $this->t('One'),
               '2' => $this->t('Two'),
               '3' => $this->t('Three'),
               '4' => $this->t('Four'),
           ],
           '#ajax' => [
               'callback' => '::myAjaxCallback',
               'disable-refocus' => FALSE,
               'event' => 'change',
               'wrapper' => 'edit-output',
               'progress' => [
                   'type' => 'throbber',
                   'message' => $this->t('Verifying Entry...'),
               ],
           ]
        ];

        $form['output'] = [
            '#type' => 'textfield',
            '#size' => '60',
            '#disabled' => TRUE,
            '#value' => 'Hello Drupal',
            '#prefix' => '<div id="edit-output">',
            '#suffix' => '</div>'
        ];
        


        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ];

        return $form;
 }

 /**
  * {@inheritdoc}
  */

 public function myAjaxCallback(array &$form, FormStateInterface $form_state){
     
    $markup = 'nothing selected';
    
    if($selectedValue = $form_state->getValue('example_select')){
         
        $selectedText = $form['example_select']['#options'][$selectedValue];

         $markup = "<h1>$selectedText</h1>";
     }

     $elem = [
         '#type' => 'textfield',
         '#size' => '60',
         '#disabled' => TRUE,
         '#value' => "I am a new textField: $selectedText!",
         '#attributes' => [
             'id' => ['edit-output'],
         ],
        ];
    

    $dialogText['#attached']['library'][] = 'core/drupal.dialog.ajax';

    $dialogText['#markup'] = "You selected: $selectedText";

    $response = new AjaxResponse();

    $response-> addCommand(new ReplaceCommand('#edit-output',$elem));

    $response->addCommand(new OpenModalDialogCommand('My title', $dialogText, ['width' => '300']));

    return $response;
 }

  public function submitForm(array &$form, FormStateInterface $form_state) {
      //Display Result
      foreach ($form_state->getValues() as $key => $value){
          \Drupal:: messenger()->addStatus($key . ': ' . $value);
      }
  }
}