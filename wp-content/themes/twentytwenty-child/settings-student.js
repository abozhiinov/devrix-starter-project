jQuery(document).ready(function($){

    $('input:checkbox').on('click', function(e){
        console.log($(this).id);
        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                'action' : 'ajax_func',
                'option' : $(this).attr('id'),
                'checked': $(this).prop('checked')
            },
            success: function(){
                //alert($(this));
            }
        });

    });

});