<!DOCTYPE html>
<html>


<body>

<?php

// displaying data

echo 'Rosemarie S. Guirre';
echo "<br>ROSEMARIE S. GUIRRE";
echo '<hr>';
echo "<hr>";


// variable is a container for storing information, can store numerical and text data 

// in PHP must start with a $sign + the name

//must start with letter or underscore.. cannot be start with number, variable are case sensitive

// echo is for the output of data or statement.


//setting the variable

$fullname = "ROSEMARIE S. GUIRRE";

echo $fullname;
echo '<br>fullname';
echo " <br>$fullname";
echo '<br>$fullname';
echo '<hr>';

//setting the variable with operation

$rose = 15;
$guirre = 5;

$guirre =20.5;
$guirreSum = $rose + $guirre;
$guirreDifference= $rose - $guirre;
$guirreProduct= $rose * $guirre;
$guirreQuotient= $rose / $guirre;
$guirreNumber1 = number_format($guirreQuotient, 2);
$guirreNumber = sprintf('%.2f', $guirreQuotient);

//number_format($guirreQuotient, 2);

echo "ADDITION";
echo "<br>";
echo "First Number: $rose";
echo "<br>";
echo "Second Number:" ,$guirre;
echo "<br>";
echo "Addition:" ,$guirreSum;
echo "<hr>";

echo "DIFFERENCE";
echo "<br>";
echo "First Number:" ,"$rose";
echo "<br>";
echo "Second Number:" ,$guirre;
echo "<br>";
echo "Difference:" ,$guirreDifference;
echo "<hr>";


echo "PRODUCT";
echo "<br>";
echo "First Number:" ,"$rose";
echo "<br>";
echo "Second Number:" ,$guirre;
echo "<br>";
echo "Product:" ,$guirreProduct;
echo "<hr>";

echo "QUOTIENT";
echo "<br>";
echo "First Number:" ,"$rose";
echo "<br>";
echo "Second Number:" ,$guirre;
echo "<br>";
echo "Quotient:" ,$guirreNumber;
echo "Quotient:" ,$guirreNumber1;

echo "<hr>";

//adding variable to Text
$guirreHobby= "Programming";
echo "Hobby <br>";
echo "I like $guirreHobby!";
echo "<hr />";

//adding variable to Text wrong variable
$guirreHobby= "Programming";
echo "I like $GuirreHobby!";
echo "<hr />";

//Variable concantenate
$guirreVar1 ="Rosemarie";
$guirreVar2 ="Sibbaluca";
$guirreVar3 ="Guirre";

echo "<hr> $guirreVar1 $guirreVar2 $guirreVar3" ;

//Variable equal to variable

$guirreVar1 = $guirreVar2;
$guirreVar2 = $guirreVar3;

echo " $guirreVar1 <br>";
echo " $guirreVar2 <br>";
echo " $guirreVar3 </hr>";

?>

</body>
</html>