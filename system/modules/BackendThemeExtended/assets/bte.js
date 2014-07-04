window.addEvent('domready', function(){
  "use strict";


  var
    body      = $(document.body),
    fieldsets = $$('fieldset.tl_tbox, fieldset.tl_box')
  ;

  // Combine .tl_tbox and .tl_box to .bte_fs
  if(fieldsets.length > 0){
    fieldsets.addClass('bte_fs');
  }


  // Datepicker Patch
  $$('.datepicker_dashboard').removeClass('datepicker_dashboard').addClass('datepicker_bootstrap');


  // Open and close the previews header
  if(body.hasClass('bte_smallCe')){
    $$('.bte_smallCe .tl_listing_container.parent_view .tl_header').addEvents({
      click: function(){
        if(!this.hasClass('bte_hover')){
          this.store('closedHeight', this.getStyle('height'));
        }
        this.toggleClass('bte_hover');
        if(this.hasClass('bte_hover')){
          this.setStyle('height', this.retrieve('closedHeight').toInt() + ((this.getElements('tr').length - 1) * 16) + 5);
        }
        else{
          this.setStyle('height', this.retrieve('closedHeight'));
        }
      }
    });
  }


  // Stuff for dynamicaly positioned buttons and adjusting scroll for visible opened fieldsets
  var buttons = $$('.tl_formbody_submit')[0] || false;

  var
    header           = $('header'),
    firstLegend      = $$('fieldset.tl_tbox legend')[0] || false,
    buttonsHeight    = buttons ? buttons.getSize().y : 0,
    main             = $('main'),
    headerHeight     = body.hasClass('bte_fixHeader') ? main.getPosition().y : 0,
    fsClosedHeight   = firstLegend ? Math.max(27, firstLegend.getSize().y) : 0,
    legendPaddingTop = firstLegend ? firstLegend.getStyle('padding-top').toInt() : 0,
    scrollY          = window.getScroll().y,
    scrollTimeout
  ;


  if(buttons && body.hasClass('bte_fixBottom')){
    // Basics
    $('footer').inject(buttons).addClass('bte_fixed');
    main.setStyle('margin-bottom', buttonsHeight).addClass('bte_buttons');

    // Function positionButtons
    var positionButtons = function(){
      if(
          ((main.getSize().y + headerHeight + buttonsHeight) <= window.getScrollSize().y + 1) && // IE patch - normaly has to be: ... === window.getScrollSize().y)
          (window.getSize().y + window.getScroll().y < window.getScrollSize().y)
        ){
        buttons.addClass('bte_fixed');
      }
      else{
        buttons.removeClass('bte_fixed');
      }
    };
    // Position on init
    positionButtons();


    // Add the events for to reposition the fixed-to-bottom buttons on scroll, resize and ajax_change events
    window.addEvents({
      'scroll:throttle(10)': function(){
        // If scroll down
        if(window.getScroll().y > scrollY){
          clearTimeout(scrollTimeout);
          scrollTimeout = setTimeout(positionButtons, 20)
        }
        else if(!buttons.hasClass('bte_fixed')){
          positionButtons();
        }
        scrollY = window.getScroll().y;
      },
      'resize:throttle(100)': positionButtons,
      'ajax_change':  positionButtons
    });
  }


  // Click events on opening fieldsets and checkboxes
  if(fieldsets.length > 0){
    fieldsets.addEvent('click:relay(legend, input.tl_checkbox[onclick], select.tl_select[onchange])', function(){
      var
        fieldset       = this.getParent('.bte_fs'),
        viewportHeight = window.getSize().y,
        scrolledTo     = window.getScroll().y,
        fsCoords       = fieldset.getCoordinates(),
        fsBottomEdge   = fsCoords.bottom - scrolledTo,
        fsTopEdge      = fsCoords.top - scrolledTo,
        buttonsTopEdge = body.hasClass('bte_fixBottom') ? viewportHeight - buttonsHeight : viewportHeight,
        scrollLimit    = fsTopEdge - headerHeight + legendPaddingTop,
        scrollTo       = Math.min((scrolledTo + scrollLimit), (scrolledTo + fsClosedHeight + (fsBottomEdge - buttonsTopEdge))),
        collapsed      = fieldset.hasClass('collapsed'),
        windowScroll   = new Fx.Scroll(window, {
          duration: 250,
          transition: 'sine:in:out'
        })
      ;

      // Highlight fieldset for fun
      if(!collapsed && body.hasClass('bte_style')){
        fieldset.highlight('#FDF5EC');
      }

      // Check if need to scroll
      if((scrollTo > scrolledTo) && !collapsed){
        windowScroll.start(0, scrollTo);
      }

      // Check the positioned buttons
      if(buttons && body.hasClass('bte_fixBottom')){
        positionButtons();
      }
    });
  }


  // Handle fixed to top buttons
  if(buttons && body.hasClass('bte_fixTop')){
    buttons.setStyle('right', body.getSize().x - header.getCoordinates().right);
  }


  // Handle info boxes
  if(body.hasClass('bte_fixHeader') || body.hasClass('bte_style')){
    var
      infoBoxes = $$('.tl_permalert')
    ;
    if(infoBoxes.length > 0){
      var
        // First box
        infoBoxRight = infoBoxes[0].getStyle('left').toInt() + infoBoxes[0].getSize().x,
        infoBoxLeft,
        infoText
      ;

      infoBoxes.each(function(item, index){
        infoText = item.getElement('strong');
        infoText.clone().addClass('bte_infoTop').set('text', '- ' + infoText.get('text').slice(0, 20) + ' -').inject(item, 'top');
        if(index > 0){
          infoBoxLeft = infoBoxRight + 5;
          item.setStyle('left', infoBoxLeft);
          infoBoxRight = infoBoxLeft + item.getSize().x;
        }
      });
    }
  }

/** */
  // Handle lines of ace editor see: https://github.com/contao/core/pull/7063#issuecomment-44864339
  $$('.ace_editor').each(function(editor) {
    editor.env.editor.setOptions({
      maxLines: 30,     // maximal number of displayed lines
      minLines: 3,     // minimal number of displayed lines
      autoScrollEditorIntoView: true  // this is needed if editor is inside of scrollable page
    });
  })
/** */
});
