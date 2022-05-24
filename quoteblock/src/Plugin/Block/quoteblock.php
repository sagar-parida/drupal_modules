<?php

namespace Drupal\quoteblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block
 * @Block(
 * id = "quoteblock",
 * admin_label = @Translation("Quote Block"),
 * category = @Translation("My example drupal block"),
 * )
 */

 class quoteblock extends BlockBase {
     /**
      * {@inheritdoc}
      */

      public function build(){
          return [
              '#markup'=> $this->getRandomQuote(),
              '#cache' => [
                  'max-age' => 0,
              ]
            ];
      }

      public function getRandomQuote(){
        $quotes = [
            'Honesty is the best policy.',
            'Secret to get ahead is to get started.',
            'Those who know, do. those who understand, teach.'
        ];
        
        return $quotes[array_rand($quotes)];
      }
 }