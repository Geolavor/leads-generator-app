$(function() {
    $(document).click(function(e) {
        var target = e.target;

        if (! $(target).parents('.collapse-open').length || $(target).is('li') || $(target).is('a')) {
            $('.navbar-collapse').hide();
            $('.navbar-toggler').removeClass('show');
        }
    });

    $('body').delegate('.navbar-toggler', 'click', function(e) {
        toggleCollapse(e);
    });

    function toggleCollapse(e) {
        var currentElement = $(e.currentTarget);

        $('.navbar-collapse').hide();

        if (currentElement.hasClass('show')) {
            currentElement.removeClass('show');
        } else {
            currentElement.addClass('show');
            currentElement.parent().find('.navbar-collapse').fadeIn(100);
            currentElement.parent().addClass('collapse-open');
            autoDropupCollapse();
        }
    }

    $('.navbar-collapse .search-box .control').on('input', function() {
        var currentElement = $(this);

        currentElement.parents(".navbar-collapse").find('li').each(function() {
            var text = $(this).text().trim().toLowerCase();
            var value = $(this).attr('data-id');

            if (value) {
                var isTextContained = text.search(currentElement.val().toLowerCase());
                var isValueContained = value.search(currentElement.val());
                
                if (isTextContained < 0 && isValueContained < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                    flag = 1;
                }
            } else {
                var isTextContained = text.search(currentElement.val().toLowerCase());

                if(isTextContained < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }
        });
    });

    function autoDropupCollapse() {
        collapse = $(".collapse-open");

        if (! collapse.find('.navbar-collapse').hasClass('top-left') && ! collapse.find('.navbar-collapse').hasClass('top-right') && collapse.length) {
            collapse = collapse.find('.navbar-collapse');
            height = collapse.height() + 50;
            var topOffset = collapse.offset().top - 70;
            var bottomOffset = $(window).height() - topOffset - collapse.height();

            if (bottomOffset > topOffset || height < bottomOffset) {
                collapse.removeClass("bottom");
                
                if(collapse.hasClass('top-right')) {
                    collapse.removeClass('top-right')
                    collapse.addClass('bottom-right')
                } else if(collapse.hasClass('top-left')) {
                    collapse.removeClass('top-left')
                    collapse.addClass('bottom-left')
                }
            } else {
                if(collapse.hasClass('bottom-right')) {
                    collapse.removeClass('bottom-right')
                    collapse.addClass('top-right')
                } else if(collapse.hasClass('bottom-left')) {
                    collapse.removeClass('bottom-left')
                    collapse.addClass('top-left')
                }
            }
        }
    }

    $('div').scroll(function() {
        autoDropupCollapse()
    });
});