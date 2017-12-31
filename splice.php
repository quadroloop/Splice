" editor.getValue();
    http.send(file);
  }
}

function refresh_output() {
     var file_name_to_save = document.getElementById("cfile").value;
      document.getElementById("frame_data").src=file_name_to_save;
}
/*file script tree*/
$(document).ready( function() {

    $( '#container' ).html( '<ul class="filetree start"><li class="wait">'   'Generating Tree...'   '<li></ul>' );
    
    getfilelist( $('#container') , './' );
    
    function getfilelist( cont, root ) {
    
        $( cont ).addClass( 'wait' );
            
        $.post( 'splice_dir_mapper.php', { dir: root }, function( data ) {
    
            $( cont ).find( '.start' ).html( '' );
            $( cont ).removeClass( 'wait' ).append( data );
            if( './' == root ) 
                $( cont ).find('UL:hidden').show();
            else 
                $( cont ).find('UL:hidden').slideDown({ duration: 500, easing: null });
            
        });
    }
    
    $( '#container' ).on('click', 'LI A', function() {
        var entry = $(this).parent();
        
        if( entry.hasClass('folder') ) {
            if( entry.hasClass('collapsed') ) {
                        
                entry.find('UL').remove();
                getfilelist( entry, escape( $(this).attr('rel') ));
                entry.removeClass('collapsed').addClass('expanded');
            }
            else {
                
                entry.find('UL').slideUp({ duration: 500, easing: null });
                entry.removeClass('expanded').addClass('collapsed');
            }
        } else {
            $( '#selected_file' ).text( "File:  "   $(this).attr( 'rel' ));
        }
    return false;
    });
    
});

/*limonte-sweet-alert2.min/js*/
!function(n,t){"object"==typeof exports