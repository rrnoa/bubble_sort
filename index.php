<!DOCTYPE html>
<html>
<head style="padding: 0;">
	<title></title>	 
	 <script
			  src="https://code.jquery.com/jquery-1.12.4.min.js"
			  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
			  crossorigin="anonymous"></script>
</head>

<style type="text/css">
	.highlight {
		border: 3px solid #ff0000
	}
	.grove {
		border: 1px solid #00bc2f
	}
	.center{
		margin-left: auto;
		margin-right: auto;
	}
	.disable{
		visibility: hidden;
	}
	.button{
		position: relative;
		float: left;
	}
	.sorted{
		background-color:  #00bc2f;
		border: 1px solid #00bc2f;
	}
	
</style>
<body id="body" style="margin: 0;" >
	<div style="padding: 20px 40px 0px;">
		<form id="form_table" action="" method="post">
	<table class="center" >
		<?php 
		$index_i_value = index_i();
		$index_j_value = index_j($index_i_value);
		?>

		<?php for ($i = 0 ; $i < 10 ; $i++):?>
		<tr>
			<?php $item_value = item_swap($i);?>
			<td >
				<div class="<?=highlight($i,$index_j_value)?> center <?=$i>10-$index_i_value || $_POST["index_i"]  == 9?"sorted":"normal"?>" style="width:<?=$item_value*3;?>px; min-width: 10px;text-align: center;">
				<?=$item_value;?>
				</div>
				<input type="hidden"  name="<?=$i?>"  value="<?=$item_value?>"><br>
			</td>
		</tr>
		<?php endfor;?>

		<!--keep track of index i and j -->
		<input id="index_i" type="hidden" name="index_i"  value="<?=$index_i_value?>">
		<input id="index_j" type="hidden" name="index_j"  value="<?=$index_j_value?>">
		
	</table>
  
  <input type="submit" class="<?=disable()?> button" value="Step">
 
</form>
	</div>

<button onclick="shuffle()" class="button">Shuffle</button>
<button id="play" class="button">Play</button>

<?php 


function item_swap($position){
	if(!isset($_POST[$position])) return mt_rand(0,100);
	else if ($position == $_POST["index_j"] && $_POST[$position] < $_POST[$position+1]){
		$swap = $_POST[$position];
		$_POST[$position] = $_POST[$position+1];
		$_POST[$position+1] = $swap;
	}
	return $_POST[$position];
}

function disable(){
	if(isset($_POST["index_i"]) && $_POST["index_i"]  == 9) 
		return "disable";
}


function highlight($indice,$index_j){	
	if ($indice == $index_j || $indice == $index_j+1){
		return "highlight";
	}
	return "grove";	
}

function index_i(){
	if (isset($_POST["index_i"])){
		return 	$_POST["index_i"];	
	}else {
		return 1;
	}
}

function index_j(&$index_i_value){
	if (isset($_POST["index_j"])){
		if ($_POST["index_j"] < 9 - $_POST["index_i"]){
			return $_POST["index_j"]+1;
		}else {			
			$index_i_value= $index_i_value<9?++$index_i_value:$index_i_value;
			return 0;
		}
	}else{ 
		return 0;
	}
}
?>
<script type="text/javascript">
	function shuffle() {
		 window.location = window.location.href;
	}

	$(document).on('ready',function(){       
    
    $('#play').click(async function(){  
    	
    	while($('#index_i').val() < 10) {        	
        	$.ajax({                        
	           type: "POST",                  
	           data: $("#form_table").serialize(), 
	           success: function(data)             
	           {
	             $('html').html(data);               
	           }
	       });
        	await sleep(1500);
        }
        
    });
	});

	function sleep(ms) {
	  return new Promise(resolve => setTimeout(resolve, ms));
	}


</script>

</body>
</html>
