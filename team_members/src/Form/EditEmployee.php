<?php
/**
  * @file
  * Contains \Drupal\team_members\Form\MemberForm
  */
namespace Drupal\team_members\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class EditEmployee extends FormBase {
    /**
     * {@inheritdoc}
     */

     public function getFormId(){
         return 'edit_employee';
     }

     /**
      * {@inheritdoc}
      */

      public function buildForm(array $form, FormStateInterface $form_state){

        $id = \Drupal::routeMatch()->getParameter('id');
        $query = \Drupal::service('database');
        $data = $query->select('team_members','t')
            ->fields('t',['id','name','employeeNum','dateofbirth','email','location'])
            ->condition('t.id',$id,'=')
            ->execute()->fetchAll(\PDO::FETCH_OBJ);

        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name'),
            '#required'=> TRUE,
            '#default_value'=>$data[0]->name
        );

        $form['employeeNum'] = array(
            '#type' => 'textfield',
            '#title' => t('Employee ID'),
            '#required'=> TRUE,
            '#default_value'=>$data[0]->employeeNum
        );
        $form['dateofbirth'] = array(
            '#type' => 'date',
            '#title' => t('Date of birth'),
            '#required' => TRUE,
            '#default_value'=>$data[0]->dateofbirth,
        );

        $form['email'] = array(
            '#type' => 'textfield',
            '#title' => t('E-mail'),
            '#required'=> TRUE,
            '#default_value'=>$data[0]->email
        );

        $form['location'] = array(
            '#type' => 'textfield',
            '#title' => t('Location'),
            '#required'=> TRUE,
            '#default_value'=>$data[0]->location
        );

        $form['file_upload'] = array(
            '#type' => 'managed_file',
            '#title' => t('Attach Files'),
            '#upload_location' => 'public://photos',
            '#multiple' => TRUE,
        );

        $form['save'] = array(
            '#type' => 'submit',
            '#value' => 'Update Employee',
            '#button_type' => 'primary'
        );

        return $form;
    }

      /**
       * {@inheritdoc}
       */

       public function submitForm(array &$form, FormStateInterface $form_state){

            $files = $form_state->getValue('file_upload');
            $uris = array();

            $connection = \Drupal::database();


            foreach ($files as $fid){
                $file = \Drupal\file\Entity\File::load($fid);
                // $file->setPermanent();
                // $file->save();

                $url = $file->createFileUrl();
                $query = $connection->insert('team_members_data')
                    ->fields([
                        'employeeNum' => $form_state->getValue('employeeNum'),
                        'url' => $url,
                    ])
                    ->execute();

            }

            // echo "<pre>";
            // print_r($uri);
            // exit;

            $id = \Drupal::routeMatch()->getParameter('id');
            $query = $connection->update('team_members')
                ->fields([
                    'name' => $form_state->getValue('name'),
                    'employeeNum' => $form_state->getValue('employeeNum'),
                    'email' => $form_state->getValue('email'),
                    'location' => $form_state->getValue('location'),
                    'created' => time(),
                    'dateofbirth' => $form_state->getValue('dateofbirth'),
                ])
                ->condition('id',$id,'=')
                ->execute();

                $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../team-list');
                $response->send();

                $message = 'Updated Successfully';
                \Drupal::messenger()->addMessage($message,'status');
        
       }
}
