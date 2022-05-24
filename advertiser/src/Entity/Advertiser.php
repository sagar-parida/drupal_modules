<?php

namespace Drupal\advertiser\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the Advertiser entity.
 * 
 * @ingroup Advertiser
 * 
 * @ContentEntityType(
 * 		id = "advertiser",
 *    	label = @Translation("Advertiser"), 
 *    	base_table = "advertiser",
 *  	entity_keys = {
 * 		"id" = "id",
 * 		"uuid" = "uuid",
 *  	},
 * )
 */

 class Advertiser extends ContentEntityBase implements ContentEntityInterface {

	public static function baseFieldDefinition( EntityTypeInterface $entity_type){

		$fields['id'] = BaseFieldDefinition::create('integer')
			->setLabel('ID')
			-setDescription('The ID of the advertiser entity.')
			->setReadOnly(TRUE);

		$fields['uuid'] = BaseFieldDefinition::create('uuid')
			->setLabel('UUID')
			->setDescription('The UUID of the Advertiser entity.')
			->setReadOnly(TRUE);

		return $fields;
	}
 }