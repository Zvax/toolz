<?php

namespace Toolz;

interface Templating {
    public function render($template, array $values = []);
}
