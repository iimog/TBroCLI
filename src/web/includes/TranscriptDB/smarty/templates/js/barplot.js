var select_assay = $('#select-assay');
var select_acquisition = $('#select-acquisition');
var select_quantification = $('#select-quantification');
var select_analysis = $('#select-analysis');
var select_parent_biomaterial = $('#select-biomaterial');
var select_tissues = $('#select-sample');

var itemIDs;
var options;
var lastData;

//filteredSelect: select_assay => select_analysis => select_tissues
new filteredSelect(select_acquisition, 'acquisition', {
    precedessorNode: select_assay
});
new filteredSelect(select_quantification, 'quantification', {
    precedessorNode: select_acquisition
});
new filteredSelect(select_analysis, 'analysis', {
    precedessorNode: select_quantification
});
new filteredSelect(select_parent_biomaterial, 'parent_biomaterial', {
    precedessorNode: select_analysis
});
new filteredSelect(select_tissues, 'sample', {
    precedessorNode: select_parent_biomaterial
});

function populateBarplotSelectionBoxes(items, opt) {
    options = $.extend(true, {type: "isoform"}, opt);
    itemIDs = items;
    if (options.type === 'isoform')
        $('#isoform-barplot-button').prop('checked', true);
    else
        $('#unigene-barplot-button').prop('checked', true);
    if (typeof items.unigene === 'undefined' || items.unigene.length === 0) {
        $('#isoform-barplot-button').prop('checked', true);
        $('#unigene-isoform-switch').attr('disabled', 'disabled');
        $('#isoform-barplot-button').attr('disabled', 'disabled');
        $('#unigene-barplot-button').attr('disabled', 'disabled');
        options.type = "isoform";
    }
    if (typeof items.isoform === 'undefined' || items.isoform.length === 0) {
        $('#unigene-barplot-button').prop('checked', true);
        $('#unigene-isoform-switch').attr('disabled', 'disabled');
        $('#isoform-barplot-button').attr('disabled', 'disabled');
        $('#unigene-barplot-button').attr('disabled', 'disabled');
        options.type = "unigene";
    }
    $.ajax('{#$ServicePath#}/listing/filters_expression', {
        method: 'post',
        data: {
            organism: organism.val(),
            release: release.val()
        },
        success: function (data) {
            var filterdata = data;
            new filteredSelect(select_assay, 'assay', {
                data: filterdata,
            }).refill();
            if (typeof lastData !== 'undefined') {
                $("#select-assay option").filter(function () {
                    return $.inArray($(this).val(), lastData.assay) !== -1;
                }).prop('selected', true).trigger('selectionChanged');
                $("#select-analysis option").filter(function () {
                    return $.inArray($(this).val(), lastData.analysis) !== -1;
                }).prop('selected', true).trigger('selectionChanged');
                if (lastData.biomaterial.length > 0) {
                    $("#select-sample option").prop('selected', false);
                }
                $("#select-sample option").filter(function () {
                    return $.inArray($(this).val(), lastData.biomaterial) !== -1;
                }).prop('selected', true).trigger('selectionChanged');
            }
        }
    });
}

//get selected filters as collection

function getFilterData() {
    var data = {
        parents: itemIDs[options.type],
        analysis: select_analysis.find(':selected').val(),
        quantification: select_quantification.find(':selected').val(),
        biomaterial: []
    };
    select_tissues.find(':selected').each(function () {
        data.biomaterial.push($(this).val());
    });
    lastData = data;
    return data;
}

//display barplot
$('#button-draw-plot').click(function () {
    if ($('#button-barplot').is(':checked')) {
        drawBarplot();
    } else {
        drawHeatmap();
    }
    $('#button-draw-plot').removeClass("alert");
    $('#button-draw-plot').text("Draw");
    $('#isoform-barplot-groupByTissues').removeAttr('disabled');
    $('#isoform-barplot-groupByTissues-on').removeAttr('disabled');
    $('#isoform-barplot-groupByTissues-off').prop("checked", true);
    $('#isoform-barplot-transpose-off').prop("checked", true);
});

function drawBarplot() {
    $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
        method: 'post',
        data: getFilterData(),
        success: function (val) {
            $('#isoform-barplot-panel').show(0);
            var parent = $("#isoform-barplot-canvas-parent");

            //if we already have an old canvas, we have to clean that up first
            var canvas = $('#isoform-barplot-canvas');
            var cx = canvas.data('canvasxpress');
            if (cx != null) {
                cx.destroy();
                parent.empty();
            }

            canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
            parent.append(canvas);
            canvas.attr('width', parent.width() - 8);
            canvas.attr('height', 500);

            window.location.hash = "isoform-barplot-panel";

            val.y.names = [];
            for (var i = 0; i < val.y.data.length; i++) {
                val.y.names[i] = val.y.vars[i];
                var meta = cart._getMetadataForContext()[val.y.ids[i]];
                if (typeof meta !== 'undefined') {
                    if (typeof meta['alias'] !== 'undefined')
                        val.y.vars[i] = meta['alias'];
                }
            }

            cx = new CanvasXpress(
                    "isoform-barplot-canvas",
                    {
                        "x": val.x,
                        "y": val.y
                    },
            {
                graphType: "Bar",
                showDataValues: true,
                // plotByVariable: true,
                graphOrientation: "vertical"
            });

            canvas.data('canvasxpress', cx);

            groupByTissues();

            addTable(parent, val);
        }
    });
    return false;
}

