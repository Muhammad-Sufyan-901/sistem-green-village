/**
 * Main
 */

'use strict';

let menu, animate;

function upload_transport_price_list()
{
  $('form[id="uploadForm"]').each(function(){
    $(this).validate({
      ignore: ".ignore",
      rules: {
        photo: 'required'
      },
      errorPlacement: function(error, element) {
        var elementName = element.attr("base_error");
        error.appendTo("#"+elementName);
      },
      submitHandler: function(form) {
        $.ajax({
          url: form.action,
          type: form.method,
          data: new FormData(form),
          contentType: false,
          processData: false,
          beforeSend: function() {
            $('#uploadForm .btn-submit').html('Please wait...');
            $('#uploadForm .btn-submit').prop('disabled', true);
          },
          success: function(data) {
            if(data.status == 'success'){
              $('.upload-alert-message-box').html('<div class="alert alert-success">'+data.message+'</div>');
              $('.tpl-img-preview').attr("src", data.path_image);
              $('#uploadForm .btn-submit').html('Submit');
              $('#uploadForm .btn-submit').prop('disabled', false);
            }else{
              $('#uploadForm .btn-submit').html('Submit');
              $('#uploadForm .btn-submit').prop('disabled', false);
              $('.upload-alert-message-box').html('<div class="alert alert-danger">'+data.message+'</div>');
              $("html, body").animate({ scrollTop: 0 }, "slow");
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $('#uploadForm .btn-submit').html('Submit');
            $('#uploadForm .btn-submit').prop('disabled', false);
            $('.upload-alert-message-box').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
            $("html, body").animate({ scrollTop: 0 }, "slow");
          }
        });
        return false;                  
      },
    });
  });
}

function submitForm(target)
{
    let form = $('#'+target);
    var result = confirm("Are you sure want to delete this data?");
    if (result) {
        form.submit();
    }
    return false;
}
function submitFormNormal(target)
{
    let form = $('#'+target);
    form.submit();
}

function submitLogoutForm(target)
{
    let form = $('#'+target);
    form.submit();
}

(function () {
  // Initialize menu
  //-----------------
  $('.kdef-rate-format').on('keyup', function(){
    $(this).val(formatRupiah($(this).val()));
  });
	
	function formatRupiah(angka)
	{
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
      separator = '',
			split	= number_string.split(','),
			sisa 	= split[0].length % 3,
			rupiah 	= split[0].substr(0, sisa),
			ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return rupiah;
	}

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();
