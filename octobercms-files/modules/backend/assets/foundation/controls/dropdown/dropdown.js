/*
 * Dropdown menus.
 *
 * This script customizes the Twitter Bootstrap drop-downs.
 *
 * Require:
 *  - bootstrap/dropdown
 */
+function ($) { "use strict";

    $(document).on('shown.bs.dropdown', '.dropdown', function(ev) {
        $(document.body).addClass('dropdown-open');

        var dropdown = $(ev.relatedTarget).siblings('.dropdown-menu'),
            dropdownContainer = $(this).data('dropdown-container');

        // The dropdown menu should be a sibling of the triggering element (above)
        // otherwise, look for any dropdown menu within this context.
        if (dropdown.length === 0) {
            dropdown = $('.dropdown-menu', this);
        }

        if (!dropdown.hasClass('control-dropdown')) {
            $('li > a', dropdown).addClass('dropdown-item');
            $('li:first-child', dropdown).addClass('first-item');
            $('li:last-child', dropdown).addClass('last-item');

            dropdown.addClass('control-dropdown');
        }

        if (dropdownContainer !== undefined && dropdownContainer == 'body') {
            $(this).data('oc.dropdown', dropdown);
            $(document.body).append(dropdown);

            dropdown.css({
                'visibility': 'hidden',
                'left': 0,
                'top' : 0,
                'display': 'block'
            });

            var targetOffset = $(this).offset(),
                targetHeight = $(this).height(),
                targetWidth = $(this).width(),
                position = {
                    x: targetOffset.left,
                    y: targetOffset.top + targetHeight
                },
                leftOffset = targetWidth < 30 ? -16 : 0,
                documentHeight = $(document).height(),
                dropdownHeight = dropdown.height();

            if ((dropdownHeight + position.y) > $(document).height()) {
                position.y = targetOffset.top - dropdownHeight - 12;
                dropdown.addClass('top');
            }
            else {
                dropdown.removeClass('top');
            }

            dropdown.css({
                'left': position.x + leftOffset,
                'top': position.y,
                'visibility': 'visible'
            });
        }

        if ($('.dropdown-overlay', document.body).length == 0) {
            $(document.body).prepend($('<div/>').addClass('dropdown-overlay'));
        }
    })

    $(document).on('hidden.bs.dropdown', '.dropdown', function() {
        var dropdown = $(this).data('oc.dropdown');
        if (dropdown !== undefined) {
            dropdown.css('display', 'none');
            $(this).append(dropdown);
        }

        $(document.body).removeClass('dropdown-open');
    })

    /*
     * Fixed positioned dropdowns
     * - Useful for dropdowns inside hidden overflow containers
     */

    var $dropdown, $container, $target;

    function fixDropdownPosition() {
        var position = $container.offset();

        $dropdown.css({
            position: 'fixed',
            top: position.top - 1 - $(window).scrollTop() + $target.outerHeight(),
            left: position.left
        });
    }

    $(document).on('shown.bs.dropdown', '.dropdown.dropdown-fixed', function(ev) {
        $container = $(this);
        $dropdown = $('.dropdown-menu', $container);
        $target = $(ev.relatedTarget);
        fixDropdownPosition();

        $dropdown.addClass('is-fixed');
        $(window).on('scroll.oc.dropdown, resize.oc.dropdown', fixDropdownPosition);
    })

    $(document).on('hidden.bs.dropdown', '.dropdown.dropdown-fixed', function() {
        $(window).off('scroll.oc.dropdown, resize.oc.dropdown', fixDropdownPosition);
    });

}(window.jQuery);