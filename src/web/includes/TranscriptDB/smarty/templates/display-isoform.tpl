{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    {#call_webservice path="details/isoform" data=["query1"=>$isoform_feature_id] assign='data'#}

    <script type="text/javascript" src="{#$AppPath#}/js/canvasXpress.min.js"></script>
    <!-- use chrome frame if installed and user is using IE -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <script type="text/javascript">
        var feature_id = '{#$data.isoform.feature_id#}';

        $(document).ready(function () {
            $('.tabs').tabs();

            $('#Cart').on('cartEvent', function (event) {
                if (!((event.eventData.action || '').match(/updateItem/) || ((event.eventData.action || '').match(/(add|remove)Item/)) || ((event.eventData.action || '').match(/redraw/)))) {
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
                $('#user-alias-textfield').text(alias);
                if (alias === "") {
                    $('#user-alias-table').hide();
                }
                else {
                    $('#user-alias-table').show();
                }
                $('#user-description-textfield').text(description);
                if (description === "") {
                    $('#user-description-table').hide();
                }
                else {
                    $('#user-description-table').show();
                }
                updateContainingCartsSection();
            });

            // "genome browser" graph
            $.ajax('{#$ServicePath#}/graphs/genome/isoform/' + feature_id, {
                success: function (val) {
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
                open: function (event, ui) {
                    ui.tooltip.css("max-width", "600px");
                },
                content: function () {
                    var element = $(this);
                    var tooltip = $("<table/>");

                    //build a table over all "data-" attributes.
                    $.each(this.attributes, function (key, attr) {
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
                helper: function () {
                    return $('<div>', {text: $('.isoform-header').text()}).addClass('beingDragged');
                },
                cursorAt: {top: 5, left: 5}
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
            $.each(cfc, function (key, attr) {
                if (_.indexOf(attr.items, {#$data.isoform.feature_id#}) !== -1)
                    hits.push(key);
            });
            $('#containing-carts-section').empty();
            if (hits.length === 0) {
                $('#containing-carts-table').hide();
            } else {
                $.each(hits, function (id, attr) {
                    $('#containing-carts-section').append('<tr><td><a href="/graphs/' + attr + '">' + attr + '</a></td></tr>');
                });
                $('#containing-carts-table').show();
            }
        }

        function annotateElement() {
            var id = {#$data.isoform.feature_id#};
            var name = "{#$data.isoform.name#}";
            var description = "";
        {#if isset($data.isoform.description) #}
            var description = "{#$data.isoform.description[0].value#}";
        {#/if#}
            cart._getItemDetails([id], function (data) {
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
            {#if isset($data.isoform.unigene)#}
                <h4>Corresponding Unigene</h4>
                <table style="width:100%">
                    <tbody>
                        <tr><td><a href="{#$AppPath#}/details/byId/{#$data.isoform.unigene.feature_id#}">{#$data.isoform.unigene.uniquename#}</a></td></tr>
                    </tbody>
                </table>
            {#/if#}
            <h4>Containing Carts</h4>
            <table style="width:100%" id="containing-carts-table">
                <tbody id="containing-carts-section">

                </tbody>
            </table>
            <h4>User Alias <a class="cart-button-rename" title="Change Annotation" onclick="annotateElement();" href="#"><img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/> </a></h4>
            <table style="width:100%" id="user-alias-table">
                <tbody>
                    <tr>
                        <td id='user-alias-textfield'> </td>
                    </tr>
                </tbody> 
            </table>
            <h4>User Description <a class="cart-button-rename" title="Change Annotation" onclick="annotateElement();" href="#"><img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/> </a></h4>
            <table style="width:100%" id="user-description-table">
                <tbody>
                    <tr>
                        <td id="user-description-textfield"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {#include file="display-components/synonym.tpl" feature=$data.isoform #}
    {#if isset($data.isoform.description) #}
        <div class="row">
            <div class="large-12 columns panel">
                <h4>DB Description</h4>
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
            <div class="left"><h4>Sequence</h4></div><div class="right"><a target="_blank" href="http://blast.ncbi.nlm.nih.gov/Blast.cgi?PROGRAM=blastn&PAGE_TYPE=BlastSearch&QUERY=>{#$data.isoform.name#}%0A{#$data.isoform.residues#}" class="button">blastn @ NCBI</a></div>
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
            $(document).ready(function () {
            {#include file="js/barplot.js"#}
                setTimeout(function () {
                    populateBarplotSelectionBoxes({isoform: [{#$data.isoform.feature_id#}], unigene: [{#if isset($data.isoform.unigene)#}{#$data.isoform.unigene.feature_id#}{#/if#}]}, {type: "isoform"});
                }, 800);
            });
        </script>
        <div class="large-12 columns panel">
            <h4>Expression Analysis</h4>
            {#include file="display-components/barplot.tpl"#}
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns panel">
            <h4>Differential Expression Analysis</h4>
            {#include file="display-components/feature_diffexp.tpl"#}
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

{#/block#}
