<?php
/**
  * @file
  * Contains \Drupal\team_members\Form\MemberForm
  */
namespace Drupal\team_members\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class MemberForm extends FormBase {
    /**
     * {@inheritdoc}
     */

     public function getFormId(){
         return 'create_member';
     }

     /**
      * {@inheritdoc}
      */

      public function buildForm(array $form, FormStateInterface $form_state){

        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name'),
            '#required'=> TRUE,
            '#attributes'=>array(
                'placeholder'=>'Name'
            )
        );

        $form['employeeNum'] = array(
            '#type' => 'textfield',
            '#title' => t('Employee ID'),
            '#required'=> TRUE,
            '#attributes'=>array(
                'placeholder'=>'Employee ID'
            )
        );

        $form['dateofbirth'] = array(
            '#type' => 'date',
            '#title' => t('Date of birth'),
            '#required' => TRUE,
        );
        $form['email'] = array(
            '#type' => 'textfield',
            '#title' => t('E-mail'),
            '#required'=> TRUE,
            '#attributes'=>array(
                'placeholder'=>'E-mail'
            )
        );

        $form['location'] = array(
            '#type' => 'textfield',
            '#title' => t('Location'),
            '#required'=> TRUE,
            '#attributes'=>array(
                'placeholder'=>'Location'
            )
        );

        $form['file_upload'] = array(
            '#type' => 'managed_file',
            '#title' => t('Attach Files'),
            '#upload_location' => 'public://photos',
            '#multiple' => TRUE,
        );

        $form['save'] = array(
            '#type' => 'submit',
            '#value' => 'Save Employee',
            '#button_type' => 'primary'
        );

        return $form;
    }

      /**
       * {@inheritdoc}
       */

       public function submitForm(array &$form, FormStateInterface $form_state){

            $image = $form_state->getValue('file_upload');
            $file = \Drupal\file\Entity\File::load($image[0]);
            $file->setPermanent();
            $file->save();

            $uri = $file->getFileUri();

            $connection = \Drupal::service('database');
            $query = $connection->insert('team_members')
                ->fields(['name','employeeNum','email','location','created','dateofbirth'])
                ->values([
                    'name' => $form_state->getValue('name'),
                    'employeeNum' => $form_state->getValue('employeeNum'),
                    'dateofbirth' => $form_state->getValue('dateofbirth'),
                    'email' => $form_state->getValue('email'),
                    'location' => $form_state->getValue('location'),
                    'created' => time(),
                ])
                ->execute();

                $message = 'New Member added Successfully';
                \Drupal::messenger()->addMessage($message,'status');
        
       }
}
