function food_details( sensor ) {
	var details = document.food_data[sensor];
	$('#food-name').html( details.name );
	$('#food-weight').html( details.weight + 'g' );
	$('#food-age').html( details.age );
	$('#food-icon').attr('src', 'img/food/' + details.icon + '.png' );
}

function addItem( spot, data ) {
	// TODO change this to have the correct info about the apple
	var food_item = '';
	if( !data.unknown ) {
		food_item = "<a class='food-details' style='display:none;' onclick='food_details(" + data.sensor + ");' href='#details'>" +
						"<div class='food' style='background:url(\"img/food/" + data.icon + ".png\");'></div>" +
					"</a>";
	} else {
		food_item = "<div class='food food-details' style='display:none;background:url(\"img/unknown-white.png\");'>" +
						"<select class='unknown' onchange='changeType(this," + data.sensor + ");'>" +
							"<option value='unknown'>Unknown</option>" +
							"<optgroup label='Dairy'>" +
								"<option value='milk'>Milk</option>" +
							"</optgroup>" +
							"<optgroup label='Fruits'>" +
								"<option value='apple'>Apple</option>" +
							"</optgroup>" +
							"<optgroup label='Meat'>" +
								"<option value='beef'>Beef</option>" +
							"</optgroup>" +							
							"<optgroup label='Veggies'>" +
								"<option value='pepper'>Pepper</option>" +
							"</optgroup>" +
							"<optgroup label='Misc'>" +
								"<option value='wine'>Alcohol</option>" +
								"<option value='muffin'>Sweets</option>" +
								"<option value='pizza'>Pizza</option>" +
							"</optgroup>" +
						"</select>" +
					"</div>";
	}
	
	$( '#' + spot ).append( food_item );
	$('.food-details').fadeIn('slow');
}
