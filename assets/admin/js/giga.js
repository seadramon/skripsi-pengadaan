var globalUrl = "http://silver.dev/pengadaan/admpage/";
$(document).ready(function(){
    var globalUrl = "http://silver.dev/pengadaan/admpage/";
    var selector, elems, makeActive;

    selector = '#parent tr';

    elems = document.querySelectorAll(selector);

    makeActive = function () {
        for (var i = 0; i < elems.length; i++)
            elems[i].classList.remove('active');
        
        this.classList.add('active');
    };

    for (var i = 0; i < elems.length; i++) {
        elems[i].addEventListener('mousedown', makeActive);
    }

    // events
    $("#document_id_mReceipt").keypress(function(event){
        if (event.which == 13) {
            var docId = $("#document_id_mReceipt").val();
            if (docId!='') {
                var url = globalUrl + 'inventory/receipt/showData/' + docId;

                window.location.replace(url);
                return false;
            } else {
                return false;
            }
        }
    });

    /*DataTables*/
    $('#dataTable_id').DataTable( {
      "pageLength": 10
    } );

    /*Permintaan form*/
        bookIndex = 0;
        $('#permintaanForm')
        // Add button click handler
        .on('click', '.addButtonPermintaan', function() {
            var maxBook = $("#maxbookIndex").val();
            if (maxBook > 0) {
                bookIndex = maxBook;
                $("#maxbookIndex").val("cukkk");
            }
            bookIndex++;
            var $template = $('#permintaanTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true
            });
            // Update the name attributes
            $clone
                .find('[name="idbarang_Clone"]').attr('name', 'idbarang_'+  bookIndex).end()
                .find('[name="cariBrg"]').attr('onClick', 'targetitem = document.permintaanForm.idbarang_'+ bookIndex +';dataitem = window.open("' + globalUrl + 'showtable/barang", "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem').end()
                .find('[name="jumlah"]').attr('name', 'dpermintaan[' + bookIndex + '][jumlah]').end()
                .find('[name="tanggal_pengiriman"]').attr('name', 'dpermintaan[' + bookIndex + '][tanggal_pengiriman]').end()
                .find('[name="keterangan"]').attr('name', 'dpermintaan[' + bookIndex + '][keterangan]').end();
        })

        // Remove button click handler
        .on('click', '.removeButtonPermintaan', function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');
            $row.remove();
        });
    /*End Permintaan Form*/

    /*ORDER PEMBELIAN*/
        bookIndex = 0;
        urutan = 1;
        $('#fpo')
        // Add button click handler
        .on('click', '.addButtonPO', function() {
            var maxBook = $("#maxbookIndex").val();
            if (maxBook > 0) {
                bookIndex = maxBook;
                urutan++;
                $("#maxbookIndex").val("cukkk");
            }
            bookIndex++;
            urutan++;
            var $template = $('#poTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true
            });
            // Update the name attributes
            $clone
                .find('[name="idbarang"]').attr({'name' : 'dpo[' + bookIndex + '][idbarang]', 'id': 'idbarang_' + bookIndex}).end()
                .find('[name="crBrg"]').attr('onClick', 'selectBarangminta("idbarang_'+ bookIndex +'-jumlah_' + bookIndex + '")').end()
                .find('[name="jumlah"]').attr({'name' : 'dpo[' + bookIndex + '][jumlah]', 'id': 'jumlah_' + bookIndex}).end()
                .find('[name="harga_satuan"]').attr({'name' : 'dpo[' + bookIndex + '][harga_satuan]', 'onkeyup': 'subtotalPo(this, "jumlah_' + bookIndex + '", "jumlahharga_' + bookIndex + '")'}).end()
                .find('[name="jumlah_harga"]').attr({'name' : 'dpo[' + bookIndex + '][jumlah_harga]', 'id':'jumlahharga_' + bookIndex}).end()
                .find('[name="tanggal_pengiriman"]').attr('name', 'dpo[' + bookIndex + '][tanggal_pengiriman]').end()
                .find('[name="keterangan"]').attr('name', 'dpo[' + bookIndex + '][keterangan]').end();
        })

        // Remove button click handler
        .on('click', '.removeButtonPO', function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');
            $row.remove();
        });
        /*End Order Pembelian Form*/

        /*Penerimaan form*/
        bookIndex = 0;
        $('#penerimaanForm')
        // Add button click handler
        .on('click', '.addButtonPenerimaan', function() {
            var maxBook = $("#maxbookIndex").val();
            if (maxBook > 0) {
                bookIndex = maxBook;
                $("#maxbookIndex").val("cukkk");
            }
            bookIndex++;
            var $template = $('#penerimaanTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true
            });
            // Update the name attributes
            $clone
                .find('[name="idbarang"]').attr({'name' : 'dpenerimaan[' + bookIndex + '][idbarang]', 'id': 'idbarang_' + bookIndex}).end()
                .find('[name="crBrg"]').attr('onClick', 'selectBarangpo("idbarang_'+ bookIndex +'-jumlahhide_' + bookIndex + '")').end()
                .find('[name="jumlahhide"]').attr({'name' : 'dpenerimaan[' + bookIndex + '][jumlahhide]', 'id': 'jumlahhide_' + bookIndex}).end()
                .find('[name="jumlah"]').attr({'name' : 'dpenerimaan[' + bookIndex + '][jumlah]', 'id': 'jumlah_' + bookIndex}).end()
        })

        // Remove button click handler
        .on('click', '.removeButtonPenerimaan', function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');
            $row.remove();
        });
    /*End Penerimaan Form*/

    /*Barang keluar form*/
        bookIndex = 0;
        $('#fbarangkeluar')
        // Add button click handler
        .on('click', '.addButtonBarangkeluar', function() {
            var maxBook = $("#maxbookIndex").val();
            if (maxBook > 0) {
                bookIndex = maxBook;
                $("#maxbookIndex").val("cukkk");
            }
            bookIndex++;
            var $template = $('#barangkeluarTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true
            });
            // Update the name attributes
            $clone
                .find('[name="idbarang"]').attr({'name' : 'dbarangkeluar[' + bookIndex + '][idbarang]', 'id': 'idbarang_' + bookIndex}).end()
                .find('[name="crBrg"]').attr('onClick', 'selectBarangkeluar("idbarang_'+ bookIndex +'-jumlahhide_' + bookIndex + '")').end()
                .find('[name="jumlahhide"]').attr({'name' : 'dbarangkeluar[' + bookIndex + '][jumlahhide]', 'id': 'jumlahhide_' + bookIndex}).end()
                .find('[name="jumlah"]').attr({'name' : 'dbarangkeluar[' + bookIndex + '][jumlah]', 'id': 'jumlah_' + bookIndex}).end()
        })

        // Remove button click handler
        .on('click', '.removeButtonBarangkeluar', function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');
            $row.remove();
        });
    /*End Barang keluar Form*/

    // Pagination
    function bindClicks() {
      $("ul.tsc_pagination a").click(paginationClick);
    }

    function paginationClick() {
      var href = $(this).attr('href');
      $("#rounded-corner").css("opacity","0.4");


      $.ajax({
        type: "GET",
        url: href,
        data: {},
        success: function(response)
        {
          /*alert(response);*/
          $("#rounded-corner").css("opacity","1");
          $("#paginationID").html(response);
          bindClicks();
        }
      });

      return false;
    }

    bindClicks();
});

