# q2a-translator
Question2Answer plugin for online translation of Question2Answer language files

This makes proces of making translations for Question2Answer easier. Insted of manually copying and editing language files, you get option to edit translation phrases on line, through Translation page within Administration section of Question2Answer site.

Works with Question2Answer version 1.8.0. Not tested with earlier versions.

HOW TO USE

First, install this plugin by copying it to qa-plugin directory and enable it using Question2Answer site admin. New menu item named Translator will show up in Admin submenu.

Now, crate new language manually, by creating new directory in qa-language, and setting metadata.json file. You do not have to copy any of the original (english) language files. Other than specified json file, nothing else is needed.

Open Translator. It will show selection of languages (newly created language would be in the list) and selection of language files.

Choose new language and any of language files. Then go to the bottom of the page anc click Load. It will load source language file in English and offer edit fileds for you to write in translated phrases.

After you do some translation (you do not have to translate all phrases), go to the bottom of the page and click Save. It will create custom languiage file for new language containing translated phrases.

And that is all, you may repeat the process for any installed language and any language file.

You can now have comfort of looking site in the language you are editing in one window and editing translation files in other window and see changes in real time.

![q2a-translator](https://user-images.githubusercontent.com/2223601/46084028-fee3ba00-c1a2-11e8-9eba-21b8e8a96fb9.png)

ISSUES

This is my very first plugin for Question2Answer. Documentation for Questin2Answer plugin developers is very short and spartanic so I had to dig a lot to get to the basics. That means, it may be that some things I possibly did in wrong way. But do not worry, it works. Any suggestion to imporove plugin code is welcomme.

I could not find a way to add Load button just below selection of language and language file. Thus, user has to go to the bottom to click that button. Any info how can I add Load button on the top of the form is welcomme.

Do not change selected language and selected language file and then click Save. If you do that you will end up saving translation to the wrong place. Will be fixed.

I noticed that, if qa-lang-admin.php source file is loaded in Translator, it messes up displaying of Admin submenu. I have no clue why that happens. I load that file into local variable within plugin class method so it should not affect anything, but it does. You know the drill: any suggestion is welcome.
