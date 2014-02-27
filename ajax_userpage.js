
// Let page load

// todo: how to make one such fn for each id in the table? selector of onclick function should be more general that a specific id.
//page is loaded after dom is ready. YUI table rendering must happen before this code is executed...
//$( window ).load(function()

        


$( document ).ready(function()
{
    $(".asyncload").on("refreshevent", function(){
        //alert("refreshevent");
        $(this).empty();
        $(this).append('<img id ="waiting" src="img/160.GIF"/>');
        
        var thediv= $(this); //TODO:fix
        $.get('table/tableFactory.php?type='+$(this).attr('tabletype')+"&userid="+userid+"&swid="+swid+"&targetuser="+targetuser+"&cmid="+cmid+"&courseid="+courseid , function(data) //gets table in html format pageid from pagelib.php: <script>var pageid =... </script>
            {
              //  alert("got response"+data);
            //this.hide?
            var stuff = $(data);
            //alert("ok0");
            thediv.empty();
            thediv.append(stuff);
            
            //alert("ok1");
            

            thediv.children(":first").dataTable({
            "sScrollY": "200px",
            "bPaginate": false,
            "bScrollCollapse": true,
            });
            //alert("ok3");
            //this.show?
            $(".socialwiki_unlikeimg").click(function()
                {   // pageid is encoded in the alt attribute
                var pageid = $(this).attr("alt").substring(10); //get the part of the id after "unlikeimg_"
                  // get url [, no data], success
                $.get("likeaj.php?pageid="+pageid , function(data) //gets pageid from pagelib.php: <script>var pageid =... </script>
                    {
            
                        $('.asyncload').trigger("refreshevent");
        
                    });
                });
            $(".socialwiki_likeimg").click(function()
                {
            // get url [, no data], success
                var pageid = $(this).attr("alt").substring(8); //get the part of the alt after "likeimg_"
            // get url [, no data], success
                $.get("likeaj.php?pageid="+pageid , function(data) //gets pageid from pagelib.php: <script>var pageid =... </script>
                {
                    $(".asyncload").trigger( "refreshevent");
                });
                });
            });


        
    });     //custom event

    $(".asyncload").trigger( "refreshevent");
    


    /*/render tables    
    $('.asyncload').dataTable({
        "sScrollY": "200px",
        "bPaginate": false,
        "bScrollCollapse": true,
        //"bProcessing": true,
        //"sAjaxSource": 'table/tableFactory.php?type='+$(this).attr('tabletype')+"&userid="+userid+"&swid"+swid //variables passed in <script>...</script> block
    });*/


    //$(".socialwiki_unlikeimg").click(function(){alert("click");});

    // every link of class "unlikelink"

});
