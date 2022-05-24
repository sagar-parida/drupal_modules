<?php

namespace Drupal\team_members\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class MemberController extends ControllerBase {
    public function createEmployee(){
        $form = \Drupal::formBuilder()->getForm('Drupal\team_members\Form\MemberForm');
      
        return [
            '#theme'=>'team_members',
            '#items'=> $form
        ];
    }

    public function getTeamList(){
        $limit = 3;
        $connection = \Drupal::service('database');
        $result = $connection->select('team_members','t')
            ->fields('t',['id','name','employeeNum','email','location','dateofbirth'])
            ->execute()->fetchAll(\PDO::FETCH_OBJ);

        $data = [];
        $count = 0;

        $params = \Drupal::request()->query->all();

        if(empty($params) || $params['page'] == 0){
            $count = 1;
        }else if($params['page'] == 1){
            $count = $params['page'] + $limit;
        }else{
            $count = $params['page'] + $limit;
            $count++;
        }

        
        foreach( $result as $row){
            

            $data[] = [
                'id' => $count,
                'name' => $row->name,
                'employeeNum' => $row->employeeNum,
                'email' => $row->email,
                'location' => $row->location,
                'dob'=> $row->dateofbirth,
                'view'=> t("<a href='view-member/$row->employeeNum'>View</a>"),
                'edit'=>t("<a href= 'edit-member/$row->id'>Edit</a>"),
                'delete'=>t("<a href= 'delete-member/$row->id'>Delete</a>"),
            ];
           $count++;
        }


        $header = array('Sl.No','Name','Employee No','Email','Location','DOB','Files','Edit','Delete');

        $build['table'] = [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $data,
            '#attributes' => [
                'id' => 'myTable'
            ]
        ];


        return [
            $build,
            '#title' => 'Member List'
        ];


        // $variables = array(
        //     'attributes' => $attributes,
        //     'header' => $header,
        //     'rows'=> $data,
        // );


        // $output = theme('datatable',$variables);
    }

    public function deleteEmployee($id){
        $query = \Drupal::database();
        $query->delete('team_members')
            ->condition('id',$id,'=')
            ->execute();

        $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../team-list');
        $response->send();
    }

    public function viewEmployee($eno){
        $query = \Drupal::database();
        $data = $query->select('team_members','t')
            ->fields('t',['id','name','employeeNum','dateofbirth','email','location'])
            ->condition('t.employeeNum',$eno,'=')
            ->execute()->fetchAll(\PDO::FETCH_OBJ);
    
        $urls = $query->select('team_members_data','td')
            ->fields('td',['url'])
            ->condition('td.employeeNum',$eno,'=')
            ->execute()->fetchAll(\PDO::FETCH_OBJ);
        foreach ($urls as $key=>$url){
            $data[0]->links[$key] = $url->url;
        }
        // echo "<pre>";
        // print_r($data[0]);
        // exit;
        return [
            '#theme'=>'view_members',
            '#items'=> $data[0],
        ];
    }
}