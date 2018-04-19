// Setting Daily Balances Pregress graph

$(function () {
    
    $.ajax({

        url: './daily_balances/get_progress',

    }).done(function(data) {
        
        var line = new Morris.Line({
            
            element: 'line-chart',
            
            resize: true,
            
            data: data,
            
            xkey: 'y',
            
            ykeys: ['item1'],
            
            labels: ['Balance'],
            
            lineColors: ['#3c8dbc'],
            
            hideHover: 'auto',
            
            parseTime: false,
            
            preUnits: "$",
            
            hoverCallback: function (index, options, content, row) 
            {
            
                if( row.item1 < 0 ){

                	return content.replace("$-", "-$");

                }

                return content;

            }

        });

    }).fail(function() {
        console.log("error fetching daily balance progress data");
    });
});