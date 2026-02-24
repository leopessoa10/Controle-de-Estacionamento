(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active'); // Alterna a classe "active" na sidebar
      $('#content').toggleClass('sidebar-collapsed'); // Ajusta o conteúdo principal
      $('#navbar').toggleClass('sidebar-collapsed'); // Ajusta a navbar
  });

})(jQuery);