function selectBarangminta(idAttr) {
    var id = $("#idminta").val();

    window.open(globalUrl + 'showtable/barangminta/index/' + idAttr + '/' + id,'popuppage',
  'width=400,toolbar=1,resizable=1,scrollbars=yes,height=400,top=100,left=100');
}

function selectBarangpo(idAttr) {
    var id = $("#idpo").val();

    window.open(globalUrl + 'showtable/barangpo/index/' + idAttr + '/' + id,'popuppage',
  'width=400,toolbar=1,resizable=1,scrollbars=yes,height=400,top=100,left=100');
}

function selectBarangkeluar(idAttr) {
    var id = $("#idminta").val();

    window.open(globalUrl + 'showtable/barangkeluar/index/' + idAttr + '/' + id,'popuppage',
  'width=400,toolbar=1,resizable=1,scrollbars=yes,height=400,top=100,left=100');
}

function updateValue(id, value, idjml, valuejml) {
    document.getElementById(id).value = value;
    document.getElementById(idjml).value = valuejml;
}

function subtotalPo(idAttr, jml, tgtResult)
{
    var harga = idAttr.value;
    var jumlah = $("#" + jml).val();
    var result = (harga * jumlah).toString();
// alert(result);return false;
    $("#" + tgtResult).val(result.toString());
}

