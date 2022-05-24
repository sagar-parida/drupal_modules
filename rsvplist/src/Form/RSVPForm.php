<?php
/**
  * @file
  * Contains \Drupal\rsvplist\Form\RSVPForm
  */

namespace Drupal\rsvplist\Form;

use Drupal\Core\DataBase\DataBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;



/**
 * Provides an RSVP Email Form
 */
class RSVPForm extends FormBase {
    /**
     * {@inheritdoc}
     */

     public function getFormId(){
         return 'rsvplist_email_form';
     }

     /**
      * {@inheritdoc}
      */

      public function buildForm(array $form, FormStateInterface $form_state) {
          $node = \Drupal::routeMatch()->getParameter('node');
          $nid = $node->nid->value;
          $form['name']= array(
              '#title' => t('Name'),
              '#type' => 'textfield',
              '#size' => 25,
              '#description' => t('We need your name for the invitaion'),
              '#required' => TRUE,
          );
          $form['email']= array(
            '#title' => t('Email'),
            '#type' => 'textfield',
            '#size' => 25,
            '#description' => t('We need your email for the invitaion'),
            '#required' => TRUE,
          );
          $form['submit'] = array(
              '#type' => 'submit',
              '#value' => t('RSVP'),
          );
          $form['nid'] = array(
              '#type' => 'hidden',
              '#value' => $nid,
          );

          return $form;
      }
      /**
       * {@inheritdoc}
       */
      public function validateForm(array &$form, FormStateInterface $form_state){
          $value = $form_state->getValue('email');
          if( $value == !\Drupal::service('email.validator')->isValid($value)){
              $form_state->setErrorByName('email', t('The email address %mail is not valid.',array('%mail' => $value)));
          }
      }

      public function submitForm(array &$form, FormStateInterface $form_state){
        $user = User::load(\Drupal::currentUser()->id());
        $connection = \Drupal::service('database');
        $query = $connection->insert('rsvplist')
            ->fields(['name','mail','nid','uid','created'])
            ->values([
                'name' => $form_state->getValue('name'),
                'mail' => $form_state->getValue('email'),
                'nid' => $form_state->getValue('nid'),
                'uid' => $user->id(),
                'created' => time(),
            ])
            ->execute();

        $message = 'Thank you for your response';
        \Drupal::messenger()->addMessage($message,'status');
        
        }
}