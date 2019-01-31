<!----------------------------Search Food Type-------------------------->

<?php

include("config.php");

$connect = new PDO("mysql:host=localhost;dbname=ezdine", "root", "");
if(isset($_POST['query'])){
if($_POST["query"]!='')
{
  $search_array = explode(",", $_POST["query"]);
  $search_text = "'" . implode("', '", $search_array) . "'";
  $query="SELECT*FROM menu WHERE foodtype IN(".$search_text.") ORDER BY foodname";
}
else{

$query="SELECT*FROM menu ORDER BY foodname";

}


$statement = $connect->prepare($query);

$statement->execute();

$result=$statement->fetchAll();

$total_row=$statement->rowCount();

$output ='';

if($total_row>0)
{
  foreach($result as $row)
  {
    $output .="<input name=\"order\" type=\"button\" class=\"button\" onclick='insertOrder(\"".$row['foodid']."\")' id='".$row["foodid"]."' value='".$row["foodname"]."'  ></input>";
  }
}
else
{
  $output .="NO DATA FOUND";
}
echo $output;

}
//------------------------------Send Order------------------------------>


//-------------------------Delete Order detail--------------------------->




//--------------------------Get insertOrder command----------------------->



$conn->close();
?>






<!---------------------------AJAX append food detail------------------------------->
<script type="text/javascript">
	var foodlist = new Array();
	var stackedArray = 0;

	//Check if item exist in array
	function checkArray(item, list)
	{
		for(i=0; i<list.length; i++)
		{
			if(list[i].id === item)
			{
				stackedArray = i;
				return true;
			}

		}

		return false;
	}

	//Round off function
	function roundNumber(num, scale) {
	  if(!("" + num).includes("e")) {
	    return +(Math.round(num + "e+" + scale)  + "e-" + scale);
	  } else {
	    var arr = ("" + num).split("e");
	    var sig = ""
	    if(+arr[1] + scale > 0) {
	      sig = "+";
	    }
	    return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
	  }
	}



  function insertOrder(id)
  {
   var foodid = id;	//get id

   var tableID = $('#getTableID').val(); //get table ID


    $.ajax(
    {
      method: 'POST',
      url: 'insertOrder.php',
      data: {insertOrder:'insertOrder', posID:id, tableID:tableID},

      success: function(html)
      {

      		if(checkArray(foodid, foodlist)=== true)
      		{
      			// SET price and quantity variable

      			var price = Number($('.price'+foodid).val());
      			var quantity = Number($('.quantity'+foodid).val());

      			//Stack

      			//Increase the quantity
      			$('.quantity'+foodid).val(++quantity);
      			foodlist[stackedArray].quantity = quantity;
      			console.log("Quantity change successfully");

      			//Increase price

      			var totalPrice = foodlist[stackedArray].singlePrice * quantity;
      			foodlist[stackedArray].price = roundNumber(totalPrice, 2);;
      			$('.price'+foodid).val(totalPrice);

      			console.log("Price change successfully");

      		}

      		else
      		{

      		// append new item
	        $('#order_detail').append(html);

	        var price = Number($('.price'+foodid).val());
	        var quantity = Number($('.quantity'+foodid).val());
	        var obj = {id:foodid, price:price, quantity:quantity, singlePrice:price};

	        foodlist.push(obj);

	        // auto scroll down when append new item
	        $('#order_detail').animate(
	        {
	          scrollTop:$('#order_detail')[0].scrollHeight
	        }, "fast");

	   		console.log("Append new item successfully");
	   		console.log(foodlist);


      		}


	   }



    });

  };
</script>

<!----------------------------Remove append thing------------------------------>
