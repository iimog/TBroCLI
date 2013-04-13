
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Transcript Browser - dionaea muscipula</title>

        <link rel="stylesheet" href="{#$AppPath#}/css/normalize.css" />
        <link rel="stylesheet" href="{#$AppPath#}/css/foundation.css" />
        <!--link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" /-->    
        <link type="text/css" href="{#$AppPath#}/css/custom-theme/jquery-ui-1.10.2.custom.css" rel="Stylesheet" />    

        <!--script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script-->
        <script type="text/javascript" src="{#$AppPath#}/js/jquery-1.9.1.min.js"></script>
        <!--script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script-->
        <script type="text/javascript" src="{#$AppPath#}/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/foundation.min.js"></script>        
        <script type="text/javascript" src="{#$AppPath#}/js/jquery.webStorage.min.js"></script>        
        <script type="text/javascript" src="{#$AppPath#}/js/underscore-min.js"></script>



        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
                var species = $('#select_species');
                var dataset = $('#select_dataset');
                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function(request, response) {
                        $.ajax({
                            url: "{#$ServicePath#}/listing/searchbox/",
                            data: {species: species.val(), dataset: dataset.val(), term: request.term},
                            dataType: "json",
                            success: function(data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        window.location.href = '{#$AppPath#}/' + ui.item.value;
                    }
                });
                $("#search_unigene").data("ui-autocomplete")._renderItem = function(ul, item) {
                    return $("<li>")
                            .append("<a href='{#$AppPath#}/"+item.type+"-details/byId/"+item.id+"'><span style='display:inline-block; width:100px'>"+item.type+"</span>" + item.name+ "</a>")
                            .appendTo(ul);
                };
                ;
                /*$('#search_unigene').keydown(function(event) {
                    //Enter
                    if (event.which == 13) {
                        event.preventDefault();
                        $.ajax({
                            url: "{#$ServicePath#}/listing/unigenes/" + $(this).val(),
                            dataType: "json",
                            success: function(data) {
                                if (data.results.length == 1) {
                                    window.location.href = '{#$AppPath#}/unigene-details/' + data.results[0];
                                }
                            }
                        });
                    }
                });*/

            });</script>
        <style>
            .ui-tooltip-content table{
                margin-bottom: 0px;
            }
        </style>

        {#block name='head'#}{#/block#}

    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
                <ul class="title-area">
                    <li class="name">
                        <h1><a>Transcript Browser: dionaea muscipula</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="right">
                        <li class="divider"></li>
                        <li><a>search for unigene:</a></li>
                        <li><a><select id="select_species" style="display:inline"><option value="13">D. muscipula</option></select></a></li>
                        <li><a><select id="select_dataset"><option value="2013-04-13">2013-04-13</option></select></a></li>
                        <li class="has-form"><input type="search" id="search_unigene"/></li>
                        <li>&nbsp;</li> 
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row large-12 columns" style="padding: 0px;">
            {#block name='body'#}{#/block#}
        </div>

    </body>
</html>

