{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    {#call_webservice path="details/isoform" data=["query1"=>$isoform_feature_id] assign='data'#}

    <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
    <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
    <!-- use chrome frame if installed and user is using IE -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <script type="text/javascript">
        var feature_id = '{#$data.isoform.feature_id#}';

        $(document).ready(function() {
            $('.tabs').tabs();

            $('#Cart').on('cartEvent', function(event) {
                if (!((event.eventData.action || '').match(/updateItem/) || ((event.eventData.action || '').match(/(add|remove)Item/)))) {
                    return;
                }
                var metadata = cart._getMetadataForContext(cart.currentContext)['{#$data.isoform.feature_id#}'];
                var alias = "";
                var description = "";
                if (typeof metadata !== 'undefined') {
                    if (typeof metadata.alias !== 'undefined') {
                        alias = metadata.alias;
                    }
                    if (typeof metadata.annotations !== 'undefined') {
                        description = metadata.annotations;
                    }
                }
                $('#user-alias-textfield').val(alias);
                $('#user-description-textfield').val(description);
            });

            // "genome browser" graph
            $.ajax('{#$ServicePath#}/graphs/genome/isoform/' + feature_id, {
                success: function(val) {
                    canvas = $('#canvas_isoform');
                    canvas.attr('width', canvas.parent().width() - 8);
                    if (val.tracks.length == 0)
                        return;
                    new CanvasXpress(
                            "canvas_isoform",
                            {
                                "tracks": val.tracks
                            },
                    {
                        graphType: 'Genome',
                        useFlashIE: true,
                        backgroundType: 'gradient',
                        backgroundGradient1Color: 'rgb(0,183,217)',
                        backgroundGradient2Color: 'rgb(4,112,174)',
                        oddColor: 'rgb(220,220,220)',
                        evenColor: 'rgb(250,250,250)',
                        missingDataColor: 'rgb(220,220,220)',
                        setMin: val.min,
                        setMax: val.max
                    }
                    );
                }
            });

            $('.contains-tooltip').tooltip({
                items: ".has-tooltip",
                open: function(event, ui) {
                    ui.tooltip.css("max-width", "600px");
                },
                content: function() {
                    var element = $(this);
                    var tooltip = $("<table/>");

                    //build a table over all "data-" attributes.
                    $.each(this.attributes, function(key, attr) {
                        if (attr.name.substr(0, 5) == 'data-') {
                            var splitAt = attr.nodeValue.indexOf('|');
                            //everything left from the first | is row name
                            var name = attr.nodeValue.substr(0, splitAt);
                            //everything right of it is row value
                            var value = attr.nodeValue.substr(splitAt + 1);
                            if (value === '')
                                return; //skip empty values
                            $("<tr><td>" + name + "</td><td>" + value + "</td></tr>").appendTo(tooltip);
                        }
                    });
                    //apply styles
                    tooltip.foundation();
                    return tooltip;
                }
            });

            new Grouplist($('#button-isoform-addToCart-options'), cart, addSelectedToCart);
            $('#button-isoform-addToCart-options-newcart').click(addSelectedToCart);

            $('.isoform-header').draggable({
                appendTo: "body",
                helper: function() {
                    return $('<div>', {text: $('.isoform-header').text()}).addClass('beingDragged');
                },
                cursorAt: {top: 5, left: 5}
            });
            
            $('#user-alias-textfield').blur(function() {
                cart.updateItem({#$data.isoform.feature_id#}, {alias: $('#user-alias-textfield').val(), annotations: $('#user-description-textfield').val()});
            });
            
            $('#user-description-textfield').blur(function() {
                cart.updateItem({#$data.isoform.feature_id#}, {alias: $('#user-alias-textfield').val(), annotations: $('#user-description-textfield').val()});
            });

        });

        function addSelectedToCart() {
            var group = $(this).attr('data-value');
            if (group === '#new#')
                group = cart.addGroup();
            cart.addItem({#$data.isoform.feature_id#}, {
                groupname: group
            });
        }

        function updateContainingCartsSection() {
            var cfc = cart._getCartForContext();
            var hits = [];
            $.each(cfc, function(key, attr) {
                if (_.indexOf(attr.items, {#$data.isoform.feature_id#}) !== -1)
                    hits.push(key);
            });
            $('#containing-carts-section').empty();
            if (hits.length === 0) {
                $('#containing-carts-section').append('<li style="font-size:1.5em">No carts yet...</li>');
            } else {
                $.each(hits, function(id, attr) {
                    $('#containing-carts-section').append('<li style="font-size:1.5em"><a href="/graphs/' + attr + '">' + attr + '</a></li>');
                });
            }
        }
        
        function annotateElement() {
            var id = {#$data.isoform.feature_id#};
            var name = "{#$data.isoform.name#}";
            var description = "{#$data.isoform.description#}";
            cart._getItemDetails([id], function(data) {
                if (Object.keys(cart.metadata[cart.currentContext]).length >= cartlimits.max_annotations_per_context) {
                    if (typeof data[0].metadata.alias === 'undefined' && typeof data[0].metadata.annotations === 'undefined') {
                        $('#TooManyAnnotationsDialog').foundation('reveal', 'open');
                        return;
                    }
                }
                $("#dialog-edit-cart-item").data('id', id);
                $("#dialog-edit-cart-item").data('name', name);
                $("#dialog-edit-cart-item").data('description', description);
                $('#item-alias').val(data[0].metadata.alias || '');
                $('#item-annotations').val(data[0].metadata.annotations || '');
                $("#dialog-edit-cart-item").dialog("open");
            });
        }

    </script>
{#/block#}
{#block name='body'#}


    <div class="row">
        <script type="text/javascript">addNavAnchor('isoform-overview', 'Isoform Overwiev');</script>
        <div class="large-12 columns panel" id="description">
            <div class="row">
                <div class="large-12 columns">
                    <div class="left"><h1 class="isoform-header" data-id="{#$data.isoform.feature_id#}">{#$data.isoform.name#}</h1></div>
                    <div class="right">
                        <button class="large button dropdown" type="button" id="button-isoform-addToCart" data-dropdown="button-isoform-addToCart-options"> Add to Cart </button>
                        <ul id="button-isoform-addToCart-options" class="f-dropdown" data-dropdown-content>
                            <li id="button-isoform-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
                        </ul>
                    </div>
                </div>
            </div>
            <table style="width:100%">
                <tbody>
                    {#if isset($data.isoform.unigene)#}
                        <tr><td>Corresponding unigene</td><td><a href="{#$AppPath#}/details/byId/{#$data.isoform.unigene.feature_id#}">{#$data.isoform.unigene.uniquename#}</a></td></tr>
                            {#/if#}
                    <tr><td>Containing Carts</td><td><a data-reveal-id="myModal" href="#" onclick="updateContainingCartsSection();">Show</a></td></tr>
                    <tr><td>User Alias 
                        <a class="cart-button-rename" title="Change Annotation" onclick="annotateElement();" href="#"><img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/> </a>
                        </td><td><input id='user-alias-textfield'  type="text" class="text ui-widget-content ui-corner-all"  maxlength="{#$max_chars_user_alias#}"> </td></tr>
                    <tr><td>User Description</td><td><textarea id="user-description-textfield" class="text ui-widget-content ui-corner-all" maxlength="{#$max_chars_user_description#}"></textarea>
                            <div class="right"><small>Max. {#$max_chars_user_description#} characters</small></div></td></tr>

                </tbody>
            </table>
        </div>
    </div>

    {#include file="display-components/synonym.tpl" feature=$data.isoform #}
    {#if isset($data.isoform.description) #}
        <div class="row">
            <div class="large-12 columns panel">
                <h4>Description</h4>
                <table style="width:100%">
                    <tbody>
                        {#foreach $data.isoform.description as $description#}
                            <tr><td>{#$description.value#}</td></tr>
                        {#/foreach#}
                    </tbody>
                </table>
            </div>
        </div>
    {#/if#}
    {#include file="display-components/publication.tpl" feature=$data.isoform #}
    <script type="text/javascript">addNavAnchor('sequence-annotation', 'Sequence Annotation');</script>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Sequence</h4>
            <textarea style="height:100px;" id="sequence-isoform">>{#$data.isoform.name#}&#10;{#$data.isoform.residues#}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Sequence Annotation</h4>
            <canvas id="canvas_isoform" width="600"></canvas>
            <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
        </div>
    </div>

    {#include file="display-components/predpeps.tpl" feature=$data.isoform #}

    {#include file="display-components/dbxref.tpl" feature=$data.isoform #}

    {#include file="display-components/mapman.tpl" feature=$data.isoform #}

    {#include file="display-components/repeatmasker.tpl" feature=$data.isoform #}

    <script type="text/javascript">addNavAnchor('plot', 'Expression Analysis');</script>
    <div class="row">
        <script type="text/javascript">
            $(document).ready(function() {
            {#include file="js/barplot.js"#}
                populateBarplotSelectionBoxes({isoform: [{#$data.isoform.feature_id#}], unigene: [{#if isset($data.isoform.unigene)#}{#$data.isoform.unigene.feature_id#}{#/if#}]}, {type: "isoform"});
            });
        </script>
        <div class="large-12 columns panel">
            <h4>Expression Analysis</h4>
            {#include file="display-components/barplot.tpl"#}
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns panel">
            <h4>Import information</h4>
            <table style="width:100%">
                <tbody>
                    <tr><td>Imported into TBro</td><td>{#$data.isoform.timelastmodified#}</td></tr>
                    <tr><td>Release</td><td>{#$data.isoform.import#}</td></tr>
                    <tr><td>Organism</td><td>{#$data.isoform.organism_name#}</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="myModal" class="reveal-modal">
        <h2>This isoform is in the following carts:</h2>
        <ul id="containing-carts-section"></ul>
        <a class="close-reveal-modal">&#215;</a>
    </div>
{#/block#}
