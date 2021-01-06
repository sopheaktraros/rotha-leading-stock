"use strict";
// Basic confirm box
$('[data-confirm]').each(function () {
    var me = $(this),
        me_data = me.data('confirm');

    me_data = me_data.split("|");
    me.fireModal({
        title: me_data[0],
        body: me_data[1],
        buttons: [
            {
                text: me.data('confirm-text-yes') || 'Yes',
                class: 'btn btn-danger btn-shadow',
                handler: function () {
                    eval(me.data('confirm-yes'));
                }
            },
            {
                text: me.data('confirm-text-cancel') || 'Cancel',
                class: 'btn btn-secondary',
                handler: function (modal) {
                    $.destroyModal(modal);
                    eval(me.data('confirm-no'));
                }
            }
        ]
    })
});

// Global
$(function () {
    let sidebar_nicescroll_opts = {
        cursoropacitymin: 0,
        cursoropacitymax: .8,
        zindex: 892
    }, now_layout_class = null;


    var sidebar_nicescroll;
    var update_sidebar_nicescroll = function () {
        let a = setInterval(function () {
            if (sidebar_nicescroll != null)
                sidebar_nicescroll.resize();
        }, 10);

        setTimeout(function () {
            clearInterval(a);
        }, 600);
    }

    var sidebar_dropdown = function () {
        if ($(".main-sidebar").length) {
            $(".main-sidebar").niceScroll(sidebar_nicescroll_opts);
            sidebar_nicescroll = $(".main-sidebar").getNiceScroll();

            $(".main-sidebar .sidebar-menu li a.has-dropdown").off('click').on('click', function () {
                var me = $(this);
                var active = false;
                if (me.parent().hasClass("active")) {
                    active = true;
                }

                $('.main-sidebar .sidebar-menu li.active > .dropdown-menu').slideUp(500, function () {
                    update_sidebar_nicescroll();
                    return false;
                });

                $('.main-sidebar .sidebar-menu li.active').removeClass('active');

                if (active == true) {
                    me.parent().removeClass('active');
                    me.parent().find('> .dropdown-menu').slideUp(500, function () {
                        update_sidebar_nicescroll();
                        return false;
                    });
                } else {
                    me.parent().addClass('active');
                    me.parent().find('> .dropdown-menu').slideDown(500, function () {
                        update_sidebar_nicescroll();
                        return false;
                    });
                }

                return false;
            });

            $('.main-sidebar .sidebar-menu li.active > .dropdown-menu').slideDown(500, function () {
                update_sidebar_nicescroll();
                return false;
            });
        }
    }
    sidebar_dropdown();

    if ($("#top-5-scroll").length) {
        $("#top-5-scroll").css({
            height: 315
        }).niceScroll();
    }

    $(".main-content").css({
        minHeight: $(window).outerHeight() - 108
    })

    $(".nav-collapse-toggle").click(function () {
        $(this).parent().find('.navbar-nav').toggleClass('show');
        return false;
    });

    $(document).on('click', function (e) {
        $(".nav-collapse .navbar-nav").removeClass('show');
    });

    var toggle_sidebar_mini = function (mini) {
        let body = $('body');

        if (!mini) {
            body.removeClass('sidebar-mini');
            $(".main-sidebar").css({
                overflow: 'hidden'
            });
            setTimeout(function () {
                $(".main-sidebar").niceScroll(sidebar_nicescroll_opts);
                sidebar_nicescroll = $(".main-sidebar").getNiceScroll();
            }, 500);
            $(".main-sidebar .sidebar-menu > li > ul .dropdown-title").remove();
            $(".main-sidebar .sidebar-menu > li > a").removeAttr('data-toggle');
            $(".main-sidebar .sidebar-menu > li > a").removeAttr('data-original-title');
            $(".main-sidebar .sidebar-menu > li > a").removeAttr('title');
        } else {
            body.addClass('sidebar-mini');
            body.removeClass('sidebar-show');
            sidebar_nicescroll.remove();
            sidebar_nicescroll = null;
            $(".main-sidebar .sidebar-menu > li").each(function () {
                let me = $(this);

                if (me.find('> .dropdown-menu').length) {
                    me.find('> .dropdown-menu').hide();
                    me.find('> .dropdown-menu').prepend('<li class="dropdown-title pt-3">' + me.find('> a').text() + '</li>');
                } else {
                    me.find('> a').attr('data-toggle', 'tooltip');
                    me.find('> a').attr('data-original-title', me.find('> a').text());
                    $("[data-toggle='tooltip']").tooltip({
                        placement: 'right'
                    });
                }
            });
        }
    }

    $("[data-toggle='sidebar']").click(function () {
        var body = $("body"),
            w = $(window);

        if (w.outerWidth() <= 1024) {
            body.removeClass('search-show search-gone');
            if (body.hasClass('sidebar-gone')) {
                body.removeClass('sidebar-gone');
                body.addClass('sidebar-show');
            } else {
                body.addClass('sidebar-gone');
                body.removeClass('sidebar-show');
            }

            update_sidebar_nicescroll();
        } else {
            body.removeClass('search-show search-gone');
            if (body.hasClass('sidebar-mini')) {
                toggle_sidebar_mini(false);
            } else {
                toggle_sidebar_mini(true);
            }
        }

        return false;
    });

    var toggleLayout = function () {
        var w = $(window),
            layout_class = $('body').attr('class') || '',
            layout_classes = (layout_class.trim().length > 0 ? layout_class.split(' ') : '');

        if (layout_classes.length > 0) {
            layout_classes.forEach(function (item) {
                if (item.indexOf('layout-') != -1) {
                    now_layout_class = item;
                }
            });
        }

        if (w.outerWidth() <= 1024) {
            if ($('body').hasClass('sidebar-mini')) {
                toggle_sidebar_mini(false);
                $('.main-sidebar').niceScroll(sidebar_nicescroll_opts);
                sidebar_nicescroll = $(".main-sidebar").getNiceScroll();
            }

            $("body").addClass("sidebar-gone");
            $("body").removeClass("layout-2 layout-3 sidebar-mini sidebar-show");
            $("body").off('click touchend').on('click touchend', function (e) {
                if ($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
                    $("body").removeClass("sidebar-show");
                    $("body").addClass("sidebar-gone");
                    $("body").removeClass("search-show");

                    update_sidebar_nicescroll();
                }
            });

            update_sidebar_nicescroll();

            if (now_layout_class == 'layout-3') {
                let nav_second_classes = $(".navbar-secondary").attr('class'),
                    nav_second = $(".navbar-secondary");

                nav_second.attr('data-nav-classes', nav_second_classes);
                nav_second.removeAttr('class');
                nav_second.addClass('main-sidebar');

                let main_sidebar = $(".main-sidebar");
                main_sidebar.find('.container').addClass('sidebar-wrapper').removeClass('container');
                main_sidebar.find('.navbar-nav').addClass('sidebar-menu').removeClass('navbar-nav');
                main_sidebar.find('.sidebar-menu .nav-item.dropdown.show a').click();
                main_sidebar.find('.sidebar-brand').remove();
                main_sidebar.find('.sidebar-menu').before($('<div>', {
                    class: 'sidebar-brand'
                }).append(
                    $('<a>', {
                        href: $('.navbar-brand').attr('href'),
                    }).html($('.navbar-brand').html())
                ));
                setTimeout(function () {
                    sidebar_nicescroll = main_sidebar.niceScroll(sidebar_nicescroll_opts);
                    sidebar_nicescroll = main_sidebar.getNiceScroll();
                }, 700);

                sidebar_dropdown();
                $(".main-wrapper").removeClass("container");
            }
        } else {
            $("body").removeClass("sidebar-gone sidebar-show");
            if (now_layout_class)
                $("body").addClass(now_layout_class);

            let nav_second_classes = $(".main-sidebar").attr('data-nav-classes'),
                nav_second = $(".main-sidebar");

            if (now_layout_class == 'layout-3' && nav_second.hasClass('main-sidebar')) {
                nav_second.find(".sidebar-menu li a.has-dropdown").off('click');
                nav_second.find('.sidebar-brand').remove();
                nav_second.removeAttr('class');
                nav_second.addClass(nav_second_classes);

                let main_sidebar = $(".navbar-secondary");
                main_sidebar.find('.sidebar-wrapper').addClass('container').removeClass('sidebar-wrapper');
                main_sidebar.find('.sidebar-menu').addClass('navbar-nav').removeClass('sidebar-menu');
                main_sidebar.find('.dropdown-menu').hide();
                main_sidebar.removeAttr('style');
                main_sidebar.removeAttr('tabindex');
                main_sidebar.removeAttr('data-nav-classes');
                $(".main-wrapper").addClass("container");
            } else if (now_layout_class == 'layout-2') {
                $("body").addClass("layout-2");
            } else {
                update_sidebar_nicescroll();
            }
        }
    }
    toggleLayout();
    $(window).resize(toggleLayout);

    // tooltip
    $("[data-toggle='tooltip']").tooltip();

    // popover
    $('[data-toggle="popover"]').popover({
        container: 'body'
    });

    // Select2
    if (jQuery().select2) {
        $(".select2").select2();
    }

    $(".notification-toggle").dropdown();
    $(".notification-toggle").parent().on('shown.bs.dropdown', function () {
        $(".dropdown-list-icons").niceScroll({
            cursoropacitymin: .3,
            cursoropacitymax: .8,
            cursorwidth: 7
        });
    });

    // Collapsable
    $("[data-collapse]").each(function () {
        var me = $(this),
            target = me.data('collapse');

        me.click(function () {
            $(target).collapse('toggle');
            $(target).on('shown.bs.collapse', function (e) {
                e.stopPropagation();
                me.html('<i class="fas fa-minus"></i>');
            });
            $(target).on('hidden.bs.collapse', function (e) {
                e.stopPropagation();
                me.html('<i class="fas fa-plus"></i>');
            });
            return false;
        });
    });


    // Background
    $("[data-background]").each(function () {
        var me = $(this);
        me.css({
            backgroundImage: 'url(' + me.data('background') + ')'
        });
    });

    // Custom Tab
    $("[data-tab]").each(function () {
        var me = $(this);

        me.click(function () {
            if (!me.hasClass('active')) {
                var tab_group = $('[data-tab-group="' + me.data('tab') + '"]'),
                    tab_group_active = $('[data-tab-group="' + me.data('tab') + '"].active'),
                    target = $(me.attr('href')),
                    links = $('[data-tab="' + me.data('tab') + '"]');

                links.removeClass('active');
                me.addClass('active');
                target.addClass('active');
                tab_group_active.removeClass('active');
            }
            return false;
        });
    });

    // Bootstrap 4 Validation
    $(".need-validation").validate({
        errorClass: "is-invalid",
        errorPlacement: function (label, element) {
            $("button[type='submit']").removeClass('btn-progress');
            $(element).next('span').find('.select2-selection').css({
                'border': '1px solid #ff5252',
                'border-radius': '.25rem'
            });
        }
    });


    // Dismiss modal
    $("[data-dismiss=modal]").click(function () {
        $(this).closest('.modal').modal('hide');

        return false;
    });

    // Daterangepicker
    if (jQuery().daterangepicker) {
        if ($(".datepicker").length) {
            $('.datepicker').daterangepicker({
                locale: {format: 'MM/DD/YYYY'},
                singleDatePicker: true,
                autoUpdateInput: true,
                autoApply: true
            });
            $('.datepicker').val("");
        }
        if ($(".datetimepicker").length) {
            $('.datetimepicker').daterangepicker({
                locale: {format: 'YYYY-MM-DD hh:mm'},
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
            });
        }
        if ($(".daterange").length) {
            $('.daterange').daterangepicker({
                locale: {format: 'YYYY-MM-DD'},
                drops: 'down',
                opens: 'right'
            });
        }
    }

    $.formToObject = function (form) {
        const formData = form.serializeArray();
        let jsonObject = {};

        for (var i = 0; i < formData.length; i++) {
            jsonObject[formData[i].name] = formData[i].value;
        }

        return jsonObject;
    }

    $("button[type='submit']").click(function () {
        $(this).addClass('btn-progress');
    });

    $('.number').keypress(function (event) {
        return isNumber(event, this)
    });

    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function toggleQuickSidebar(target) {
        let overlay = $('#quick-sidebar-overlay');
        if (overlay.length == 0) {
            $('body').append('<div id="quick-sidebar-overlay"></div>');
        } else {
            overlay.remove();
        }
        target.toggleClass('open');
    }

    $(document).on('click', 'a[data-toggle="quick-sidebar"]', function () {
        let target = $($(this).data('target'));
        toggleQuickSidebar(target);
    });

    $(document).on('click', 'a[data-toggle="close-quick-sidebar"]', function () {
        let target = $(this).closest('.quick-sidebar');
        toggleQuickSidebar(target);
    });

    $(document).on('click', '#quick-sidebar-overlay', function () {
        toggleQuickSidebar($('.quick-sidebar'));
    });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        let _this = $(this);
        $.confirm({
            title: 'Are you sure ?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-red',
                    action: function () {
                        _this.closest('form').submit();
                    }
                },
                close: function () {
                }
            }
        });
    });

    function readURL(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                _this.closest('.form-group').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on("change", ".preview-image", function () {
        var target = event.target || event.srcElement;
        if (target.value.length == 0) {
            $(this).closest('.form-group').find('img').attr('src', '{{ url("images/default-image.jpg") }}');
        } else {
            readURL(this, $(this));
        }
    });

    function readerUpload(input, _this) {
        $('.reader-img').remove();
        $.each(input.files, function (key, val) {
            if (input.files && input.files[key]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    _this.closest('#show-images').prepend(`<div class="col-md-3 reader-img">
                                                        <div class="form-group">
                                                            <div class="box-image" style="height: 230px;">
                                                                <img class="preview-img w-100"
                                                                     src="${e.target.result}"
                                                                     alt="Image">
                                                            </div>
                                                        </div>
                                                    </div>`);
                }
                reader.readAsDataURL(input.files[key]);


            }
        });
    }

    $(document).on('change', '.multiple-upload', function () {
        readerUpload(this, $(this));
    });

});

