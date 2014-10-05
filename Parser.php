<?php

class Parser
{
  public function arrange(array $tokens)
  {
    $tokens = array_filter($tokens, function($token) {
      return $token[0] !== 'whitespace';
    });

    $tokens = array_values($tokens);

    $items = [];

    search:

    foreach ($tokens as $i => $token) {
      if (count($token) > 1) {
        if ($token[0] == 'type' or $token[1] == 'identity') {
          $nextTerminator = $this->nextToken($tokens, 'terminator');

          $slice = array_slice($tokens, 0, $nextTerminator + 1);

          array_push($items, [
            'definition', $slice
          ]);

          $tokens = array_slice($tokens, count($slice));
        }
      }
    }

    return [$items, $tokens];
  }

  protected function nextToken(array $tokens, $type) {
    foreach ($tokens as $i => $token) {
      if ($token[0] == $type) {
        return $i;
      }
    }

    return -1;
  }

  public function parse(array $tokens) {
    $tokens = $this->arrange($tokens)[0];

    $nodes = [];

    foreach ($tokens as $i => $token) {
      if ($token[0] == 'definition') {
        if (count($token[1]) > 3) {
          array_push($nodes, new DefinitionNode(
            $token[1][0][1],
            $token[1][1][1],
            $token[1][3][1]
          ));
        } else {
          array_push($nodes, new DefinitionNode(
            $token[1][0][1],
            $token[1][1][1]
          ));
        }

        unset($tokens[$i]);
      }
    }

    return [$nodes, $tokens];
  }
}
