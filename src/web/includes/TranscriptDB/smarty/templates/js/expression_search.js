var diffexpSelectedIDs = [];
var lastQueryData;

$(document).ready(function () {
    var select_assay = $('#expression-select-gdfx-assay');
    var select_acquisition = $('#expression-select-gdfx-acquisition');
    var select_quantification = $('#expression-select-gdfx-quantification');
    var select_analysis = $('#expression-select-gdfx-analysis');
    var select_parent_biomaterial = $('#expression-select-gdfx-biomaterial');
    var select_sample = $('#expression-select-gdfx-sample');

    //filteredSelect: select_conditionA => select_conditionB => select_analysis

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

    var finalSelect = new filteredSelect(select_sample, 'sample', {
        precedessorNode: select_parent_biomaterial
    });

    select_assay.change(update_biomaterial_filters);
    select_analysis.change(update_biomaterial_filters);

    function update_biomaterial_filters() {
        $('#biomaterial-expression-filters').empty();
        setTimeout(function () {
            $("#expression-select-gdfx-biomaterial option").each(function ()
            {
                var template = _.template($('#template_biomaterial_filter').html());
                $('#biomaterial-expression-filters').append(template({name: $(this).text(), id: $(this).val()}));
                // add $(this).val() to your list
            });
        }, 800);

    }

    release.change(function () {
        var url = '{#$ServicePath#}/listing/filters_expression';
        var data = {
            organism: organism.val(),
            release: release.val()
        };
        $.ajax(url, {
            method: 'post',
            data: data,
            success: function (data) {
                new filteredSelect(select_assay, 'assay', {
                    data: data
                }).refill();
                $('#expression-button-gdfx-table').prop('disabled', false);
                $('#expression-button-gdfx-table-export').prop('disabled', false);
                update_biomaterial_filters();
            }
        });
    });

    var expressionTable;
    $('#expression-button-gdfx-table').click(function () {
        //show loading badge
        $.when($('#expression-div-gdfxtable').hide(500)).then(function () {
            if (!$('#expression-div-gdfxtable').is(':visible')) {
                $('.loading').show();
            }
        });
        lastQueryData = getQueryData();
        $.ajax('{#$ServicePath#}/listing/expressions/fullRelease', {
            method: 'post',
            data: lastQueryData,
            success: function (data) {
                var start = new Date().getTime();
                addTable(data);
                var end = new Date().getTime();
                var time = end - start;
                console.log('Execution time: ' + time);
                $('.loading').hide();
                $('#expression-div-gdfxtable').show();
                $('#expression-results').dataTable().fnAdjustColumnSizing();
            },
            error: function (data, err) {
                $('.loading').hide();
                alert("An error occured while loading data: " + err);
            }
        });
    });

    $('#expression-button-gdfx-table-export').click(function () {
        //show info
        $.when($('#expression-div-gdfxtable').hide(500)).then(function () {
            alert("It can take some time before the download dialog appears. Please be patient and do not repeatedly click the button.");
        });
        lastQueryData = getQueryData();
        var iframe = document.createElement('iframe');
        iframe.style.height = "0px";
        iframe.style.width = "0px";

        if (typeof lastQueryData !== 'undefined') {
            iframe.src = "{#$ServicePath#}/listing/expressions/releaseCsv" + "?" + $.param(lastQueryData);
            document.body.appendChild(iframe);
        }
    });

    function getQueryData() {
        var selected = finalSelect.filteredData();

        var biomaterialFilters = {};
        $("#biomaterial-expression-filters select").each(function ()
        {
            var id = $(this).attr("biomaterial-id");
            var val = $(this).val();
            biomaterialFilters[id] = {type: val};
        });
        $("#biomaterial-expression-filters input").each(function ()
        {
            var id = $(this).attr("biomaterial-id");
            var val = $(this).val();
            biomaterialFilters[id].value = val;
        });

        return {
            organism: organism.val(),
            release: release.val(),
            quantification: selected.values[0].quantification,
            analysis: selected.values[0].analysis,
            biomaterial: $.map(selected.values, function (n) {
                return n.sample
            }),
            currentContext: organism.val() + '_' + release.val(),
            mainFilterAllType: $('#expressions_filter_all_type').val(),
            mainFilterAllValue: $('#expressions_filter_all_value').val(),
            mainFilterOneType: $('#expressions_filter_one_type').val(),
            mainFilterOneValue: $('#expressions_filter_one_value').val(),
            mainFilterMeanType: $('#expressions_filter_mean_type').val(),
            mainFilterMeanValue: $('#expressions_filter_mean_value').val(),
            biomaterialFilters: biomaterialFilters
        };
    }

    function download_csv() {
        var iframe = document.createElement('iframe');
        iframe.style.height = "0px";
        iframe.style.width = "0px";

        if (typeof lastQueryData !== 'undefined') {
            iframe.src = "{#$ServicePath#}/listing/expressions/releaseCsv" + "?" + $.param(lastQueryData);
            document.body.appendChild(iframe);
        }
    }

    $('#expression-download_csv_button').click(download_csv);

    $('#expression-diffexpr select').tooltip(metadata_tooltip_options({
        items: "option"
    }));
    $('#expression-query_details').tooltip(metadata_tooltip_options({
        items: ".has-tooltip"
    }));

    function addTable(data) {
        var tbl = $('#expression-results');
        // y.smps = tissues
        // y.vars = names
        // y.data = data

        if (typeof expressionTable !== 'undefined') {
            expressionTable.fnDestroy();
            tbl.empty();
        }

        var tblColumns = $.map(data.header, function (n, i) {
            return {sTitle: n, bVisible: i !== 0}
        });

        var tblData = data.data;
        //  for (var i = 0; i < val.y.data.length; i++) {
        //      for (var j = 0; j < val.y.data[i].length; j++) {
        //          val.y.data[i][j] = Math.round(val.y.data[i][j]);
        //      }
        //      var alias = "";
        //      var meta = cart._getMetadataForContext()[val.y.ids[i]];
        //      if (typeof meta !== 'undefined') {
        //          if (typeof meta['alias'] !== 'undefined')
        //              alias = meta['alias'];
        //      }
        //      var row = [val.y.ids[i], val.y.names[i], alias];
        //      Array.prototype.push.apply(row, val.y.data[i]);
        //      tblData.push(row);
        //  }


        expressionTable = tbl.dataTable(
                {
                    aoColumns: tblColumns,
                    aaData: tblData,
                    sScrollX: "100%",
                    bScrollCollapse: true,
                    bFilter: false,
                    bLengthChange: false,
                    sPaginationType: "full_numbers",
                    sDom: 'T<"clear">lfrtip',
                    bDestroy: true,
                    oTableTools: {
                        aButtons: [],
                        sRowSelect: "multi"
                    },
                    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        $('td:first', nRow).html(sprintf('<a href="{#$AppPath#}/details/byId/%s" target=”_blank”>%s</a>', aData[0], aData[1]))
                        $(nRow).attr('data-id', aData[0]);
                        $(nRow).draggable({
                            appendTo: "body",
                            helper: function () {
                                var helper = $(nRow).find('td:first').clone().addClass('beingDragged');
                                TableTools.fnGetInstance('expression-results').fnSelect($(nRow));
                                var selectedItems = TableTools.fnGetInstance('expression-results').fnGetSelectedData();
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
});