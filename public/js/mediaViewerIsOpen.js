/*$( document ).ready(function() {
    $(document).keydown(function(evt) {
        switch (evt.keyCode) {
            case 37:
                $('#previousMediaLink')[0].click();
                break;
            case 39:
                $('#nextMediaLink')[0].click();
                break;
        }
    });    
});

jQuery(function($) {
    
    $("#previousMediaLink").on('click', function(event){
        event.preventDefault();
        $.post("add", {id: $('#mediaElement').attr("alt")},
            function(data){
                if(data.response == true){
                    alert(window.location.href);
                    //$('#mediaElement').attr("src","/" + data.dataPath);
                // print success message
                } else {
                    // print error message
                    console.log('could not add');
                }
            }, 'json');
    });
    
    $('#previousMediaLink').on('click', function(event){
        var id = $('#mediaElement').attr("src");
        event.preventDefault();
        $.post("getPreviousMedia", {
            id: id
        },function(data){
            if (data.response == true){
                alert("ok");
            // print success message
            } else {
                // print error message
                console.log('could not add');
            }
        }, 'json');

    });
    
});*/

    /*
    $('#previousMediaLink').on('click', function(event){
        event.preventDefault();
        $.post(
            "media/getPreviousMedia", 
            {id: $('#mediaElement').attr("src")},
            function(data){
                alert(data.previousMedia);
                if(data.response == true){
                    alert(data.previousMedia);
                    //$('#mediaElement').attr("src", data.nextImage);
                // print success message
                } else {
                    // print error message
                    alert('ajax error');
                }
            }, 
            'json'
        );
    });*/
    /*        
    $('#previousMediaLink').on('click', function(event){
        var myData = "name=William Adama&alias=Husker&job=Commander of the Colonial Fleet";
        $.ajax({
            type: "POST",
            url: "progress",
            data: myData,
            success: function() {
                alert("AJAX call a success!");
            },
            error: function() {
                  alert("AJAX call an epic failure");
            }
        });
        return false;

    });
    */
    /*    
        $("#create").on('click', function(event){
            event.preventDefault();
            var $stickynote = $(this);
            $.post("stickynotes/add", null,
                function(data){
                    if(data.response == true){
                        $stickynote.before("<div class=\"sticky-note\"><textarea id=\"stickynote-"+data.new_note_id+"\"></textarea><a href=\"#\" id=\"remove-"+data.new_note_id+"\"class=\"delete-sticky\">X</a></div>");
                    // print success message
                    } else {
                        // print error message
                        console.log('could not add');
                    }
                }, 'json');
        });

        $('#sticky-notes').on('click', 'a.delete-sticky',function(event){
            event.preventDefault();
            var $stickynote = $(this);
            var remove_id = $(this).attr('id');
            remove_id = remove_id.replace("remove-","");

            $.post("stickynotes/remove", {
                id: remove_id
            },
            function(data){
                if(data.response == true)
                    $stickynote.parent().remove();
                else{
                    // print error message
                    console.log('could not remove ');
                }
            }, 'json');
        });

        $('#sticky-notes').on('keyup', 'textarea', function(event){
            var $stickynote = $(this);
            var update_id = $stickynote.attr('id'),
            update_content = $stickynote.val();
            update_id = update_id.replace("stickynote-","");

            $.post("stickynotes/update", {
                id: update_id,
                content: update_content
            },function(data){
                if(data.response == false){
                    // print error message
                    console.log('could not update');
                }
            }, 'json');

        });

    */    