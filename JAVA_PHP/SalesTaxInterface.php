#!/bin/env php

<?php

require_once("java/Java.inc");

include("wsimport.php");

try {

$addNumbersService = new java("org.duke.AddNumbersService");

$port = $addNumbersService->getAddNumbersPort();

$number1 = 10;

$number2 = 20;

echo ("Invoking one-way operation. Nothing is returned from service.\n");

$port->oneWayInt($number1);

echo ("Invoking addNumbers($number1, $number2)\n");

$result = $port->addNumbers($number1, $number2);

echo ("The result of adding $number1 and $number2 is $result\n\n");

$number1 = -10;

echo ("Invoking addNumbers($number1, $number2)\n");

$result = $port->addNumbers($number1, $number2);

echo ("The result of adding $number1 and $number2 is $result\n\n");

} catch (JavaException $ex) {

$ex = $ex->getCause();

if (java_instanceof($ex, java("org.duke.AddNumbersFault_Exception"))) {

$info = $ex->getFaultInfo()->getFaultInfo ();

echo ("Caught AddNumbersFault_Exception: $ex, INFO: $info.\n");

} else {

echo ("Exception occured: $ex\n");

}

}

?>
<?php

// Format the HTML form.

$salesTaxForm = <<<SalesTaxForm

<form action="SalesTaxInterface.php" method="post">

Price (ex. 42.56):

<input type="text" name="price" size="15" maxlength="15" value="">

Sales Tax rate (ex. 0.06):

<input type="text" name="tax" size="15" maxlength="15" value="">

<input type="submit" name="submit"

value="Calculate!">

</form>

SalesTaxForm;

if (! isset($submit)) :

echo $salesTaxForm;

else :

// Instantiate the SalesTax class.

$salesTax = new Java("SalesTax");

// Don't forget to typecast in order to

// conform with the Java method specifications.

$price = (double) $price;

$tax = (double) $tax;

print $salesTax->SalesTax($price, $tax);

endif;

?>

