<?php if(!isset($order->id)) {
    echo "Invalid Order";
    exit();
}
?>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form action="" id="form_cmr_from_api" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="{{ $order->id }}" name="id">

            <div class="row">
                <div class="col-md-12">
                    <b>INTERNATIONAL CONSIGNMENT NOTE</b><br>
                    This carriage is subject, notwithstanding any clause to the contrary, to the Convention on the
                    Contract of the International Carriage of Goods by Road (CMR)
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmr_sender">1. Sender</label>
                        <span style="font-weight:bold;">{{ isset($order->pickup_partner->company_name) ? $order->pickup_partner->company_name : '' }}</span><br>
                        <textarea id="cmr_sender" name="sender" placeholder="name, address, country" class="form-control">{{ isset($order->cmr->sender) ? $order->cmr->sender : '' }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmr_consignee">2. Consignee</label>
                        <span
                            style="font-weight:bold;">{{ isset($order->delivery_partner->company_name) ? $order->delivery_partner->company_name : '' }}</span><br>
                        <textarea id="cmr_consignee" name="consignee" placeholder="name, address, country" class="form-control">{{ isset($order->cmr->consignee) ? $order->cmr->consignee : '' }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmr_place_of_delivery_goods">3. Place of delivery of the goods</label>
                        <span
                            style="font-weight:bold;">{{ isset($order->delivery_partner->address) ? $order->delivery_partner->address : '' }}</span><br>
                        <textarea id="cmr_place_of_delivery_goods" name="place_of_delivery_goods" placeholder="address, country" class="form-control">{{ isset($order->cmr->place_of_delivery_goods) ? $order->cmr->place_of_delivery_goods : '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cmr_goods_taking_over">4. Place of taking over the goods</label>
                        <textarea id="cmr_goods_taking_over" value="{{ $order->place_of_taking_goods }}" placeholder="address, country" class="form-control">{{ isset($order->cmr->place_of_taking_goods) ? $order->cmr->place_of_taking_goods : '' }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="cmr_doc_attached_group" label="5. Documents attached:" label-for="cmr_doc_attached">
            
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top:20px;">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-secondary">
                                <th scope="col">6. Marks and numbers</th>
                                <th scope="col">7. Number of packages</th>
                                <th scope="col">8. Method of packing</th>
                                <th scope="col">9. Nature of the goods</th>
                                <th scope="col">10. Statistical number</th>
                                <th scope="col">11. Gross weight in kg</th>
                                <th scope="col">12. Volume in eur/ldm/m³</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($order->goods))
                            @foreach($order->goods as $value_goods)
                            <tr>
                                <td scope="row">{{ isset($order->reference) ? $order->reference : '' }}</td>
                                <td>{{ $value_goods->pieces }}</td>
                                <td>
                                    <span style="font-weight:bold;">{{ isset($value_goods->pieces_unit->name) ? $value_goods->pieces_unit->name : '' }}</span>
                                </td>
                                <td>{{ $value_goods->description }}</td>
                                <td>{{ $value_goods->marks }}</td>
                                <td>{{ $value_goods->kg_calc }}</td>
                                <td>{{ $value_goods->unit }} <span style="font-weight:bold;">{{ isset($value_goods->unit_type->name) ? $value_goods->unit_type->name : '' }}</span></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cmr_sender_instructions">13. Sender's instruction</label>
                        <textarea id="cmr_sender_instructions" value="{{ $order->sender_instruction }}" placeholder="Sender's instruction"  class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cmr_return">14. Return</label>
                        <textarea id="cmr_return" value="{{ $order->return }}" placeholder="Return"  class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cmr_instruction_of_carriage">15. Instructions as to payment of carriage</label>
                        <textarea id="cmr_instruction_of_carriage" value="{{ $order->payment_of_carriage_instruction }}" placeholder="Instructions as to payment of carriage" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cmr_carrier">16. Carrier</label>
                        <span style="font-weight:bold;">{{ isset($order->customer_partner->company_name) ? $order->customer_partner->company_name : '' }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cmr_successive_carrier">17. Carrier</label>
                        <span style="font-weight:bold;">{{ isset($order->carrier_partner->company_name) ? $order->carrier_partner->company_name : ''  }} {{ isset($order->carrier_partner->address) ? $order->carrier_partner->address : ''  }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cmr_taking_over_the_goods">18. Place of taking over the goods</label>
                        <b>{{ $order->order_id }}</b> <span style="font-weight:bold;">{{ isset($order->order_master->order_id) ? $order->order_master->order_id : ""  }}</span>
            
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="cmr_to_be_paid_by">19. To be payed by</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-secondary">
                                    <th scope="col"></th>
                                    <th scope="col">Sender</th>
                                    <th scope="col">Currency</th>
                                    <th scope="col">Consignee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row" nowrap>Carriage charges</td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->carriage_charges->sender) ? $order->carriage_charges->sender : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->carriage_charges->currency) ? $order->carriage_charges->currency : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->carriage_charges->consignee) ? $order->carriage_charges->consignee : ''  }}"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" nowrap>Deduction</td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->deduction->sender) ? $order->deduction->sender : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->deduction->currency) ? $order->deduction->currency : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->deduction->consignee) ? $order->deduction->consignee : ''  }}"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" nowrap>Balance</td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->balance->sender) ? $order->balance->sender : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->balance->currency) ? $order->balance->currency : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->balance->consignee) ? $order->balance->consignee : ''  }}"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" nowrap>Supplier charges</td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->supplier_charges->sender) ? $order->supplier_charges->sender : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->supplier_charges->currency) ? $order->supplier_charges->currency : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->supplier_charges->consignee) ? $order->supplier_charges->consignee : ''  }}"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" nowrap>Other</td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->other->sender) ? $order->other->sender : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->other->currency) ? $order->other->currency : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->other->consignee) ? $order->other->consignee : ''  }}"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" nowrap>Total</td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->total->sender) ? $order->total->sender : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->total->currency) ? $order->total->currency : ''  }}"></input>
                                    </td>
                                    <td>
                                        <input class="form-control" value="{{ isset($order->total->consignee) ? $order->total->consignee : ''  }}"></input>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cmr_to_be_paid_by">20. Other agreements</label>
                        <textarea id="cmr_other_agreements" value="{{ $order->other_agreements }}" placeholder="Other agreements" class="form-control"></textarea>
                    </div>
            
                    <div class="form-group">
                        <label for="cmr_established_id">21. Established in</label>
                          <span style="font-weight:bold;">{{ isset($order->pickup_partner->address) ? $order->pickup_partner->address : '' }} {{ $order->pickup_date }}</span>
            
                    </div>
            
                    <div class="form-group">
                        <label for="cmr_arriving_to_take_load">22. Arriving to take the load on</label>
                            <span style="font-weight:bold;">{{ $order->pickup_date }}</span>
                    </div>
            
                    <div class="form-group">
                        <label for="cmr_to_be_paid_by">25. </label>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Truck:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Semitrailer:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Container:</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            
                    <div class="form-group">
                        <label for="cmr_arriving_to_take_load">26. </label>
                    </div>
            
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="margin:auto; padding:auto; text-align:center;">
                    <a href="javascript:;" class="btn btn-primary" onclick="download_pdf({{ $order->id }})" style="margin-right:20px;">Ava CMR</a>
                    <input type="submit" class="btn btn-warning" value="Save CMR">
                </div>
            </div>

        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


<script>
$(document).ready(function(){


    $("#form_cmr_from_api").on("submit", function(event){
        event.preventDefault();
 
        var formValues = $(this).serialize();
 
        $.ajax({
            url: "http://ship.ismail/api/v1/user/orders/cmr/update",
            type: 'POST',
            data: formValues,
            // Fetch the stored token from localStorage and set in the header
            headers: {"Authorization": 'Bearer <?=$token?>' }
        });


    });

});

// function download_pdf(order_id) {

//     $.get("http://ship.ismail/api/v1/user/orders/cmr/download/" + order_id, function(data){
//         window.open(
//             data.pdf,
//             '_blank' // <- This is what makes it open in a new window.
//         );

//     });

// }

function download_pdf(order_id) {

    $.ajax({
        url: "http://ship.ismail/api/v1/user/orders/cmr/download/" + order_id,
        type: 'GET',
        // Fetch the stored token from localStorage and set in the header
        headers: {"Authorization": 'Bearer <?=$token?>' },
        success: function(data) {
            window.open(
                data.pdf,
                '_blank' // <- This is what makes it open in a new window.
            );
        }});

}


</script>

</html>
