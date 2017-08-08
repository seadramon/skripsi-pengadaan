function select_record(val)
{
    var temp_id = document.getElementById('temp_id');
    var frm = $('#record-'+val);
    var chk = document.getElementById('del'+val);
    if(chk.checked == true)
    {
        frm
            .css({
                backgroundColor:'#fb3',
                width:frm.width(),
                height:frm.height()
            });

        temp_id.value += val+"-";
    }
    else
    {
        frm
            .css({
                backgroundColor:'',
                width:frm.width(),
                height:frm.height()
            });
        temp_id.value = temp_id.value.replace(val+'-','');
    }
}

function select_record_uuid(val)
{
    var temp_id = document.getElementById('temp_id');
    var frm = $('#record-'+val);
    var chk = document.getElementById('del'+val);
    if(chk.checked == true)
    {
        frm
            .css({
                backgroundColor:'#fb3',
                width:frm.width(),
                height:frm.height()
            });

        temp_id.value += val+";";
    }
    else
    {
        frm
            .css({
                backgroundColor:'',
                width:frm.width(),
                height:frm.height()
            });
        temp_id.value = temp_id.value.replace(val+';','');
    }
}

function explode( delimiter, string, limit )
{
    var emptyArray = {
        0: ''
    };

    // third argument is not required
    if ( arguments.length < 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }

    if ( delimiter === ''
        || delimiter === false
        || delimiter === null )
    {
        return false;
    }

    if ( typeof delimiter == 'function'
        || typeof delimiter == 'object'
        || typeof string == 'function'
        || typeof string == 'object' )
    {
        return emptyArray;
    }

    if ( delimiter === true )
    {
        delimiter = '1';
    }

    if (!limit)
    {
        return string.toString().split(delimiter.toString());
    }
    else
    {
        // support for limit argument
        var splitted = string.toString().split(delimiter.toString());
        var partA = splitted.splice(0, limit - 1);
        var partB = splitted.join(delimiter.toString());
        partA.push(partB);
        return partA;
    }
}

function delete_records(url,redirect)
{
    var temp_id = document.getElementById('temp_id');
    var answer = confirm("Are you sure to delete this record ??");
    if(answer)
    {
        var exp = explode("-",temp_id.value);
        for(var i=0;i<(exp.length-1);i++)
        {
            var frm = $('#record-'+exp[i]);
            //e.preventDefault();
            $.ajax({
                type: 'post',
                data: 'id='+exp[i],
                url: url + '/delete'
            },frm.fadeOut(1000,function() {
                frm.remove();
            }));
        }
        setTimeout("window.location=' "+ redirect +"'",1000);
    }
}

function checkedAll (id, checked)
{
    var el = document.getElementById(id);
    var temp_id = document.getElementById('temp_id');
    var frm = document.getElementById("primary_check");
    if (frm.checked == true) checked = true;
    else checked = false;
    temp_id.value = '';

    for (var i = 0; i < el.elements.length; i++) {
        var d = el.elements[i].parentNode;

        var frm = $("#record-"+el.elements[i].value);

        if (el.elements[i].type == "checkbox" && el.elements[i].value > 0) {
            el.elements[i].checked = checked;
            if(checked == true) {
                d.className += ' checked';
                temp_id.value += el.elements[i].value+"-";
            } else {
                d.className = '';
                temp_id.value = '';
            }
        }
    }
}

function checkedAll_uuid (id, checked)
{
    var el = document.getElementById(id);
    var temp_id = document.getElementById('temp_id');
    var frm = document.getElementById("primary_check");
    if (frm.checked == true) checked = true;
    else checked = false;
    temp_id.value = '';

    for (var i = 0; i < el.elements.length; i++) {
        var d = el.elements[i].parentNode;
        var frm = $("#record-"+el.elements[i].value);

        if (el.elements[i].type == "checkbox" && el.elements[i].value.length > 0) {
            el.elements[i].checked = checked;
            if(checked == true) {
                d.className += ' checked';
                temp_id.value += el.elements[i].value+";";
            } else {
                d.className = '';
                temp_id.value = '';
            }
        }
    }
}

function delete_records_uuid(url,redirect)
{
    var temp_id = document.getElementById('temp_id');
    var answer = confirm("Are you sure to delete this record ??");
    if(answer)
    {
        var exp = explode(";",temp_id.value);
        for(var i=0;i<(exp.length-1);i++)
        {
            var frm = $('#record-'+exp[i]);
            //e.preventDefault();
            $.ajax({
                type: 'post',
                data: 'id='+exp[i],
                url: url + '/delete'
            },frm.fadeOut(1000,function() {
                frm.remove();
            }));
        }
        setTimeout("window.location=' "+ redirect +"'",1000);
    }
}

/**
 *@author Faisal Latada mac_@gxrg.org
 *@description Get xml http object (AJAX)
 *@param {void}
 *@return {object} object xml http request
 */
function GetXmlHttpObject()
{
    var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

/**
 *@author Faisal Latada mac_@gxrg.org
 *@description Change sort to up / down
 *@param {int} current position
 *@param {int} id record
 *@param {int} id parent record
 *@param {string} direction to sort
 *@param {string} url action to did the task
 */
function change_sort(urut,id,id_parent,direction,url)
{
    var frm = $('#record-'+id)
    $.ajax({
        type: 'POST',
        data: 'id='+id+'&parent_id='+id_parent+'&urut='+urut+'&direction='+direction,
        url: url + '/change_sort/'
    },frm.fadeOut(1000,function() {
        frm.remove();
    }));
    setTimeout("window.location=' "+ url +" '",1000);
}

$(document).ready(function(){
    $(".plus-panel").click(function(){
        $(".plus-panel").hide();
        $(".min-panel").show();

        //$('#panel-form').fadeIn('slow');
        $('#panel-form').animate({
            opacity:'toggle',
            height:'toggle'
        });
    });
    $(".min-panel").click(function(){
        $(".min-panel").hide();
        $(".plus-panel").show();

        //$('#panel-form').fadeOut('slow');
        $('#panel-form').animate({
            opacity:'toggle',
            height:'toggle'
        });
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

    //WYSIWYG Editor
    //$('.summernote').summernote({height: 300});

    //Confirmation Alert
    $.confirm.options = {
        text: "Apakah data yang anda input telah benar?",
        title: "Confirmation required",
        confirmButton: "Yes",
        cancelButton: "Cancel",
        post: false,
        confirmButtonClass: "btn-success",
        cancelButtonClass: "btn-default"
    };

    $('.confirm').confirm({
        confirm: function() {
            $("[id|='form']").submit();
        }
    });

    $('.confirm-link').confirm({
        text: "Apakah anda yakin ingin merubah status user ini?",
        title: "Confirmation required",
        confirmButton: "Yes",
        cancelButton: "No",
        post: false,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default"
    });

    $('.confirm-resend').confirm({
        text: "Apakah anda yakin ingin email kepada user ini?",
        title: "Confirmation required",
        confirmButton: "Yes",
        cancelButton: "No",
        post: false,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default"
    });

    $('.confirm-broadcast').confirm({
        text: "Apakah anda yakin ingin mengirim pesan kepada semua peserta?",
        title: "Confirmation required",
        confirmButton: "Yes",
        cancelButton: "No",
        post: false,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default"
    });

});