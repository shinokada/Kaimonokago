/* Javascript code to allow the user to generate a password 
 * at random on the members page in the administration area
 */
$(document).ready(function(){  

	// Create objects
	var winObj = $('#generatePasswordWindow');
	var newPassObj = $('#gpPassword');	// Object to show newly generated password	
	
	// Password generation option objects
	var uppercaseFlag = $(':checkbox[name=uppercase]');
	var numericFlag = $(':checkbox[name=numeric]');
	var symbolFlag = $(':checkbox[name=symbols]');
	var inputLengthObj  = $(':input[name=length]');	// Object which stores password length

	// Possible Characters
	var lowercaseChars = "abcdefghijklmnopqrtsuvwxyz";
	var symbolChars    = "!£$%&_+-=@~#<>?";

    // When the user clicks on the 'Generate Password' toggle window
    $('#generate_password').click(function(){
		winObj.show();
		generate();
	});
	
	// Close window when user clicks close
	$('#gpCloseWindow').click(function(){winObj.hide();});
	
	// Copy passwords to main form and close window
	$('#gpApply').click(function(){
		$('input[name=password]').val(newPassObj.text());
		$('input[name=confirm_password]').val(newPassObj.text());
		winObj.hide();
	});
	
	// Generate new password
	$('#gpGenerateNew').click(function(){generate();});
	
	// When the user edits the length make sure it is a number and between 1 and 12
	inputLengthObj.keyup(function(){
		if((this.value <=0 || this.value > 16) && this.value != ''){
			alert("Invalid password length");
			this.value = '12';
		}
	});
	
	// Generate a new password
	function generate()
	{
		var string = '';
		// Loop over length of requested password
		for(i=0;i<inputLengthObj.val();i++)
		{
			// Randomly select either alpha/numeric/symbol
			switch(randNum(3))
			{
				case 1:
					// Numeric
					if(numericFlag.is(':checked'))
						string += randNum(9);
					else
						i--;
					break;
				case 2:
					// Alpha
					switch(randNum(2))
					{
						case 1:
							// Uppercase
							if(uppercaseFlag.is(':checked'))
								string += lowercaseChars.charAt(randNum(lowercaseChars.length)-1).toUpperCase();
							else
								i--;
							break;
						case 2:
							// Lowercase
							string += lowercaseChars.charAt(randNum(lowercaseChars.length)-1);
							break;
					}
					break;
				case 3:
					// Symbol
					if(symbolFlag.is(':checked'))
						string += symbolChars.charAt(randNum(symbolChars.length)-1);
					else
						i--;
					break;
			}
		}	
		newPassObj.text(string);	
	}
	
	// Generate a random number between 0 and max
	function randNum(max){return Math.floor(Math.random()*max+1);}
});