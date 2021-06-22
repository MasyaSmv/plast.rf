<? if( $showbanners ): ?>



<style>

#skladScreenGlideSmall

{



	position: absolute;

	left: 0px;

	top: 240px;

	width: 40px;

	height: 400px;

	z-index: 1000;

}

#skladScreenGlideBig

{



	position: absolute;

	left: 0px;

	top: 240px;

	width: 600px;

	height: 400px;

	z-index: 1001;

}

</style>



<!--script src="https://code.createjs.com/createjs-2015.11.26.min.js"></script-->

<div id="skladScreenGlideSmall" >


</div>

<div id="skladScreenGlideBig" style="display:none;" >


</div>

<script type="text/javascript">
    $(document).ready(function() {

    	$( "#skladScreenGlideSmall" ).load( "/inc/small.html" );
    	$( "#skladScreenGlideBig" ).load( "/inc/big.html" );

    	//init_big();

    	$( "#skladScreenGlideBig" ).mouseout(function(e) { e.preventDefault();
		  	$( "#skladScreenGlideSmall" ).show();
		  	$( "#skladScreenGlideBig" ).hide();

			console.log('show small');
		});

		$( "#skladScreenGlideSmall" ).mouseover(function(e) { e.preventDefault();
		  	$( "#skladScreenGlideSmall" ).hide();
		  	$( "#skladScreenGlideBig" ).show();
			console.log('show big');
		});



	});

</script>


<? endif; ?>

