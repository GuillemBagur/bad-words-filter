<?php

include "./words.php";

class BadWordsFilter {
  private $words;
  
  public function build_word_regex($word) {
    $letter_variations = [
      "a" => ["@", "4"],
      "b" => ["6", "v"],
      "c" => ["k"]
    ];

    for($i = 0; $i < strlen($word); $i ++) {
      $letter = $word[$i];

      if(array_key_exists($letter, $letter_variations)) {
        
      }
    }

    $word_regex = "/$word/i";    

  }

  function check() {
    
  }
}