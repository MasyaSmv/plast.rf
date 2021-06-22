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


 
<script src="https://code.createjs.com/createjs-2015.11.26.min.js"></script>
<div id="skladScreenGlideSmall" >
					
				
</div>

<script type="text/javascript">
    $(document).ready(function() {

    	$( "#skladScreenGlideSmall" ).load( "//ruscable.su/www/delivery/afr.php?zoneid=161&amp;cb=23567272472457" );

    	//init_big();

    	$( "#skladScreenGlideSmall" ).mouseout(function(e) { e.preventDefault();
		  $( "#skladScreenGlideSmall" ).load( "//ruscable.su/www/delivery/afr.php?zoneid=161&amp;cb=23567272472457" );
			console.log('show small');
		});

		
		
		
		
	});

</script>


<? endif; ?>

