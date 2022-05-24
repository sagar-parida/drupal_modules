<?php

namespace Drupal\popup\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block
 * @Block(
 * id = "popup",
 * admin_label = @Translation("Popup Block"),
 * category = @Translation("My example drupal block"),
 * )
 */

 class popup extends BlockBase {
     /**
      * {@inheritdoc}
      */

      public function build(){
          $text = '<a href="/test" class="use-ajax" data-dialog-type="modal">Drupal Dialog</a>';
          
          return [
              '#markup'=> $text,
              '#attached' => array(
                  'library' => array(
                      'core/drupal.dialog.ajax',
                      'core/jquery.form',
                  ),
                ),
            ];
        }
 }