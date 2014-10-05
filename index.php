<?php

require("Lexer.php");
require("Parser.php");
require("DefinitionNode.php");

$lexer = new Lexer();

$results = $lexer->tokenize("
  integer age = null;
  integer minutes = 45;
");

$parser = new Parser();

$results = $parser->parse($results[0]);

$context = [];

foreach ($results[0] as $node) {
  print $node->renderWithContext($context);
}
