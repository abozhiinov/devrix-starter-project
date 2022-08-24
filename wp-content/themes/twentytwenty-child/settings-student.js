jQuery(document).ready(function($){
    $('.ajax-wrap :checkbox').on('click', function(e){
        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                'action' : 'ajax_func',
                'option' : $(this).attr('id'),
                'checked': $(this).prop('checked')
            },
            success: function(){}
        });
    });

    $('.student-status').on('click', function(e){
        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                'action' : 'update_student_status',
                'student-id' : $(this).attr('id'),
                'checked': $(this).prop('checked')
            },
            success: function(){}
        });
    });

    $('.dictionary-submit').click(function(e){
        e.preventDefault();
        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                'action' : 'search_oxford_dictionary',
                'word' : $('.dictionary-search').val(),
                'keep-time' : $('.dictionary-search-time').val()
            },
            success: function(result){ $('.result-data').html(result) }
        });
    });

    $('.show-more').on('click' ,function(e){
        e.preventDefault();
        $('.show-more').slideUp(500);
        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                'action' : 'student_show_more',
                'displayed' : $(this).attr('value1'),
                'found' : $(this).attr('value2')
            },
            success: function(result){ 
                $('.show-more-data').html(result); 
            } 
        });
    });

});