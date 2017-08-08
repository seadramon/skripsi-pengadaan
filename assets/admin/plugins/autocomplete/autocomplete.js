$('.login').click(function (e) {
    e.stopPropagation();
  });

$(function () {
    'use strict';

    var isvalid = true;
    var dataStore =  (function(){
        var json;
        var html;

        function load()
        {
            console.log('test');
            $.ajax({
                async: false,
                url: 'http://jayadata.com/silverqueen/uploads/documents/ref_kota.json',
                contentType: "application/json",
                type: 'GET',
                dataType: "json",
                success: function(data){html = data;},
                error: function(){
                    isvalid = false;
                    console.log('url not valid');
                }
            });
        }
        return{
            load : function(){
                if(html) return;
                load();
            },
            getHtml: function(){
                if(!html) load();
                return html;
            }
        }    
    })();

    var kota = dataStore.getHtml();
    var countriesArray = $.map(kota, function (value, key) { return { value: value, data: key }; });
    
    // Setup jQuery ajax mock:
    $.mockjax({
        url: '*',
        responseTime: 2000,
        response: function (settings) {
            var query = settings.data.query,
                queryLowerCase = query.toLowerCase(),
                re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi'),
                suggestions = $.grep(countriesArray, function (country) {
                     // return country.value.toLowerCase().indexOf(queryLowerCase) === 0;
                    return re.test(country.value);
                }),
                response = {
                    query: query,
                    suggestions: suggestions
                };

            this.responseText = JSON.stringify(response);
        }
    });

    // Initialize ajax autocomplete:
    $('#autocomplete-ajax').autocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: countriesArray,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
        onSelect: function(suggestion) {
            // $('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            $('#selction-ajax').val(suggestion.data);
        },
        onHint: function (hint) {
            $('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        }
    });
});