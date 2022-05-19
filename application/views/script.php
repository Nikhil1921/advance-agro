<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		setTimeout(function(){ $(".alert-messages").remove(); }, 3000);
		<?php if (isset($dataTables)): ?>
      	var table = $('.datatable').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, 100, -1 ],
                [ '10', '25', '50', '100', 'All' ]
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'print',
                    footer: true,
                    customize: function ( win ) {
                        $(win.document.body)
                            .prepend(
                                '<img src="<?= base_url('assets/images/watermark.png') ?>" style="position:absolute; height:100%; width:100%" />'
                            );
                    },
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'pdf',
                    pageSize: 'A4',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            columnDefs: [ {
                targets: -1,
                visible: false
            } ],
            "processing": true,
            "serverSide": true,
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': 'Processing',
                'paginate': {
                    'first': '|',
                    'next': '<i class="fa fa-arrow-circle-right"></i>',
                    'previous': '<i class="fa fa-arrow-circle-left"></i>',
                    'last': '|'
                }
            },
            "order": [],
            "ajax": {
                url: "<?= base_url($url) ?>",
                type: "POST",
                data: function(data) {
                    data.advance_agro_token = $('#advance_agro_token').val();
                    data.status = $('#status').val();
                    data.buyer_id = $('#buyer_id').val();
                    data.seller_id = $('#seller_id').val();
                    data.prod_id = $('#prod_id').val();
                    data.date_filter = $('#date_filter').val();
                },
                complete: function(response) {
                    var data = JSON.parse(response.responseText).advance_agro_token;
                    $('#advance_agro_token').val(data);
                },
            },
            "columnDefs": [{
                "targets": 'target',
                "orderable": false,
            },],
            "footerCallback": function ( row, data, start, end, display ) {
                if ("<?= $name ?>" == 'contract') {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over this page
                    pagePrice = api
                        .column( 8, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageBroke = api
                        .column( 10, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Update footer
                    $( api.column( 8 ).footer() ).html(
                        '₹'+(pagePrice / end).toFixed(2)
                    );
                    
                    $( api.column( 10 ).footer() ).html(
                        '₹'+pageBroke.toFixed(2)
                    );
                }
            }
        });

        $('#buyer_id, #seller_id, #prod_id, #date_filter').change(function(){
            table.ajax.reload();
        });

        $('.contract-status').click(function(e){
            e.preventDefault();
            if (!$(this).hasClass('active')) {
                $('#status').val($(this).html());
                $('.active').removeClass('active');
                $(this).addClass('active');
                table.ajax.reload();
            }
            return false;
        });

        <?php endif ?>

        $(".prod_id").change(function(){
            $.ajax({
                url:"<?= base_url($url) ?>/getSpecs/" + $(this).find(':selected').val(),
                type: "GET",
                success : function(data) {
                    $('.showSpecs').html(data);
                },
                error : function(request,error)
                {
                    console.log("Request: "+JSON.stringify(request));
                }
            });
        });

        $(".prod_id").trigger('change');

        <?php if (isset($dateFilter)): ?>
        $('#date_filter').daterangepicker();
        $('#create_date').datetimepicker({
            format: 'L'
        });
        <?php endif ?>

        $(".invoice-filter").change(function(){
            var dates = $(this).val();
            var table = '';
            var total = 0;
            if (dates) {
                $.ajax({
                    url:"<?= base_url($url) ?>/getData",
                    type: "POST",
                    data: {dates:dates, seller: "<?= $this->uri->segment(3) ?>"},
                    dataType: "JSON",
                    success : function(data) {
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                table += '<tr><td>'+(index+1)+'</td>';    
                                table += '<td>'+item.contact_id+'</td>';    
                                table += '<td>'+item.contract_date+'</td>';    
                                table += '<td>'+item.name+'</td>';
                                table += '<td>'+item.quantity+'</td>';    
                                table += '<td>₹ '+item.price+'</td>';    
                                table += '<td>₹ '+item.brokerage+'</td>';    
                                table += '</tr>';
                                total += parseFloat(item.brokerage);
                            });
                            $("#table-data").html(table);
                            $("#date-from").html('<tr><td colspan="5" class="text-center">'+'Date for : '+dates+'</td><td class="text-center">Total :</td><td class="text-center">₹ '+total.toFixed(2)+'</td></tr>');
                        }else{
                            table += '<tr><td colspan="7" class="text-center">No data available</td></tr>';
                            $("#table-data").html(table);
                            $("#date-from").html('<tr><td colspan="5" class="text-center">'+'Date for : '+dates+'</td><td class="text-center">Total :</td><td class="text-center">₹ '+total.toFixed(2)+'</td></tr>');
                        }
                    },
                    error : function(request,error)
                    {
                        console.log("Request: "+JSON.stringify(request));
                    }
                });
            }else{
                table += '<tr><td colspan="7" class="text-center">No data available</td></tr>';
                $("#table-data").html(table);
                $("#date-from").html('<tr><td colspan="5" class="text-center">'+'Date for : '+dates+'</td><td class="text-center">Total :</td><td class="text-center">₹ '+total.toFixed(2)+'</td></tr>');
            }
        });

        $(".invoice-filter").trigger('change');
	});
  
    function uploadCertificate(id) {
        $("#contract_id").val(id);
        $("#uploadCertificate").modal();
    }

    function remove(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will be deleted from your data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) $('#'+id).submit();
      })
    }
    
    function addSpec()
    {
        var spec = $('.specifications').length + 1;

        $('#addSpec').append('<div class="col-md-5 specifications specification_'+spec+'"> <div class="form-group"> <label for="specification_'+spec+'">Product Specification</label> <input type="text" name="specification[]" class="form-control" id="specification_'+spec+'" placeholder="Enter Specification"> </div></div><div class="col-md-1 specification_'+spec+'"> <button type="button" onclick="removeSpec(\'specification_'+spec+'\')" class="btn btn-outline-danger mt-2">Remove Specification</button> </div>');
    }

    function removeSpec(specs)
    { 
      $('.'+specs).remove();
    }

    function getContract(id)
    { 
        var contract_id = [], opt;
        var len = id.options.length;
        for (var i = 0; i < len; i++) {
            opt = id.options[i];
            if (opt.selected)
                contract_id.push(opt.value);
        }
        var table = '';
        var total = 0;
        if (contract_id.length > 0) {
            $.ajax({
                url:"<?= base_url($url) ?>/getContract",
                type: "POST",
                data: {contract_id:contract_id},
                dataType: "JSON",
                success : function(data) {
                    if (data.length > 0) {
                        $.each(data, function(index, item) {
                            table += '<tr><td>'+(index+1)+'</td>';    
                            table += '<td>'+item.contact_id+'</td>';    
                            table += '<td>'+item.contract_date+'</td>';    
                            table += '<td>'+item.name+'</td>';
                            table += '<td>'+item.quantity+'</td>';    
                            table += '<td>₹ '+item.price+'</td>';    
                            table += '<td>₹ '+item.brokerage+'</td>';    
                            table += '</tr>';
                            total += parseFloat(item.brokerage);
                        });
                        $("#table-data").html(table);
                        $("#date-from").html('<tr><td colspan="5" class="text-center"></td><td class="text-center">Total :</td><td class="text-center">₹ '+total.toFixed(2)+'</td></tr>');
                    }else{
                        table += '<tr><td colspan="7" class="text-center">No data available</td></tr>';
                        $("#table-data").html(table);
                        $("#date-from").html('<tr><td colspan="5" class="text-center"></td><td class="text-center">Total :</td><td class="text-center">₹ '+total.toFixed(2)+'</td></tr>');
                    }
                },
                error : function(request,error)
                {
                    console.log("Request: "+JSON.stringify(request));
                }
            });
        }else{
            table += '<tr><td colspan="7" class="text-center">No data available</td></tr>';
            $("#table-data").html(table);
            $("#date-from").html('<tr><td colspan="5" class="text-center"></td><td class="text-center">Total :</td><td class="text-center">₹ '+total.toFixed(2)+'</td></tr>');
        }
    }

    // getContract(document.getElementById('contract_id'));
</script>