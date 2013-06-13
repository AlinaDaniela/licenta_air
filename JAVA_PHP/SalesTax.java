import java.util.*;

import java.text.*;

public class SalesTax {

public String SalesTax(double price, double salesTax)

{

double tax = price * salesTax;

NumberFormat numberFormatter;

numberFormatter = NumberFormat.getCurrencyInstance();

String priceOut = numberFormatter.format(price);

String taxOut = numberFormatter.format(tax);

numberFormatter = NumberFormat.getPercentInstance();

String salesTaxOut =

numberFormatter.format(salesTax);

String str = "A sales Tax of " + salesTaxOut +

" on " + priceOut + " equals " + taxOut + ".";

return str;

}

}

