<?php

class DefinitionNode
{
  protected $type;

  protected $identity;

  protected $value;

  public function __construct($type, $identity, $value = null)
  {
    $this->type     = $type;
    $this->identity = $identity;
    $this->value    = $value;
  }

  public function applyToContext(array $context)
  {
    $context[$this->identity] = null;

    if ($this->value) {
      $context[$this->identity] = $this->value;
    }

    return $context;
  }

  public function renderWithContext(array $context)
  {
    $results = '$' . $this->identity;

    if ($this->value) {
      $results .= ' = ' . $this->value;
    }

    return $results . ";\n";
  }
}
