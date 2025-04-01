"use strict";
$(document).ready(function() {
    $('select').select2({
        width: '100%'
    });


    $('#assign-driver-select').select2({
        dropdownParent: $("#modal-asign-driver"),
    });

    $('#time_to_prepare_select').select2({
        dropdownParent: $("#modal-time-to-prepare"),
    });

    $('#addressID').select2({});


    $('.select2').addClass('form-control');
    $('.select2-selection').css('border', '0');
    $('.select2-selection__arrow').css('height', '100%');


    $("select").has(".noselecttwo").each(function($pos) {
        var $this = $(this);

        $settings = {};
        $this.addClass("select2init");

        var $ajax = $this.attr("data-feed");
        if (typeof $ajax !== typeof undefined && $ajax !== false) {
            $settings.ajax = { url: $ajax, dataType: 'json' }
        }

        if (typeof($this.attr("placeholder")) != "undefined") {
            $settings.placeholder = $this.attr("placeholder");
            $settings.id = "-1";
        }

        $this.select2($settings);

    });

    // $('.select2-selection').css('border', '0');
    // $('.select2-selection__arrow').css('height', '100%');

});