function drawHeatmap() {
    $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
        method: 'post',
        data: getFilterData(),
        success: function (val) {
            $('#isoform-barplot-panel').show(0);
            var parent = $("#isoform-barplot-canvas-parent");

            //if we already have an old canvas, we have to clean that up first
            var canvas = $('#isoform-barplot-canvas');
            var cx = canvas.data('canvasxpress');
            if (cx != null) {
                cx.destroy();
                parent.empty();
            }

            canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
            parent.append(canvas);
            canvas.attr('width', parent.width() - 8);
            canvas.attr('height', 500);

            window.location.hash = "isoform-barplot-panel";

            val.y.names = [];
            for (var i = 0; i < val.y.data.length; i++) {
                val.y.names[i] = val.y.vars[i];
                var meta = cart._getMetadataForContext()[val.y.ids[i]];
                if (typeof meta !== 'undefined') {
                    if (typeof meta['alias'] !== 'undefined')
                        val.y.vars[i] = meta['alias'];
                }
            }

            cx = new CanvasXpress(
                    "isoform-barplot-canvas",
                    {
                        "x": val.x,
                        "y": val.y
                    },
            {
                graphType: "Heatmap",
                showDataValues: true,
                graphOrientation: "vertical",
                zoomSamplesDisable: true,
                zoomVariablesDisable: true
            });

            canvas.data('canvasxpress', cx);
            groupByTissues();

            addTable(parent, val);
        }
    });
    return false;
}

function addTable(parent, val) {
    var tbl = $('<table id="expression_table"></table>');
    // y.smps = tissues
    // y.vars = names
    // y.data = data

    var tblColumns = [{sTitle: 'id', bVisible: false}, {sTitle: 'ID'}, {sTitle: 'Alias'}];
    for (var x = 0; x < val.y.smps.length; x++)
        tblColumns.push({sTitle: val.y.smps[x]});

    var tblData = [];
    for (var i = 0; i < val.y.data.length; i++) {
        for (var j = 0; j < val.y.data[i].length; j++) {
            val.y.data[i][j] = Math.round(val.y.data[i][j]);
        }
        var alias = "";
        var meta = cart._getMetadataForContext()[val.y.ids[i]];
        if (typeof meta !== 'undefined') {
            if (typeof meta['alias'] !== 'undefined')
                alias = meta['alias'];
        }
        var row = [val.y.ids[i], val.y.names[i], alias];
        Array.prototype.push.apply(row, val.y.data[i]);
        tblData.push(row);
    }


    parent.append(tbl);
    tbl.dataTable(
            {
                aoColumns: tblColumns,
                aaData: tblData,
                sScrollX: "100%",
                bScrollCollapse: true,
                bFilter: false,
                bInfo: false,
                bPaginate: false,
                sDom: 'T<"clear">lfrtip',
                oTableTools: {
                    aButtons: [],
                    sRowSelect: "multi"
                },
                fnCreatedRow: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:first', nRow).html(sprintf('<a href="{#$AppPath#}/details/byId/%s" target=”_blank”>%s</a>', aData[0], aData[1]))
                    $(nRow).attr('data-id', aData[0]);
                    $(nRow).draggable({
                        appendTo: "body",
                        helper: function () {
                            var helper = $(nRow).find('td:first').clone().addClass('beingDragged');
                            TableTools.fnGetInstance('expression_table').fnSelect($(nRow));
                            var selectedItems = TableTools.fnGetInstance('expression_table').fnGetSelectedData();
                            var selectedIDs = $.map(selectedItems, function (val) {
                                return val[0];
                            });
                            $(nRow).attr('data-id', selectedIDs);
                            if (selectedIDs.length > 1) {
                                helper.html("<b>" + selectedIDs.length + "</b> " + helper.text() + ", ...");
                            }
                            return helper;
                        },
                        cursorAt: {top: 5, left: 30}
                    });
                }
            }

    );
}

//group by tissues button clicked
function groupByTissues() {
    var checkbox = $('#isoform-barplot-groupByTissues-on');
    var cx = $('#isoform-barplot-canvas').data('canvasxpress');
    if (checkbox.is(':checked')) {
        cx.groupSamples(["Tissue_Group"]);
    } else {
        cx.groupSamples([]);
    }
}

$('#isoform-barplot-button').click(function () {
    populateBarplotSelectionBoxes(itemIDs, $.extend(true, options, {type: "isoform"}));
});

$('#unigene-barplot-button').click(function () {
    populateBarplotSelectionBoxes(itemIDs, $.extend(true, options, {type: "unigene"}));
});

$('#isoform-barplot-groupByTissues').click(groupByTissues);

$('#isoform-barplot-transpose').click(function () {
    var cx = $('#isoform-barplot-canvas').data('canvasxpress');
    cx.transpose();
    if ($('#isoform-barplot-transpose-on').is(':checked')) {
        $('#isoform-barplot-groupByTissues-off').prop("checked", true);
        $('#isoform-barplot-groupByTissues').attr('disabled', 'disabled');
        $('#isoform-barplot-groupByTissues-on').attr('disabled', 'disabled');
    }
    else {
        $('#isoform-barplot-groupByTissues').removeAttr('disabled');
        $('#isoform-barplot-groupByTissues-on').removeAttr('disabled');
    }
});

$("#radio").buttonset();