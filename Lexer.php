<?php

class Lexer
{
  public function tokenize($source)
  {
    $patterns = [
      'type'       => '(integer)',
      'assign'     => '(=)',
      'number'     => '([0-9.]+)',
      'whitespace' => '(\s+)',
      'terminator' => '(;)',
      'identity'   => '([a-zA-Z][a-zA-Z0-9_]+)'
    ];

    $tokens = [];

    search:

    foreach ($patterns as $type => $pattern) {
      preg_match('#^' . $pattern . '#', $source, $matches);

      if (count($matches) > 0) {
        array_push($tokens, [
          $type,
          $matches[1]
        ]);

        $source = substr($source, strlen($matches[1]));

        goto search;
      }
    }

    return [$tokens, $source];
  }
}
