// Setting weather widget

var endPoint = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22perth%22)%20and%20u%3D'c'&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";

function getThumbnail(status, size) 
{
	var url = "https://ssl.gstatic.com/onebox/weather/";

    switch (status.toLowerCase()) 
    {
        case "hot":
            return url + size + "/hot.png";

        case "sunny":
        case "mostly sunny":
            return url + size + "/sunny.png";

        case "thunderstorms":
        case "severe thunderstorms":
            return url + size + "/thunderstorms.png";

        case "scattered thunderstorms":
          return url + size + "/rain_s_cloudy.png";

        case "partly cloudy":
        case "mostly cloudy":
          return url + size + "/partly_cloudy.png";

        case "cloudy":
          return url + size + "/cloudy.png";

        case "showers":
        case "scattered showers":
          return url + size + "/rain_light.png";

        case "rain":
          return url + size + "/rain.png";

        case "snow":
        case "heavy snow":
        case "snow flurries":
        case "blowing snow":
          return url + size + "/snow.png";

        case "sleet":
          return url + size + "/sleet.png";

        case "windy":
          return url + size + "/windy.png";

        default:
          return url + size + "/cloudy.png";
    }
}

function getDay(day) 
{
    switch (day.toLowerCase()) 
    {
        case "sun":
            return "Sunday";

        case "mon":
            return "Monday";

        case "tue":
            return "Tuesday";

        case "wed":
          	return "Wednesday";

        case "thu":
          	return "Thursday";

        case "fri":
          	return "Friday";

        case "sat":
          return "Saturday";
    }
}


jQuery.get(endPoint, function(data, textStatus, xhr) 
{
  	// $('.sk').after($('<img src="'+data.query.results.channel.image.url+'">'));

  	var location = data.query.results.channel.location;

  	$(".location").text(location.city+" "+location.region+", "+location.country);

  	$(".time").text(getDay(data.query.results.channel.lastBuildDate.substring(0,3)));

  	$(".status").text(data.query.results.channel.item.condition.text);

  	$(".temperature").text(data.query.results.channel.item.condition.temp);

  	$('.thumbnail').attr('src', getThumbnail(data.query.results.channel.item.condition.text, 128));
  	
  	$('#right-information span:eq(0)')
  		.text("Humidity: "+data.query.results.channel.atmosphere.humidity+" %");

  	$('#right-information span:eq(1)')
  		.text("Pressure: "+data.query.results.channel.atmosphere.pressure+" "+data.query.results.channel.units.distance);
  	
  	$('#right-information span:eq(2)')
  		.text("Wind speed: "+data.query.results.channel.wind.speed+" "+data.query.results.channel.units.speed);

  	var upcomingForecast = data.query.results.channel.item.forecast,
  		html = '';

  	jQuery.each(upcomingForecast, function(index, f) 
  	{
	  	html += '' +
	  		'<li>' +
				'<div>' + f.day + '</div>' +
				'<img src="' + getThumbnail(f.text, 64) + '" alt="' + f.text + '" />' +
				'<b>' + f.high + '°</b> ' + f.low + '°' +
			'</li>';
  	});

  	$('.upcoming-forecast').html(html);

  	$('#showForecast').on('click', function(event) 
  	{
  		event.preventDefault();

  		$('#display').slideToggle('slow');

  		$(this).find('i').toggleClass('fa-arrow-circle-down fa-arrow-circle-up');

  	});

});