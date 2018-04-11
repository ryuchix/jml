$(function(){


	var imagePreviewer = {

		$hoverElement : $('.image-preview'),

		containerId:'#imagePreviewer',

		template: '',

		init: function()
		{
			this.$hoverElement.on('mouseover', this.createElementOnBody);
			this.$hoverElement.on('mouseleave', this.removeElementFromBody);
			this.$hoverElement.on('mousemove', this.repositionElementInBody);
		},

		createElementOnBody: function(e)
		{
			var imageUrl = $(this).data('url');

			if ( imagePreviewer.template ) 
			{
				imagePreviewer.template.find('img')
					.attr('src', imageUrl);

				imagePreviewer.template.fadeIn();
				return;
			}

			var template = '<div id="' + imagePreviewer.containerId + '" class="image-preview">' +
								'<img src="'+ imageUrl +'" class="img-responsive">' +
							'</div>';

			imagePreviewer.template = $(template).css({
				'display': 'none',
			    'position': 'fixed',
			    'max-width': '350px',
			    'background': 'white',
			    'top': e.clientY + 'px',
			    'left': e.clientX + 'px',
			    'border-radius': '5px',
			    'border': '3px solid #333',
			    'padding': '5px',
			    'z-index': 100
			});

			$('body').append( imagePreviewer.template.fadeIn(100) );
		},

		removeElementFromBody: function(e)
		{
			imagePreviewer.template.fadeOut(100);
		},

		repositionElementInBody: function(e)
		{
			var imageHeight = imagePreviewer.template.outerHeight(),
				windowHeight = $(window).height(),
				top = e.clientY;

			if ( (windowHeight - e.clientY) < imageHeight ) 
			{
				top = windowHeight - imageHeight - 20;
			}

			imagePreviewer.template.css({
				top: top + 'px',
				left: (e.clientX + 40) + 'px'
			});
		}

	};

	imagePreviewer.init();

});