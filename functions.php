<?php
function checkInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}
