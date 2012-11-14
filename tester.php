<?php

include_once(realpath(dirname(__FILE__)).'/lib/template.php');

$tpl = new Template(realpath(dirname(__FILE__)).'/tester.tpl');
$tpl->set('page title', 'Template Engine Test');
$tpl->set('body', 'some body content');
print $tpl->render();