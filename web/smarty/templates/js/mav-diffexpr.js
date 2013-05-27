$(document).ready(function() {
    
    var select_features = $('#select-dfx-features');
    var select_analysis = $('#select-dfx-analysis');
    var select_sampleA = $('#select-dfx-sampleA');
    var select_sampleB = $('#select-dfx-sampleB');
    
    new filteredSelect(select_analysis, 'analysis', {
        precedessorNode: select_features
    });
    
    new filteredSelect(select_sampleA, 'ba', {
        precedessorNode: select_analysis
    });
    
    new filteredSelect(select_sampleB, 'bb', {
        precedessorNode: select_sampleA
    });
    
    
    $.ajax('{#$ServicePath#}/listing/filters_diffexp/', {
        method: 'post',
        data: {
            ids: _.map(cartitems, function(item){
                return item.feature_id;
            })
        },
        success: function(data) {
            filterdata = data;
            _.each(cartitems, function(value, key, list){
                filterdata.data.feature[value.feature_id] = value;
            });
            new filteredSelect(select_features, 'feature', {
                data: filterdata
            }).refill();
        }
    });
    
    
    var filters = {};
    
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "natural-asc": function ( a, b ) {
            return alphanum(a,b);
        },
 
        "natural-desc": function ( a, b ) {
            return alphanum(a,b) * -1;
        },
        "scientific-pre": function ( a ) {
            if (a=='Inf') return Infinity;
            if (a=='-Inf') return -Infinity;
            return parseFloat(a);
        },
 
        "scientific-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
 
        "scientific-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );
        
    $.fn.dataTableExt.afnFiltering.push(
        function( oSettings, aData, iDataIndex ) {
            for (var i=0; i<aData.length; i++){
                var filter = filters[i];
                if (filter == undefined || filter.type == undefined) continue;
                if (filter.value=='') continue;
                
                var val = aData[i];
                switch (filter.type){
                    case 'contains':
                        if (!(val.indexOf(filter.value) !== -1)) return false;
                        break;
                    case 'lt':
                        if (!(parseFloat(val) < parseFloat(filter.value))) return false;
                        break;
                    case 'gt':
                        if (!(parseFloat(val) > parseFloat(filter.value))) return false;
                        break;
                    case 'eq':
                        if (!(parseFloat(val) == parseFloat(filter.value))) return false;
                        break;
                }
            }
            return true;
        });
    
    var oTable;    
        
    $('#button-dfx-table').click(function(){
        $.ajax('{#$ServicePath#}/listing/differential_expressions', {
            method: 'post',
            data: {
                ids: select_features.val() || [],
                analysis: select_analysis.val(),
                sampleA: select_sampleA.val(),
                sampleB: select_sampleB.val()
            },
            success: function(data) {
                $('#div-dfxtable').show();
                if (oTable == null){
                    oTable = $('#diffexp').dataTable( {
                        bJQueryUI: true,
                        aaData: data.aaData,
                        bFilter: false, 
                        aoColumns: [
                        {
                            sType: "natural",
                            mData: 'name'
                        },
                        {
                            sType: "scientific",
                            mData: 'baseMean'
                        },
                        {
                            sType: "scientific",
                            mData: 'baseMeanA'
                        },
                        {
                            sType: "scientific",
                            mData: 'baseMeanB'
                        },
                        {
                            sType: "scientific",
                            mData: 'foldChange'
                        },
                        {
                            sType: "scientific",
                            mData: 'log2foldChange'
                        },
                        {
                            sType: "scientific",
                            mData: 'pval'
                        },
                        {
                            sType: "scientific",
                            mData: 'pvaladj'
                        },
                        ],
                        sDom: 'T<"clear">lfrtip',
                        oTableTools: {
                            sSwfPath: "{#$AppPath#}/swf/copy_csv_xls_pdf.swf"
                        }
                    } );
                } else {
                    /* Clear the old information from the table */
                    oTable.fnClearTable();
 
                    oTable.fnAddData( data.aaData );
 
                    oTable.fnDraw();
                 }
            }
        });
    });
    

        
        
    function update_filter() {
        /* Filter on the column (the index) of this element */
        var index = $(this).parent().parent().children().index($(this).parent());
        var oldfilters = filters;
        filters[index] = {
            type : $("tfoot select")[index].value,
            value: $("tfoot input")[index].value
        };
            
        if (!_.isEquals(oldfilters, filters))
            oTable.fnDraw();
    }
     
    $("tfoot input").keyup( update_filter);
    $("tfoot select").click( update_filter);
        
});