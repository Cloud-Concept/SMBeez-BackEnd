jQuery(document).ready(function($){

  // Main Nav & Search
	var resizing = false,
		navigationWrapper = $('.cd-main-nav-wrapper'),
		navigation = navigationWrapper.children('.cd-main-nav'),
		searchForm = $('.cd-main-search'),
		pageContent = $('.cd-main-content'),
		searchTrigger = $('.cd-search-trigger'),
		coverLayer = $('.cd-cover-layer'),
		navigationTrigger = $('.cd-nav-trigger'),
		mainHeader = $('.cd-main-header');

	function checkWindowWidth() {
		var mq = window.getComputedStyle(mainHeader.get(0), '::before').getPropertyValue('content').replace(/"/g, '').replace(/'/g, '');
		return mq;
	}

	function checkResize() {
		if( !resizing ) {
			resizing = true;
			(!window.requestAnimationFrame) ? setTimeout(moveNavigation, 300) : window.requestAnimationFrame(moveNavigation);
		}
	}

	function moveNavigation(){
  		var screenSize = checkWindowWidth();
        if ( screenSize == 'desktop' && (navigationTrigger.siblings('.cd-main-search').length == 0) ) {
        	//desktop screen - insert navigation and search form inside <header>
        	searchForm.detach().insertBefore(navigationTrigger);
			navigationWrapper.detach().insertBefore(searchForm).find('.cd-serch-wrapper').remove();
		} else if( screenSize == 'mobile' && !(mainHeader.children('.cd-main-nav-wrapper').length == 0)) {
			//mobile screen - move navigation and search form after .cd-main-content element
			navigationWrapper.detach().insertAfter('.cd-main-content');
			var newListItem = $('<li class="cd-serch-wrapper"></li>');
			searchForm.detach().appendTo(newListItem);
			newListItem.appendTo(navigation);
		}

		resizing = false;
	}

	function closeSearchForm() {
		searchTrigger.removeClass('search-form-visible');
		searchForm.removeClass('is-visible');
		coverLayer.removeClass('search-form-visible');
	}

	//add the .no-pointerevents class to the <html> if browser doesn't support pointer-events property
	( !Modernizr.testProp('pointerEvents') ) && $('html').addClass('no-pointerevents');

	//move navigation and search form elements according to window width
	moveNavigation();
	$(window).on('resize', checkResize);

	//mobile version - open/close navigation
	navigationTrigger.on('click', function(event){
		event.preventDefault();
		mainHeader.add(navigation).add(pageContent).toggleClass('nav-is-visible');
	});

	searchTrigger.on('click', function(event){
		event.preventDefault();
		if( searchTrigger.hasClass('search-form-visible') ) {
			searchForm.find('form').submit();
		} else {
			searchTrigger.addClass('search-form-visible');
			coverLayer.addClass('search-form-visible');
			searchForm.addClass('is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				searchForm.find('input[type="search"]').focus().end().off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
			});
		}
	});

	//close search form
	searchForm.on('click', '.close', function(){
		closeSearchForm();
	});

	coverLayer.on('click', function(){
		closeSearchForm();
	});

	$(document).keyup(function(event){
		if( event.which=='27' ) closeSearchForm();
	});

	//upadate span.selected-value text when user selects a new option
	searchForm.on('change', 'select', function(){
		searchForm.find('.selected-value').text($(this).children('option:selected').text());
	});


  // Star Rating
  $('.star-rating-fn').barrating({
    theme: 'fontawesome-stars'
  });

  // Star Rating ReadOnly
  $('.star-rating-ro').barrating({
    readonly: true,
    hoverState: false,
    theme: 'fontawesome-stars'
  });







  // input files

    $('.custom-file-input').on('change',function(){
      $(this).next().after().text($(this).val().split('\\').slice(-1)[0])
    })


    // Select Tabs fn

    $('.radio-link.active').find('.custom-control-input').prop('checked', true);
    $('.radio-link').click(function(){
      $(this).find('.custom-control-input').prop('checked', true);
    });


  // Select Yes or No case

    //level 1
    $('#first-level > .case-01  > .radio-yes-case').click(function(){
      $('#second-level > .no-case-info').hide();
      $('#third-level > .no-case-info , #third-level > .yes-case-info').hide();
      $('#four-level > .no-case-info , #four-level > .yes-case-info').hide();
      $('#five-level > .no-case-info , #five-level > .yes-case-info').hide();
      $('#second-level > .yes-case-info').show();
    });
    $('#first-level > .case-01 > .radio-no-case').click(function(){
      $('#second-level > .no-case-info').show();
      $('#second-level > .yes-case-info').hide();
      $('#third-level > .no-case-info , #third-level > .yes-case-info').hide();
      $('#four-level > .no-case-info , #four-level > .yes-case-info').hide();
      $('#five-level > .no-case-info , #five-level > .yes-case-info').hide();

    });


    //level 2
    $('#second-level  .case-02  > .radio-yes-case').click(function(){
      $('#third-level > .no-case-info').hide();
      $('#third-level > .yes-case-info').show();
      $('#four-level > .no-case-info , #four-level > .yes-case-info').hide();
      $('#five-level > .no-case-info , #five-level > .yes-case-info').hide();

    });
    $('#second-level  .case-02 > .radio-no-case').click(function(){
      $('#third-level > .no-case-info').show();
      $('#third-level > .yes-case-info').hide();
      $('#four-level > .no-case-info , #four-level > .yes-case-info').hide();
      $('#five-level > .no-case-info , #five-level > .yes-case-info').hide();

    });

    //level 3
    $('#third-level  .case-03  > .radio-yes-case').click(function(){
      $('#four-level > .no-case-info').hide();
      $('#four-level > .yes-case-info').show();
      $('#five-level > .no-case-info , #five-level > .yes-case-info').hide();

    });
    $("#third-level  .case-03 > select").change(function () {
      if($(this).val() == 'other') {
          $("#four-level > .no-case-info").show(), $("#four-level > .yes-case-info").hide(), $("#five-level > .no-case-info , #five-level > .yes-case-info").hide()
      }else {
        $("#four-level > .no-case-info").hide()
      }
    });

    //level 4
    $('#four-level  .case-04  > .radio-yes-case').click(function(){
      $('#five-level > .no-case-info').hide();
      $('#five-level > .yes-case-info').show();
    });
    $('#four-level  .case-04 > .radio-no-case').click(function(){
      $('#five-level > .no-case-info').show();
      $('#five-level > .yes-case-info').hide();
    });

  // Scroll Animation
    if ($('body').hasClass('home')) {
    window.sr = ScrollReveal({ reset: true });
      sr.reveal('.home .hero h1', {
        opacity: 0,
        distance: '10rem',
        duration: 2000,
        scale: 1,
        origin: 'top'
      });
      sr.reveal('.home .hero p', {
        opacity: 0,
        duration: 2000,
        origin: 'top'
      });

      sr.reveal('.home .btn-hero', {
        opacity: 0,
        distance: '10rem',
        duration: 2000,
        scale: 1,
        origin: 'bottom'
      });

      sr.reveal('.home .featured-companies h3, .home .featured-projects h3', {
        opacity: 0,
        distance: '10rem',
        duration: 1000,
        scale: 1,
        origin: 'bottom'
      });
      sr.reveal('.home .sidebar-01, .home .sidebar-02, .home .footer', {
        opacity: 0,
        distance: '10rem',
        duration: 2000,
        scale: 1,
        origin: 'bottom'
      });
      sr.reveal('.home .company-box, .home .project-box, .home .create-intro', {
        opacity: 0,
        distance: '10rem',
        duration: 1500,
        scale: 1,
        origin: 'bottom'
      });
  }
});