function clickRow(url) {
    var formURL = $(".clickRow").attr("url");

    $.ajax(
    {
        url: url,
        type: "GET",
        success: function(data, textStatus, jqXHR)
        {
            // alert(data);return false;
            $("#tableRelation").html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            $("#tableRelation").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
        }
    });

    return false;
}

function tMaterialAddDetail(param)
{
    var link = $("#linkDetail").attr("url") + param;
    var postData = $("#receipt_h").serializeArray();

    $.ajax({
        url: link,
        type: "POST",
        data: postData,
        success: function(data, textStatus, jqXHR)
        {
            /*alert(data);return false;*/
            var arrData = data.split("#");
            if (arrData[0]=="OK") {
                if (arrData[2]!="") {
                    window.location.href=arrData[2];
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            $("#tableRelation").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
        }
    });
}

function rowProductMReceipt(url)
{
    $.ajax(
    {
        url: url,
        type: "GET",
        success: function(data, textStatus, jqXHR)
        {
            // clear quantity input txt
            $(".qtycls").remove();

            var arrData = data.split("#");
            if (arrData[0] < 1) {
                $("#batch").hide();
            } else {
                $("#batch").show();
            }
            if (arrData[1] < 1) {
                $("#expired").hide();
            } else {
                $("#expired").show();
            }
            $("#produk_id").val(arrData[2]);
            $("#produk_name").val(arrData[3]);

            if (arrData.length == 5) {
                var qty = jQuery.parseJSON(arrData[4]);

                $.each(qty, function(i, item){
                    $("#qtyId").after('<div class="qtycls" id="' + qty[i].unit_id + '" class="form-group">' +
                                '<label for="' + qty[i].unit_id + '">' + qty[i].unit_id + '</label>' +
                                '<input type="text" class="form-control" name="qty[' + qty[i].unit_id + ']">' +
                            '</div>');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            $("#qtyId").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
        }
    });

    return false;
}

function searchProduct()
{
    var link = $("#fsearchProduct").attr("url");
    var postData = $("#fsearchProduct").serializeArray();
    // alert(link);return false;
    $.ajax(
    {
        url: link,
        type: "POST",
        data: postData,
        success: function(data, textStatus, jqXHR)
        {
            alert(data);
            $("#rounded-corner").css("opacity","1");
            $("#paginationID").html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            $("#tableRelation").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
        }
    });
}

function cekType(object) {
    var stringConstructor = "test".constructor;
    var arrayConstructor = [].constructor;
    var objectConstructor = {}.constructor;


    if (object === null) {
        return "null";
    }
    else if (object === undefined) {
        return "undefined";
    }
    else if (object.constructor === stringConstructor) {
        return "String";
    }
    else if (object.constructor === arrayConstructor) {
        return "Array";
    }
    else if (object.constructor === objectConstructor) {
        return "Object";
    }
    else {
        return "don't know";
    }
}
