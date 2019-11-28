jQuery(document).ready(function(){
    jQuery(document).on('click', '#search', function () {
        jQuery.get('/search', function (data) {
            console.log(data[0]);
        })
    });

    jQuery(".export").on('click', function(event) {
        var args = [$('#resultsDiv>table'), 'data.csv'];
        exportTableToCSV.apply(this, args);
    });

    function exportTableToCSV($table, filename) {
        var $rows = $table.find('tr:has(td)'),

        // temp delimiter 
        tmpColDelim = String.fromCharCode(11), // vertical tab character
        tmpRowDelim = String.fromCharCode(0), // null character
  
        // actual delimiter chars for CSV
        colDelim = '","',
        rowDelim = '"\r\n"',
  
        csv = '"' + $rows.map(function(i, row) {
            var $row = $(row),
            $cols = $row.find('td');
            return $cols.map(function(j, col) {
                var $col = $(col),
                text = $col.text();
                return text.replace(/"/g, '""'); 
            }).get().join(tmpColDelim);
        }).get().join(tmpRowDelim)
        .split(tmpRowDelim).join(rowDelim)
        .split(tmpColDelim).join(colDelim) + '"';
  
        if (window.Blob && window.URL) {   
            var blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8'
            });
            var csvUrl = URL.createObjectURL(blob);
            jQuery(this).attr({
                'download': filename,
                'href': csvUrl
            });
        } else {
            var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
            jQuery(this).attr({
                'download': filename,
                'href': csvData,
                'target': '_blank'
            });
        }
    }
});