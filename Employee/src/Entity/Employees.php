<?php

namespace Drupal\Employee\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 *  Defines the employee entity.
 * 
 *  @ingroup employee
 * 
 *  @ContentEntityType(
 *      id = "employee",
 *      label = @Translation("Employee"),
 *      base_table = "employee",
 *      entity_keys = {
 *          "id" = "id",
 *          "name" = "name",
 *          "dob" = "dob",
 *          "email" = "email",
 *          "employeeNum" = "employeeNum",
 *          "location"= "location"
 *      },
 *  )
 */
class Employees extends ContentEntityBase implements ContentEntityInterface {
    /**
     * Function baseFieldsDefinitions to create entity fields.
     */

     public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
         //Standard field, used as unique if primary index.
         $fields['id'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('ID'))
            ->setDescription(t('The ID of a employee'))
            ->setSettings([
                'max_length' => 10,
                'text_processing' => 0,
            ])
            ->setReadOnly(TRUE);

        $fields['name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Name'))
            ->setDescription(t('Name of the Employee'))
            ->setSettings([
                'max_length' => 100,
            ]);

        $fields['dob'] = BaseFieldDefinition::create('string')
            ->setLabel(t('DOB'))
            ->setDescription(t('Date of birth'))
            ->setSettings([
                'max_length' => 100,
            ]);
        
        $fields['email'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Email'))
        ->setDescription(t('Email of the employee'))
        ->setSettings([
            'max_length' => 100,
        ]);

        $fields['employeeNum'] = BaseFieldDefinition::create('integer')
        ->setLabel(t('Employee Number'))
        ->setDescription(t('Employee Number of the Employee'))
        ->setSettings([
            'max_length' => 100,
        ]);

        $fields['location'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Location'))
        ->setDescription(t('Base Location of the employee'))
        ->setSettings([
            'max_length' => 100,
        ]);

        return $fields;
     }
}