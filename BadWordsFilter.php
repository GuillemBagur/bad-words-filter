<?php

include "./bad_words.php";

class BadWordsFilter {
  private $bad_words;

  public function __construct() {
    global $bad_words;
    $this->bad_words = $bad_words;
  }
  
  private function build_word_regex($word, $full_word) {
    $variations_per_letter = [
      "a" => ["@", "4", "à", "á", "â", "ä", "ã", "å", "α"],
      "b" => ["8", "ß", "ƃ", "β", "v"],
      "c" => ["(", "¢", "ç", "©", "k"],
      "d" => ["ð", "Đ"],
      "e" => ["3", "è", "é", "ê", "ë", "€"],
      "f" => ["ƒ", "ph"],
      "g" => ["9", "ğ", "ġ"],
      "h" => ["#", "ĥ", "ħ"],
      "i" => ["1", "!", "ì", "í", "î", "ï", "|", "l"],
      "j" => ["ʝ", "ĵ"],
      "k" => ["κ", "ķ", "К", "c"],
      "l" => ["1", "|", "ł", "i"],
      "m" => ["м", "ɱ"],
      "n" => ["η", "ñ", "ń", "ņ"],
      "o" => ["0", "ø", "ö", "ô", "ò", "ó", "õ", "ō", "ο"],
      "p" => ["ρ", "þ"],
      "q" => ["9", "զ"],
      "r" => ["ř", "ŕ"],
      "s" => ["$", "5", "§", "ş", "ś"],
      "t" => ["7", "+", "ţ", "ŧ"],
      "u" => ["ù", "ú", "û", "ü", "µ"],
      "v" => ["ν", "ѵ", "b"],
      "w" => ["ω", "ш"],
      "x" => ["×", "χ"],
      "y" => ["¥", "ý", "ÿ"],
      "z" => ["2", "ż", "ź", "ƶ"],
    ];

    $word_regex = "";
    for($i = 0; $i < strlen($word); $i ++) {
      $letter = $word[$i];

      // If letter has variations, append to $word_regex all possible variations
      if(array_key_exists($letter, $variations_per_letter)) {
        $letter_variations = $variations_per_letter[$letter];
        array_push($letter_variations, $letter);
        $letter = implode("", $letter_variations);
        $letter_regex = "[$letter]";

        $word_regex .= $letter_regex;

      } else {
        $word_regex .= $letter;
      }
    }

    if($full_word) {
      // Uses word regex and adds some support for plurals (s?)
      $word_regex = "/\b{$word_regex}s?\b/ui";

    } else {
      // If we don't want to support the full word, we will only check \b at the begginning of the word
      $word_regex = "/\b{$word_regex}/ui";
    }

    return $word_regex;
  }

  private function check_has_bad_words_nouns($string) {
    foreach($this->bad_words["nouns"] as $bad_word) {
      $bad_word_regex = $this->build_word_regex($bad_word, true);

      if(preg_match($bad_word_regex, $string)) {
        return true;
      }
    }

    return false;
  }

  // Only supports Spanish
  private function check_has_bad_words_verbs($string) {
    foreach($this->bad_words["verbs"] as $bad_word) {
      // As all the verbs are infinitive, they end with r.
      // Can be a good approach to remove the last letter to check for conjugations
      $bad_word = substr($bad_word, 0, strlen($bad_word) -1);

      // We don't check for the whole word, as we are seeking conjugations
      $bad_word_regex = $this->build_word_regex($bad_word, false);

      if(preg_match($bad_word_regex, $string)) {
        return true;
      }
    }

    return false;
  }

  private function check_has_urls($string) {
    $url_regex = "/((https?:\/\/|www\.)[a-zA-Z0-9-]+(\.[a-zA-Z]{2,})(:[0-9]{1,5})?(\/\S*)?)/i"; // From ChatGPT. Supports ports and paths

    return preg_match($url_regex, $string);
  }

  private function check_has_html($string) {
    $html_regex = "/<[^>]+>/ui";

    return preg_match($html_regex, $string);
  }

  public function check($string) {
    $string = strtolower($string);

    $is_valid = !$this->check_has_urls($string)
              & !$this->check_has_html($string)
              & !$this->check_has_bad_words_nouns($string)
              & !$this->check_has_bad_words_verbs($string);

    return $is_valid;
  }
}