<?php

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
  header('Location: ../../');
  exit;
}


qa_register_plugin_overrides('translator-page-overrides.php'); 

qa_register_plugin_module(
  'page', // type of module
  'translator-page.php', // PHP file containing module class
  'translator_page', // name of module class
  'Translator' // human-readable name of module
);

