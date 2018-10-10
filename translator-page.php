<?php

if (!defined('QA_VERSION')) {
    header('Location: ../../');
    exit;
} 

require_once QA_INCLUDE_DIR.'app/admin.php'; 
require_once QA_INCLUDE_DIR . 'db/admin.php';


class translator_page {

    private $directory;
    private $urltoroot;

    public function load_module($directory, $urltoroot) {
        $this->directory=$directory;
        $this->urltoroot=$urltoroot;
    } 


		function suggest_requests() 
		{	
			return array(
				array(
					'title' => 'Translator', // title of page
					'request' => 'admin/translator', // request name
					'nav' => 'M', // 'M'=main, 'F'=footer, 'B'=before main, 'O'=opposite main, null=none
				),
			);
		}

    public function match_request($request) {
        if(qa_get_logged_in_level() >= QA_USER_LEVEL_ADMIN)
            return $request == 'admin/translator';
        else
            return false;
    } 


    function process_request($request)
    {

      $lParams = explode('/', $request);

//print_r ($lParams);
				
			if (isset ($lParams[2])) {
	      $lLang=$lParams[2];
      } else {
        $lLang='';
	    }
      
        $lEnglishDir = QA_BASE_DIR . '/qa-include/lang/';
        foreach (glob($lEnglishDir . 'qa-lang-*.php') as $lFileName) {
          $lEnglishFiles[basename ($lFileName)] = basename ($lFileName);
        }
        //$lEnglishFiles = glob($lEnglishDir . 'qa-lang-*.php');

//print_r ($lEnglishFiles);
      

      $lLanguages = qa_admin_language_options();
      unset ($lLanguages['']);
      
//print_r ($lLanguages);

//echo "#####" . qa_post_text('file') . "<br>";

      $lCustomLanguage = qa_html(qa_post_text('form_select_language'));
      if (empty ($lCustomLanguage)) {
        reset ($lLanguages);
        $lCustomLanguage = key($lLanguages);
      }
      
      $lLanguageFile = qa_html(qa_post_text('form_select_file'));
      if (empty ($lLanguageFile)) {
        reset ($lEnglishFiles);
        $lLanguageFile = $lEnglishFiles[key($lEnglishFiles)];
      }

      
      $lEnglishLanguageFile = $lEnglishDir . $lLanguageFile;
      $lEnglishTable = include ($lEnglishLanguageFile);
      
//print_r ($EnglishTable);

      
      $lLanguageDir = QA_BASE_DIR . '/qa-lang/' . $lCustomLanguage . '/';
      $lCustomLanguageFile = $lLanguageDir . $lLanguageFile;
      
//echo "lCustomLanguage:$lCustomLanguage<br>";
//echo "lLanguageFile:$lLanguageFile<br>";      
//echo "lCustomLanguageFile:$lCustomLanguageFile<br>";      
      
      if (file_exists ($lCustomLanguageFile)) {

        $lCustomTable = include ($lCustomLanguageFile);

      } else {
        $lCustomTable = array();
      }

//print_r ($lCustomTable);      

      $qa_content=qa_content_prepare();
      $qa_content['custom']='Translate items below'; 

      $qa_content['title']='Translate';

      $qa_content['form']=array(
        'tags' => 'METHOD="POST" ACTION="'.qa_self_html().'"',
         
        'style' => 'tall', // could be 'wide'

        'fields' => array(

          array(
           'type' => 'select',
           'label' => 'Language',
           'options' => $lLanguages,
           'tags' => 'NAME="form_select_language" ID="form_select_language"',
           'value' => $lCustomLanguage,
           'match_by' => 'key'
          ),
        
        
          array(
           'type' => 'select',
           'label' => 'File',
           'options' => $lEnglishFiles,
           'tags' => 'NAME="form_select_file" ID="form_select_file"',
           'value' => $lLanguageFile
          ),
          
        ),

        'buttons' => array(
          array(
            'label' => 'Load',
            'tags' => 'name="form_button_load" id="form_button_load"',
          ),
          array(
            'label' => 'Save',
            'tags' => 'name="form_button_save" id="form_button_save"',
          ),
          
        ),
      );


      
      foreach ($lEnglishTable as $lKey=>$lValue) {
        
        if (isset ($lCustomTable[$lKey])) {
          $lCustomValue = $lCustomTable[$lKey];  
        } else {
          $lCustomValue = '';
        }
        
        if ($lCustomValue == $lValue) {
          $lCustomValue = '';
        }
        
       
        $qa_content['form']['fields'][] = array(
         'type' => 'text',
         'label' => "[$lKey]<br>$lValue",
         'tags' => 'name="' . $lKey . '" id="' . $lKey . '"',
         'value' => $lCustomValue,
        );
      };
      
			 //$qa_content['error']='An example error';


      $qa_content['focusid']='translate';

       //$qa_content['custom_2']='<p><br>More <i>custom html</i></p>';
       
       $qa_content['navigation']['sub'] = qa_admin_sub_navigation();


//echo "<pre>";
//print_r ($_POST);       
//echo "</pre>";

      $lSaveButton = qa_post_text('form_button_save');

//echo "lSaveButton:$lSaveButton<br>";      
      
      if  (! empty ($lSaveButton)) {

        $lItemCounter = 0;

        $lOutput = "<?php\r\n";        
        
        
        $lOutput .= "/*
	File: $lLanguageFile
	Description: Language phrases

  Created using Translator plugin for Question2Answer by Predrag Supurovic
  
*/\r\n\r\n";

        
        $lOutput .= "return array (\r\n\r\n";
        foreach ($lEnglishTable as $lKey=>$lValue) {
          $lCustomValue = qa_post_text($lKey);
          if (! empty ($lCustomValue) && ($lCustomValue <> $lValue)) {
            $lOutput .= "'$lKey' => '" . str_replace("'", "\'", $lCustomValue) . "',\r\n";
            $lItemCounter++;
          }     
        }
        $lOutput .= "\r\n);";
        $lOutput .= "";        

//echo $lOutput;        

        if ($lItemCounter > 0) {

          file_put_contents ($lCustomLanguageFile, $lOutput);
        }
      }

      return $qa_content;
}


}

