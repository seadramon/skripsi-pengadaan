$(document).ready(function() {
    bookIndex = 0;
    $('#bookForm')
        // Add button click handler
        .on('click', '.addButton', function() {
            bookIndex++;
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);

            // Update the name attributes
            $clone
                .find('[name="nama"]').attr('name', 'user[' + bookIndex + '][nama]').end()
                .find('[name="email"]').attr('name', 'user[' + bookIndex + '][email]').end()
                .find('[name="role"]').attr('name', 'user[' + bookIndex + '][role]').end();
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');
            $row.remove();
        });

    // datepicker
    $(".datepicker_now").datepicker({
        dateFormat:'dd-mm-yy'
    });

    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            orientation: "left",
            autoclose: true
        });
    }

    $('input[name="daterange"]').daterangepicker();

    if (jQuery().timepicker) {
        $('.timepicker-default').timepicker({
            autoclose: true,
            showSeconds: true,
            minuteStep: 1
        });

        $('.timepicker-no-seconds').timepicker({
            autoclose: true,
            minuteStep: 5
        });

        $('.timepicker-24').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
            showMeridian: false
        });

        // handle input group button click
        $('.timepicker').parent('.input-group').on('click', '.input-group-btn', function(e){
            e.preventDefault();
            $(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
        });
    }

    $('#dropPostCheck').on('change', function(e) {
        $('#dropoff-location').slideToggle("fast");

        
        if (this.value=='bisa') {
            $('#dropoff-location').show();
            $('#non-dropoff-location').hide();
        } else {
            $('#dropoff-location').hide();
            $('#non-dropoff-location').show();
        }
        
    });
});

function tambah(val)
{
    if (val=='07895928-7e9f-4338-88f6-88da04d75512') {

    }
}

// KEBUTUHAN
function quantityNeed(qty)
{
    var harga = $('#harga_satuan').val();
    var qty = qty;

    if (harga!='') {
        var total = qty*harga;
        // alert(format(total));
        // $("#unit_price").val(format(total));
        $("#unit_price").val(total);
    }
}

function unitprice(harga)
{
    var qty = $('#quantity').val();
    var harga = harga;

    if (qty!='') {
        var total = qty*harga;
        // alert(format(total));
        // $("#unit_price").val(format(total));
        $("#unit_price").val(total);
    }
}

var format = function(num){
    var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ",") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(".");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return("Rp "  + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};
// END KEBUTUHAN



