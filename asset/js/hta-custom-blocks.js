(function ($) {
    $(document).ready(function() {
        $('#blocks').on('click', '.page-add', function() {
            Omeka.closeSidebar($('.sidebar.active:not(#new-block)'));
            var sidebar = $('#page-list');
            var pageList = $('#page-list .pages');
            var optionTemplate = $('#page-list .option.template');

            $('.selecting-attachment').removeClass('selecting-attachment');
            $(this).addClass('selecting-attachment');
            Omeka.openSidebar(sidebar);
            if (pageList.is(':empty')) {
               var apiUrl = $('.page-attachments-form').data('page-api-url');
               $.get(apiUrl, function(data) {
                   data['o:page'].forEach(function(page) {
                       var newButton = optionTemplate.clone();
                       $.get(page['@id'], function(pageData) {
                           newButton.text(pageData['o:title']).val(pageData['o:slug']);
                       });
                       pageList.append(newButton);
                       newButton.removeClass('template');
                   });
               }).done(function() {
                  // Update attachment options sidebar after selecting item.
                  pageList.on('click', 'button.option', function(e) {
                      var thisSelectResource = $(this);
                      var selectingAttachment = $('.selecting-attachment');
                      Omeka.closeSidebar($('#page-list'));
                      addPageAttachment(selectingAttachment, thisSelectResource);
                  });
              });
            }
        });
        
        $('#blocks').on('click', '.page-options-configure', function(e) {
            e.preventDefault();
            Omeka.closeSidebar($('.sidebar.active:not(#new-block)'));
            var sidebar = $('#page-options');
            var currentPage = $(this).closest('.attachment');
            var mediaInput = currentPage.find('input.media');
            $('.configuring-page').removeClass('configuring-page');
            currentPage.addClass('configuring-page');
            if (mediaInput.val() !== '') {
              $('[name="o:thumbnail[o:id]"]').val(mediaInput.val());
              var currentMedia = currentPage.find('.thumbnail img');
              $('.selected-asset-image').attr('src', currentMedia.attr('src'));
              $('.selected-asset-name').text(currentMedia.attr('alt'));
              $('.selected-asset').show();
            } else {
              $('.selected-asset').hide();
            }
            $('#page-options [name="home_heading"]').val(currentPage.find('input.home-heading').val());
            $('#page-options [name="description"]').val(currentPage.find('input.description').val());
            Omeka.openSidebar(sidebar);
        });
          
        $('#content').on('click', '#page-options-confirm-panel button', function() {
            var pageOptionsSidebar = $('#page-options');
            var currentPage = $('.configuring-page');
            var mediaInput = currentPage.find('input.media');
            var selectedMediaInput = pageOptionsSidebar.find('[name="o:thumbnail[o:id]"]');
            var selectedMediaAssetImage = $('.selected-asset-image');
            var selectedMediaAssetImageUrl = selectedMediaAssetImage.attr('src');
            mediaInput.val(selectedMediaInput.val());
            if (currentPage.find('img').length == 0) {
              currentPage.find('.thumbnail').prepend($('<img>', {src: selectedMediaAssetImageUrl}));
            } else {
              currentPage.find('img').attr('src', selectedMediaAssetImageUrl);
            }
            currentPage.find('input.home-heading').val($('#page-options [name="home_heading"]').val());
            currentPage.find('input.description').val($('#page-options [name="description"]').val());
            Omeka.closeSidebar(pageOptionsSidebar);
            currentPage.removeClass('configuring-page');
        });
        
        $('body').on('o:sidebar-opened', '.sidebar', function () {
          var sidebarId = $(this).attr('id');
          if (sidebarId !== 'page-options' && sidebarId !== 'page-list' && sidebarId !== 'asset-upload-label') {
            Omeka.closeSidebar($('#page-options.active'));
            Omeka.closeSidebar($('#page-list.active'));
          }
        });

        $.get('../../../../../admin/hta/page-sidebar', function(data) {
            var pageSidebar = data;
            $('#new-block').after(pageSidebar);
        });
        
        $.get('../../../../../admin/hta/page-options', function(data) {
          var pageOptionsSidebar = data;
          $('#new-block').after(pageOptionsSidebar);
        });
    });
  
    /**
     * Add a page attachment.
     *
     * Typically used when skipping attachment options.
     *
     * @param object selectingAttachment Add the item to this attachment
     * @param object itemData The data of the item to add
     */
    function addPageAttachment(selectingAttachment, pageButton)
    {
        var attachment = $(selectingAttachment.parents('.attachments').data('template'));

        var title = pageButton.text();
        var sitePageUrl = pageButton.val();

        attachment.find('input.page').val(title);
        attachment.find('.page-title').empty().append(title).prepend($('<div class="thumbnail"></div>'));
        attachment.find('input.url').val(sitePageUrl);
        selectingAttachment.before(attachment);
    }
})(window.jQuery);