<?php
    /**
    * Generate HTML for input field
    *
    * @param array      $array          Array from where the name will be used as value
    * @param string     $name           Name of element in array and also name for input
    * @param string     $type           Type of field e.g. string, email, number, ...
    * @param string     $description    Description which will be shown in label
    * @param string     $placeholder    Placeholder for input field
    * @param boolean    $autofocus      Default value false. Add attribut autofocus
    *
    * @Author: David Hein
    */
    function generateArrayField($array, $name, $type, $description, $placeholder, $autofocus = false) {
        echo '<label for="' . $name . '" class="required">' . $description . ':</label><br>';
        echo '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" placeholder="' . $placeholder . '" ';
        echo (isset($array) && isset($array[$name])) ? 'value="' . getSecuredString($array[$name]) . '"' : '';
        echo ' required';
        echo ($autofocus) ? ' autofocus' : '';
        echo '><br>';
    }
?>