<?php
/**
* Additional user custom fields
* EXAMPLE
* rename this file in "customfields.php" and adjust the attributes
*/
$customfields = array(
    'text-example' => array(      // Attribute name
        'name' => 'Text input title', // Label text
        'type' => 'text',    // input type
        'list' => true,     // show inside users table list (default false)
    ),
    'select-example' => array(
        'name' => 'Select title',
        'type' => 'select',
        'options' => array(
            'option01' => 'First Option', // value => select text
            'option02' => 'Second Option',
        ),
        'multiple' => false,
    ),
    'textarea-example' => array(
        'name' => 'Text area title',
        'type' => 'textarea',
    ),
);

/**
* use this code inside template parts
* Print 'text-example' attribute from specific user 'jondoe'.
*/
// $getuser = Utils::getCurrentUser('jondoe'); 
// if (isset($getuser['text-example'])){
//     echo $getuser['text-example'];
// }
/**
* Print 'text-example' attribute from current logged user.
*/
// echo GateKeeper::getUserInfo('text-example'); 