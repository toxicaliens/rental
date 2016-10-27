
//get patients details and load them
$( "select.patient" ).select2({
    ajax: {
        url: "?num=835",
        dataType: 'json',
        delay: 10,
        data: function (params) {
            return {
                q: params.term // search term
            };
        },
        processResults: function (data) {
            // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data
            return {
                results: data
            };
        },
        cache: true
    },
    minimumInputLength: 1
});